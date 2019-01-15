---
id: 31
title: Jak nainstalovat extension do PHP ve Windows
---

Potřeboval jsem nainstalovat `php_ssh2` extension a byla to taková pruda, že než abych příště zas musel složitě hledat a poskládávat správné řešení, tak se s vámi podělím na blogu.

Lehký úvod k prostředí:

* mám Windows 8.1
* lokálně vyvíjím na XAMPPu
* XAMPP mám v c:\xampp (default)
* předpokládám, že jste se v tom nehrabali a cesty máte výchozí

Pokud máte přidanou cestu k PHP binárkám do cesty, tak byste měli mít k dispozici PECL.

```
λ where pecl
c:\xampp\php\pecl.bat
```

To by měla být preferovaná cesta, jak získávat extensions. Funguje podobně jako PEAR. Bohužel ne vždy úspěšně.

```
λ pecl install ssh2
No releases available for package "pecl.php.net/ssh2"
install failed
```

Protože se preferovaný postup nezdařil je čas na workaround. Pokud vyvíjíte na windows tak je <a href="http://windows.php.net">windows.php.net</a> váš nejlepší kamarád. Najdete tam (mimo jiné) <a href="http://windows.php.net/downloads/pecl/releases/">extensiony z PECLu zbuildnuté pro jednotlivé verze PHP</a> a jejich x86 a x64 verze. Správnou verzi zjistíte tak, že si zavoláte `phpinfo()` (resp. `php -i` v CLI) a najdete si `PHP Extension Build => API20121212,TS,VC11`. Z toho je vidět, že chcete verzi VC11, TS. Dále z `Architecture =&gt; x86` je patrné, že chcete x86 verzi. Pro mé PHP 5.5 je to tedy `php_ssh2-0.12-5.5-ts-vc11-x86.zip` (`nazev-verze-verzePHP-threadSafety-compiler-architecture.zip`)

Některé knihovny jsou jen jedno DLLko a tím to hasne. To DLLko je třeba nakopírovat do `c:\xampp\php\ext`. Druhý krok je jejich přidání do `c:\xampp\php\php.ini`:

```
extension=php_ssh2.dll
```

Pokud je extensiona jen jedno DLLko, tak máte hotovo. Stačí otočit apache a je to. V případě ssh2 je to ovšem komplikovanější. To má DLLka hned dvě. Jednak extension `php_ssh2.dll` a pak ještě `libssh2.dll`. První zmíněnou nakopírujeme podle plánu do `c:\xampp\php\ext`. S druhou je to ovšem komplikovanější. Některé návody radí dát ji do `c:\windows\system32` a pomocí `regsvc32 libssh2.dll` ji "zavést". To mi naprosto nefungovalo. Avšak stačilo nakopírovat `libssh2.dll` do složky `c:\xampp\php` (tj. vedle `php.exe`) a jede to jak po másle.

Doufám, že návod někomu pomůže a případně se podělte v komentářích na jaké další problémy jstes instalcí extensions ve Windows narazili.

