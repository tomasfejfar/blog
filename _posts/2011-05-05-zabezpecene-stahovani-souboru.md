---
layout: post
status: publish
published: true
title: Zabezpečené stahování souborů
date: '2011-05-05 18:00:11 +0200'
date_gmt: '2011-05-05 18:00:11 +0200'
categories:
- Uncategorized
tags:
- php
- tipy
---

Jistě jste se už setkali s problémem, že potřebujete zajistit, aby se nikdo nedostal k souborum v určite složce na webu. Ale někdy mu přístup chcete povolit. Šancí je, ošetřit přístup k souborům pomocí PHP. Standartne:

```php
<?php
$file = basename($file);
$filepath = $downloadFolder . '/' . $file;
// tady nějaký test, jestli je uživatel opravněn
header("Content-type: application/x-octet-stream");
header("Content-Disposition: attachment; filename=$file");
readfile($filepath);
```


Jenže na většině hostingů narazíte tady na nastavení [--memory_limit](http://cz2.php.net/manual/cs/ini.core.php#ini.memory-limit). Proto se musí použít drobný work-around:

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

