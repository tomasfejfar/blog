---
layout: post
status: publish
comments: true
published: true
title: Jak poslat pull-request do opensource projektu? 
date: '2016-04-24 00:00:00 +0200'
tags: ['opensource', 'hacktober', 'github', 'git']
image:
    feature: https://pbs.twimg.com/media/Cguk5hGW4AAMdsP.jpg:large
excerpt: Blíží se Hacktober Fest 2016. Poradím vám, jak udělat váš první pull-request.  
---

Zbývá jen pár dní a začne říjen! Měsíc, kdy se začnou zkracovat dny a prodlužují se noci. Programátoři všeho druhu tak mají víc času si po nocích programovat. A není náhodou, že právě tento měsíc probíhá [#hacktoberfest](https://github.com/blog/2260-hacktoberfest-is-back). **Hacktoberfest** si klade za cíl motivovat vývojáře, aby se podíleli na opensource projektech. Jak? **Stačí se zaregistrovat a poslat nejméně 4 pull-requesty do libovolných opensource projektů a dostanete od Githubu a Digitaloceanu tričko s logem Hacktoberfestu.** 
   
Udělat pullrequest není nic složitého. Zvládnete to během pár minut.  

<a href="#jak-na-to" class="btn">Chci přeskočit povídání a rovnou udělat pull-request</a> 

# Co je to pull-request?

Pull-request je způsob jak v gitu poslat jinému vývojáři nějaké své změny. V základu vlastně říká: 

> *"Podívej, mám tady v repozitáři **http://github.com/ja/projekt** nějaké úpravy. Začal jsem stavět na tvojí práci ve **v1.0.0** a commity přidával do větve **moje-upravy**. Jestli chceš, tak si ty úpravy stahni a zahrň je do svojí větve."*
 
# Proč dělat pull-requesty? 

Pokud jste autorem opensource projektu, tak máte celkem velkou zodpovědnost. Na jedné straně musíte neustále přidávat nové vlastnosti, aby lidi projekt neopustili, ale na druhé straně musíte všechno udržovat funkční a nic nerozbít. V takové chvíli uvítáte jakoukoli pomoc. Jako uživatelé opensource by se nám často hodilo, aby knihovna uměla to nebo ono. Ale nemůžeme chtít po autorovi, aby strávil bezesné noci programováním jen proto, že se nám zachtělo. A tady přichází ke slovu pull requesty. Můžeme mu kód připravit a jen mu dát vědět, kde je. Na něm už je jen ho zapracovat a vydat novou verzi. 

# Na co dělat pull-requesty?

Ideálními kandidáty na pull-request jsou:

* bugfixy
* úpravy v dokumentaci
* nové drobné vylepšení
* přidání CI (Travis, AppVeyor, CodeClimate, atp)

# Na co pull-requesty spíš nedělat? 

Pull-requesty v podobě jak jsem je popsal - tady tak, že něco napíšete a pak to někomu pošlete - se nehodí na radikální úpravy jako např.:

* přepsat formátování z mezer na taby
* přeformátovat pole, aby byly co klíč to řádek
* přepsat část projektu z bashe do javascriptu
* předělat framework na PSR-7

Ne že by se takovéto změny nedaly v pull-requestu udělat. Jsou nevhodné spíš pro to, že by jim měla předcházet větší diskuse. To jestli váš pull-request autor přijme je jen na něm. A byla by škoda nechat tolik práce na něčem, co se následně nepoužije. 
 
# <a name="jak-na-to"></a>Jak na pull-request

Ať se nám to líbí, nebo ne `opensource == github`, takže jako první krok je potřeba tam mít účet. Takže se [zaregistrujte](https://github.com/join?source=header-home) nebo [přihlašte](https://github.com/login). 
 
Další krok je vybrat si, kam chcete pull-request poslat. Abych ukazoval postup na konkrétním případě, vybral jsem si blog Tomáše Votruby. Ano, blog. Tomáš ho píše ve statickém generátoru [Sculpin](https://sculpin.io/), takže jsou všechny blogposty jen soubory. A tyhle soubory se dají upravit a poslat jako pull-request. Tak tedy směle do toho. 

## Vidličkujeme aneb *hardcore forking action*

Prvním krokem je si udělat vlastní fork - tedy kopii repozitáře, do které můžete posílat nové commity. Otevřeme si [repozitář na githubu](https://github.com/TomasVotruba/tomasvotruba.cz) a klikneme na tlačítko `Fork`. 
 
 ![Fork](/images/posts/hacktober/1-fork.png)

Pokud jste registrovaní v nějakých organizacích, tak ještě musíte vybrat, pod kterým profilem chcete forkovat. Já to udělám pod svým osobním profilem. 

![Výběr profilu](/images/posts/hacktober/2-profile-selection.png)

Za pár sekund máme fork připravený a můžeme si ho stahnout pomocí `git clone` do počítače. 

## Připravujeme kód

Při dělání pull-requestu je dobré myslet na to, že autor bude muset kód pochopit. Bude tedy fajn, pokud si dáte záležet na správném pojmenování (a to se týká všeho - větve v gitu, proměnných, commitů, ...). Stejně tak se snažte dodržovat konvence v projektu zavedené, ať s tím má autor co nejméně práce. Pokud má projekt testy, tak je spusťte a zkontroluje, pro novou funkcionalitu je přidejte.
  
Já jsem si udělal branch `korektura-opensource-2` 
