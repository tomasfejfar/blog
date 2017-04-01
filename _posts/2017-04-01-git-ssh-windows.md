---
layout: post
status: publish
comments: true
published: true
title: Jak nasavit Git, SSH a bezpečný klíč na Windows 
date: '2017-04-01 00:00:00 +0200'
excerpt: Nastavit správně Git na Windows není úplně legrace, ale ukážu vám, jak na to. Na konci budete mít skvělé a bezpečné řešení, které zapadá do Windows ekosystému.   
---

## SSH klíč

Často vídám, že lidé na Windows používají privátní klíč bez hesla. To je podle mého celkem zásadní chyba. Privátní klíč je jako heslo. Heslo byste si nenapsali do texťáku a neuložili na disk. Nedělejte to ani s privátním klíčem! Myslím, že příčinou je, že na Windows není snadné nastavit autentikačního agenta, který si heslo bezpečně zapamatuje a vy ho pak zadáváte jen jednou při přihlášení. Chápu, že zadávat heslo pokaždé, když klíč použijete je otrava. Proto si ukážeme, jak klíč nastavit tak, abyste to dělat nemuseli.  

Začneme tím, že si [stáhneme potřebné nástroje](http://www.chiark.greenend.org.uk/~sgtatham/putty/latest.html) - `putty`, `plink`, `pageant` a `puttygen` (klidně stáhněte celý zip). Oficiální stránka vypadá trochu archaicky, ale nenechte se zastrašit. 

### Vygenerování klíče

Spusťte si `puttygen`.

![Image](/images/posts/git-ssh-key/puttygen.png)

Po spuštění si tlačítkem *Generate* vygenerujte klíč. Délka 2048 je pro současné použití dostačující. A měla by vám bezpečně stačit minimálně na následujících deset let <sup>[keylengh.com](https://www.keylength.com/en/compare/)</sup>.  

#### Načtení Putty klíče (`*.ppk`)

Pokud už máte existující klíč v Putty formátu, můžete ho načíst tlačítkem *Load*. 

#### Načtení OpenSSH klíče (`id_rsa` / `id_dsa`)

Pokud už máte existující klíč v OpenSSH formátu, můžete ho také načíst. V menu vyberte *Conversions → Import key*

#### Zašifrování klíče

Až budete klíč mít vygenerovaný nebo načtený, tak ho opatřete vhodným komentářem. Já si do komentáře dávám uživatele a stroj (`tomasfejfar@x220`), abych v budoucnu viděl, kde se mi na tom kterém místě klíč vzal a také jestli ho třeba můžu smazat (třeba když od té doby mám nový notebook). 

Heslo použijte dostatečně silné. Ve výsledku by sice nikdy nemělo opustit vaše PC, ale jistota je jistota. 

Klíče uložte pomocí *Save public key* (`id_rsa.ppk.pub`) a *Save private key* (`id_rsa.ppk`). Pomocí *Conversions → Export OpenSSH key* si vyexportujte i OpenSSH formát klíče (`id_rsa`) a z textového pole si zkopírujte OpenSSH veřejný klíč (`id_rsa.pub`). Privátní klíč můžete kdykoli znovu načíst tlačítkem *Load* a kterýkoli z kroků zopakovat.  

### Nastavení agenta

Abyste nemuseli při každém pokusu o spojení zadávat heslo na rozšifrování klíče použijeme `pageant`. Ten běží v systray a udržuje rozšifrovaný klíč bezpečně v paměti. Stačí aplikaci spustit a pomocí *Add key* si přidat klíč, který se po zadání hesla objeví v seznamu a je možné ho rovnou používat. 

Potíž je, že `pageant` po restartu klíč zapomene a musíte ho znovu přidat. A to je otrava. Vyřešit to jde snadno. Vytvoříte si zástupce pageantu a do položky *Cíl* ve Vlastnostech doplníte za cestu k programu ještě cestu ke klíči. Tedy např. `C:\apps\pageant.exe c:\Users\tomasfejfar\.ssh\id_rsa.ppk`. Zástupce si dejte do složky *Po spuštění* (*Start → Spustit → `shell:startup` → OK*). Po přihlášení se vám `pageant` spustí a požádá o heslo. A pak až do restartu nebude třeba heslo zadávat. 

### Nastavení SSH klienta

Posledním krokem, který je potřeba ke zprovoznění je nahrazení standardního SSH klienta (typicky `ssh.exe` z cygwinu/msysgitu) za `plink`. To provedete nastavením proměnné prostřední (tj. ENV variable) `GIT_SSH` na cestu k plinku (např. `c:\apps\plink.exe`). Nastavení najdete v nastavení systému (`[Win] + [Pause]`), *Pokročilé → Proměnné prostředí*. Nastavit to můžete buď pro současného uživatele nebo pro všechny uživatele. Mimochodem, podobně existuje proměnná `SVN_SSH` se stejnou funkcí pro verzování v SVN. 

![Image](/images/posts/git-ssh-key/env-var.png)

Pro jistotu restartujte. A od té chvíle už by měl `git` normálně fungovat s `plinkem`. Pokud vám to z nějakého důvodu nefunguje a nechcete to dál řešit, tak si můžete klíče načíst zpět do `puttygen` a uložit si je opět bez hesla. Případně se mi ozvěte a zkusíme přijít na to v čem může být problém. 

### Rodina Putty programů

`plink` funguje úplně stejně jako `ssh`. Jen se jinak jmenuje. Můžete ho tedy úspěšně používat např. pro připojování ke vzdáleným serverům atp. Stejně jak jste zvyklí - např. `plink tomasfejfar@my-vps.com`, stejně tak podporuje tunelování portů (parametry `-L` a `-R`).

Na běžnou práci na vzdáleném serveru doporučuji však spíš samotné `putty` (resp. fork `kitty`, u kterého je velká výhoda, že je rovnou portable). Můžete v něm mít uložené různé servery s různými nastaveními. Část toho jde sice nastavit i v `.ssh/ssh_config`, ale tady je to o něco komfortnější. 

Skupinu uzavírají ještě `pscp` a `psftp`, které fungují, jak již tušíte stejně jako jejich linuxové protějšky `scp` a `sftp`. A můžete pomocí nich přenášet soubory. 

### Nevýhody

Jako všechno i toto řešení má nevýhodu. Tím, že používáte klíč a agenta v Putty formátu, tak s ním nebude spolupracovat linuxové (resp. cygwinové) `ssh.exe`. Pokud jste si při generování vytvořili i OpenSSH formát klíče, tak to fungovat bude, ale při každém spojení bude potřeba heslo. Ve valné většině případů lze `ssh` nahradit pomocí `plink`. Pokud to pro váš konkrétní případ nejde, tak si můžete buď zprovoznit agenta v cygwinu (což se mi nikdy uspokojivě nepodařilo) nebo si přes `puttygen` můžete načíst privátní klíč a vyexportovat si ho v OpenSSH formátu bez hesla. Sice tím pokazíte bezpečnost celého řešení, ale pro jednorázové použití to nemusí být problém. Případně můžete vyzkušet [ssh-pageant](https://github.com/cuviper/ssh-pageant). 

Použití agenta vám usnadňuje používání šifrovaných klíčů, nicméně tím, že jsou udržovány nešifrované v paměti, tak se vystavujete riziku, že budou odswapovány nebo k nim přistoupí nějaký proces. Potenciální rizika [přehledně shrnuje dokumentace](https://the.earth.li/~sgtatham/putty/0.60/htmldoc/Chapter9.html#pageant-security). Pořád je to nesrovnatelně lepší než mít nešifrované klíče na disku, ale pro jistotu na to upozorňuji. 
