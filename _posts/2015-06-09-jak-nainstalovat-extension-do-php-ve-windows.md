---
layout: post
status: publish
comments: true
published: true
title: Jak nainstalovat extension do PHP ve Windows
date: '2015-06-09 10:24:54 +0200'
date_gmt: '2015-06-09 08:24:54 +0200'
categories:
- Uncategorized
tags:
- php
- problem
- windows
---

Potřeboval jsem nainstalovat <code>php_ssh2</code> extension a byla to taková pruda, že než abych příště zas musel složitě hledat a poskládávat správné řešení, tak se s vámi podělím na blogu.

Lehký úvod k prostředí:

<ul>
<li>mám Windows 8.1</li>
<li>lokálně vyvíjím na XAMPPu</li>
<li>XAMPP mám v c:\xampp (default)</li>
<li>předpokládám, že jste se v tom nehrabali a cesty máte výchozí</li>
</ul>

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

Protože se preferovaný postup nezdařil je čas na workaround. Pokud vyvíjíte na windows tak je <a href="http://windows.php.net">windows.php.net</a> váš nejlepší kamarád. Najdete tam (mimo jiné) <a href="http://windows.php.net/downloads/pecl/releases/">extensiony z PECLu zbuildnuté pro jednotlivé verze PHP</a> a jejich x86 a x64 verze. Správnou verzi zjistíte tak, že si zavoláte <code>phpinfo()</code> (resp. <code>php -i</code> v CLI) a najdete si `PHP Extension Build => API20121212,TS,VC11`. Z toho je vidět, že chcete verzi VC11, TS. Dále z <code>Architecture =&gt; x86</code> je patrné, že chcete x86 verzi. Pro mé PHP 5.5 je to tedy <code>php_ssh2-0.12-5.5-ts-vc11-x86.zip</code> (<code>nazev-verze-verzePHP-threadSafety-compiler-architecture.zip</code>)

Některé knihovny jsou jen jedno DLLko a tím to hasne. To DLLko je třeba nakopírovat do <code>c:\xampp\php\ext</code>. Druhý krok je jejich přidání do <code>c:\xampp\php\php.ini</code>:

```
extension=php_ssh2.dll
```

Pokud je extensiona jen jedno DLLko, tak máte hotovo. Stačí otočit apache a je to. V případě ssh2 je to ovšem komplikovanější. To má DLLka hned dvě. Jednak extension <code>php_ssh2.dll</code> a pak ještě <code>libssh2.dll</code>. První zmíněnou nakopírujeme podle plánu do <code>c:\xampp\php\ext</code>. S druhou je to ovšem komplikovanější. Některé návody radí dát ji do <code>c:\windows\system32</code> a pomocí <code>regsvc32 libssh2.dll</code> ji "zavést". To mi naprosto nefungovalo. Avšak stačilo nakopírovat <code>libssh2.dll</code> do složky <code>c:\xampp\php</code> (tj. vedle <code>php.exe</code>) a jede to jak po másle.

Doufám, že návod někomu pomůže a případně se podělte v komentářích na jaké další problémy jstes instalcí extensions ve Windows narazili.

