---
id: 2
title: Zabezpečené stahování souborů
---

Jistě jste se už setkali s problémem, že potřebujete zajistit, aby se nikdo nedostal k souborum v určité složce na webu. Ale někdy mu přístup chcete povolit. Šancí je, ošetřit přístup k souborům pomocí PHP. 

<a name="update2017"></a>
**Update 19.3.2017:** Dnes mi přišel mail, který reaguje na můj komentář na [blogu Jakuba Vrány](https://php.vrana.cz/stazeni-souboru-po-overeni-prav.php#d-6674). Původní odkaz už nefunguje, protože jsem přišel o doménu. Tak jsem se při té příležitosti rozhodl návod aktualizovat. 

Problém jde vyřešit mnohem snáz, než jsem ho řešil před pěti lety. Stačí vypnout output buffering pomocí `ob_end_clean()`. 
    
```php
<?php
// chrání proti directory traversal attack ('slozka/../../../tajny_soubor.txt')
$file = basename($file);

// sestavíme cestu k souboru
// VŠECHNY soubory v adresáři půjdou stahnout,
// takže tam nedávejte nic jiného
$filepath = $downloadFolder . '/' . $file;

// zkontrolujeme jestli má přístup - nějaká námi napsaná funkce
if (!isUserAllowedToDownloadCustomFunction()) {
	// vrátíme 404ku, aby se nedalo zjistit, jestli soubor neexistuje nebo k němu jen není přístup. 
	http_response_code(404);
}
ob_end_clean(); // <---- tohle vyřeší celý problém
header("Content-type: application/x-octet-stream");
header("Content-Disposition: attachment; filename=$file");
readfile($filepath);
```
Stále je však potřeba zamezit tomu, aby soubory ve složce byly vidět z venku. Buď složku dát mimo webroot (což často na hostingu nejde) nebo přístup k ní omezit pomocí nastavení `.htaccess`ve složce s downloady.
 
 ```
 <Files *>
 Order Deny,Allow
 Deny from All
 </Files>
 ```

-----
Kód níže je víc jak pět let starý. Dnes už to umím líp, ale nechávám ho tady pro inspiraci. 
```php
<?php
function readfile_chunked($filename, $retbytes = true)
{
    $chunksize = 1 * (1024 * 1024); // how many bytes per chunk
    $cnt = 0;
    $handle = fopen($filename, 'rb');
    if ($handle === false) {
        return false;
    }
    while (!feof($handle)) {
        $buffer = fread($handle, $chunksize);
        echo $buffer;
        ob_flush();
        flush();
        if ($retbytes) {
            $cnt += strlen($buffer);
        }
    }
    $status = fclose($handle);
    if ($retbytes && $status) {
        return $cnt; // return num. bytes delivered like readfile() does.
    }
    return $status;
}

```
Tenhle kód je k dispozici v <a href="http://cz2.php.net/readfile">diskuzi o readfile() na PHP.net</a> Jenže stále není vyhráno, protože stále může potenciální útočník zjistit název souboru a přistoupit k němu přímo. Tomu opět zamezíme poměrně jednoduchým nastavením.

Vytvoříme `.htaccess`, který dáme do složky s downloady.

```
<Files *>
Order Deny,Allow
Deny from All
</Files>
```

```
<Files ~ "\.php$">
Order Deny,Allow
Allow from all
</Files>
```
To zaručí, že pro všechny soubory bude odmítnut přístup (**Error 403 – Forbidden**), kromě těch s koncovkou `.php`. A je to. Ochránili jsme složku proti jakémukoli pokusu o získání jejího obsahu. Kromě přístupu přes FTP, samozřejmně.

**EDIT – BEZPEČNOSTNÍ DÍRA:** Se skriptu jsem našel bezpečnostní díru. A to, že skriuptem se dají získat i soubory \*.php z danného adresáře. To je třeba ošetřit podmínkou.

```php
if(strpos($file, '.php')){
    die('Pokus o zneužití');
}
```

**EDIT2 – Nefunkčnost v IE:** Zjistil jsem, že skript nefunguje ze záhadného důvodu v IE. Je třeba do hlavičky poslat ještě:

```php
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Transfer-Encoding: binary");;
header("Content-type: image/jpg"); // zde konkretni MIME-typ, ne stream.
```

