---
layout: post
status: publish
comments: true
published: true
title: Jak nastavit Git, SSH a bezpečný klíč na Windows 
date: '2017-04-04 00:00:00 +0200'
excerpt: Nastavit správně Git na Windows není úplně legrace, ale ukážu vám, jak na to. Na konci budete mít lepší a bezpečnější řešení, které zapadá do Windows ekosystému.   
---

Často vídám, že lidé na Windows používají privátní klíč bez hesla. To je podle mého celkem zásadní chyba. Privátní klíč je jako heslo. Heslo byste si nenapsali do texťáku a neuložili na disk. Nedělejte to ani s privátním klíčem! Myslím, že příčinou je, že na Windows není snadné nastavit autentizačního agenta, který si heslo bezpečně zapamatuje a vy ho pak zadáváte jen jednou při přihlášení. Chápu, že zadávat heslo pokaždé, když klíč použijete, je otrava. Proto si ukážeme, jak klíč nastavit tak, abyste to dělat nemuseli.  

Začneme tím, že si [stáhneme potřebné nástroje](http://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html) - `putty`, `plink`, `pageant` a `puttygen` (klidně stáhněte celý zip). Oficiální stránka vypadá trochu archaicky, ale nenechte se zastrašit. 

### Vygenerování klíče

Spusťte si `puttygen`.

![Image](/images/posts/git-ssh-key/puttygen.png)

Po spuštění si tlačítkem *Generate* vygenerujte klíč. Délka 2048 je pro současné použití dostačující. A měla by vám podle [keylength.com](https://www.keylength.com/en/compare/) bezpečně stačit minimálně na následujících deset let. 

Klíč používaný pouze k přihlašování musí být bezpečný jen v okamžiku přihlášení - tedy dnes, zítra a příštích pár let. Samotná komunikace už je šifrovaná symetrickou šifrou (typicky AES) s dočasným klíčem ([podrobnější vysvětlení](https://www.digitalocean.com/community/tutorials/understanding-the-ssh-encryption-and-connection-process)). Pokud přenášíte přes SSH třeba zálohu databáze, je riziko rozšifrování zachycené komunikace v horizontu desítek let závislé pouze na použité symetrické šifře, nikoli na vašem privátním klíči.  

**Pokročilé:** Pokud chcete být moderní, vygenerujte si ED25519 (novější a rychlejší eliptická křivka, v `putty` od [verze 0.68](http://www.chiark.greenend.org.uk/~sgtatham/putty/changes.html)) a jako fallback k tomu 4096bit RSA. Do agenta je pak načtete oba a když jim dáte stejné heslo, tak se oba odemknou najednou. Podle toho, jestli server podporuje ED25519 pak na server nahrajete jeden nebo druhý veřejný klíč. 

#### Načtení Putty klíče (`*.ppk`)

Pokud už máte existující klíč v Putty formátu, můžete ho načíst tlačítkem *Load*. 

#### Načtení OpenSSH klíče (`id_rsa` / `id_dsa`)

Pokud už máte existující klíč v OpenSSH formátu, můžete ho také načíst. V menu vyberte *Conversions → Import key*. 

### Zašifrování klíče

Až budete klíč mít vygenerovaný nebo načtený, tak ho opatřete vhodným komentářem. Já si do komentáře dávám uživatele a stroj (`tomasfejfar@x220`), abych v budoucnu viděl, kde se mi na tom kterém místě klíč vzal a také jestli ho třeba můžu smazat (třeba když od té doby mám nový notebook). 

Heslo použijte dostatečně silné. Pokud si klíč zálohujete někam mimo PC (Dropbox, Google Drive, One Drive), platí to dvojnásob. Rozhodně to není doporučená praktika, protože klíč by v ideálním případě neměl nikdy opustit vaše PC. Na druhou stranu záleží jak vnímáte rizika - je větší problém, když přijdete o přístup k nějakému serveru kde nikdo jiný přístup nemá nebo relativně málo pravděpodobný unik dat ze zálohovací služby. 
     
Každopádně platí, že **kdykoli máte podezření, že klíč mohl uniknout, tak si okamžitě vygenerujte nový a vyměňte ho na všech místech**, kde ho používáte. 

Klíče uložte pomocí *Save public key* (`id_rsa.ppk.pub`) a *Save private key* (`id_rsa.ppk`). Pomocí *Conversions → Export OpenSSH key* si vyexportujte i OpenSSH formát klíče (`id_rsa`) a z textového pole si zkopírujte OpenSSH veřejný klíč (`id_rsa.pub`). Privátní klíč můžete kdykoli znovu načíst tlačítkem *Load* a kterýkoli z kroků zopakovat.  

### Nastavení agenta

Abyste nemuseli při každém pokusu o spojení zadávat heslo na rozšifrování klíče, použijte `pageant`. Ten běží v systray a udržuje rozšifrovaný klíč bezpečně v paměti. Stačí aplikaci spustit a pomocí *Add key* si přidat klíč, který se po zadání hesla objeví v seznamu a je možné ho rovnou používat. 

Potíž je, že `pageant` po restartu klíč zapomene a musíte ho znovu přidat. A to je otrava. Vyřešit to jde snadno. Vytvoříte si zástupce pageantu a do položky *Cíl* ve Vlastnostech doplníte za cestu k programu ještě cestu ke klíči (případně více klíčům). Tedy např. `C:\apps\pageant.exe c:\Users\tomasfejfar\.ssh\id_rsa.ppk`. Zástupce si dejte do složky *Po spuštění* (*Start → Spustit → `shell:startup` → OK*). Po přihlášení se `pageant` spustí a požádá o heslo. A pak až do restartu nebude třeba heslo zadávat. 

### Nastavení SSH klienta

Aby se nový klíč z agenta začal používat pro SSH v rámci gitu je třeba nahradit standardního SSH klienta (typicky `ssh.exe` z cygwinu/msysgitu) za `plink`. To provedete nastavením proměnné prostřední (tj. ENV variable) `GIT_SSH` na cestu k plinku (např. `c:\apps\plink.exe`). Nastavení najdete v nastavení systému (`[Win] + [Pause]`), *Pokročilé → Proměnné prostředí*. Nastavit to můžete buď pro současného uživatele nebo pro všechny uživatele. Mimochodem, podobně existuje proměnná `SVN_SSH` se stejnou funkcí pro verzování v SVN. 

![Image](/images/posts/git-ssh-key/env-var.png)

Pro jistotu restartujte. A od té chvíle už by měl `git` normálně fungovat s `plinkem`. Pokud vám to z nějakého důvodu nefunguje, tak si můžete jako *naprosto nejhorší záložní* variantu klíče načíst zpět do `puttygen` a uložit si je bez hesla. Případně se mi ozvěte a zkusíme přijít na to, v čem může být problém. 

### Rodina Putty programů

`plink` funguje úplně stejně jako `ssh`. Jen se jinak jmenuje. Můžete ho tedy úspěšně používat pro připojování ke vzdáleným serverům (`plink tomasfejfar@example.com`). Stejně jako `ssh` také podporuje tunelování portů (parametry `-L` a `-R`).

Na běžnou práci na vzdáleném serveru doporučuji však spíš samotné `putty` (případně [fork `kitty`](http://kitty.9bis.net/), u kterého je velká výhoda, že je rovnou portable). Můžete v něm mít uložené různé servery s různými nastaveními.  

Skupinu uzavírají ještě `pscp` a `psftp`, které fungují, jak již tušíte, stejně jako jejich linuxové protějšky `scp` a `sftp`. A můžete pomocí nich přenášet soubory. 

### Nevýhody

Klíč a agent v Putty formátu si nerozumí s linuxovým (resp. cygwinovým) `ssh.exe`. OpenSSH formát klíče vyexportovaný z `puttygen` fungovat bude, ale při každém spojení bude potřeba heslo. 

Ve valné většině případů lze `ssh` nahradit pomocí `plink`. Pokud to pro váš konkrétní případ nejde, tak si můžete buď zprovoznit agenta v cygwinu (což se mi nikdy uspokojivě nepodařilo) případně pro tohle konkrétní použití mít jiný klíč bez hesla. Sice tím trochu pokazíte bezpečnost celého řešení, ale pro jednorázové použití to nemusí být problém. Poslední možností je vyzkoušet [ssh-pageant](https://github.com/cuviper/ssh-pageant). 

Samotné použití agenta je bezpečnější než nešifrovaný klíč na disku. Ale je třeba mít na paměti, že klíče v paměti agenta jsou rozšifrované a jsou vystaveny riziku, že budou odswapovány nebo k nim přistoupí nějaký proces. Potenciální rizika [přehledně shrnuje dokumentace](https://the.earth.li/~sgtatham/putty/0.60/htmldoc/Chapter9.html#pageant-security).  

### Kam dál?

Když byste se chtěli dozvědět něco víc o tom, jak klíče fungují a co se okolo nich děje, tak si můžete přečíst třeba [A Riddle Wrapped In Enigma](https://eprint.iacr.org/2015/1018.pdf). Zajímavé čtení je taky otázka [*ssh-keygen best practices*](https://security.stackexchange.com/questions/143442/ssh-keygen-best-practices) na Information Security StackExchange. A pokud by vás třeba zajímalo, proč nepoužívat DSA, tak je zajímavé čtení v [Why OpenSSH deprecated DSA keys](https://security.stackexchange.com/questions/112802/why-openssh-deprecated-dsa-keys). Mohlo by vás také zajímat, že na githubu si můžete zkontrolovat veřejný klíč libovolného uživatele na adrese [https://github.com/tomasfejfar.keys](https://github.com/tomasfejfar.keys). 
