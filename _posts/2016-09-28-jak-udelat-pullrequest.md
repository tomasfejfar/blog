---
layout: post
status: publish
comments: true
published: true
title: Jak poslat pullrequest do opensource projektu? 
date: '2016-09-30 00:00:00 +0200'
tags: ['opensource', 'hacktober', 'github', 'git']
excerpt: Blíží se Hacktober Fest 2016. Poradím vám, jak udělat váš první pullrequest.  
---

Zbývá jen pár dní a začne říjen! Měsíc, kdy se zkracují dny a prodlužují noci. Programátoři všeho druhu tak mají víc času si po nocích programovat. A není náhodou, že právě tento měsíc probíhá [#hacktoberfest](https://github.com/blog/2260-hacktoberfest-is-back). **Hacktoberfest** si klade za cíl motivovat vývojáře, aby se podíleli na opensource projektech. Jak? **Stačí se zaregistrovat a poslat nejméně 4 pullrequesty do libovolných opensource projektů a dostanete od Githubu a DigitalOceanu tričko s logem Hacktoberfestu.** 
   
Udělat pullrequest není nic složitého. Zvládnete to během pár minut.  

<a href="#jak-na-to" class="btn">Chci přeskočit povídání a rovnou udělat pullrequest</a> 

# Co je to pullrequest?

Pullrequest je způsob, jak v gitu poslat jinému vývojáři nějaké své změny. V základu vlastně říká: 

> *"Podívej, mám tady v repozitáři **http://github.com/ja/projekt** nějaké úpravy. Začal jsem stavět na tvojí práci ve **v1.0.0** a commity přidával do větve **moje-upravy**. Jestli chceš, tak si ty úpravy stahni a zahrň je do svojí větve."*

Vývojáři většinou pod pojmem pullrequest rozumí [to, co najdete na Githubu](https://github.com/symfony/symfony/pull/20061), ale samotná funkcionalita pullrequestů je [dostupná i přímo v gitu](https://git-scm.com/docs/git-request-pull). 
 
# Proč dělat pullrequesty? 

Pokud jste autorem opensource projektu, tak máte celkem velkou zodpovědnost. Na jedné straně musíte neustále přidávat nové vlastnosti, aby lidi projekt neopustili, ale na druhé straně musíte všechno udržovat funkční a nic nerozbít. V takové chvíli uvítáte jakoukoli pomoc. Jako uživatelé opensource by se nám často hodilo, aby knihovna uměla to nebo ono. Ale nemůžeme chtít po autorovi, aby strávil bezesné noci programováním jen proto, že se nám zachtělo. A tady přichází ke slovu pullrequesty. Můžeme mu kód připravit a jen mu dát vědět, kde je. Na něm už je jen ho zapracovat a vydat novou verzi. 

# Na co dělat pullrequesty?

Ideálními kandidáty na pullrequest jsou:

* bugfixy
* úpravy v dokumentaci
* nová drobná vylepšení
* přidání CI (Travis, AppVeyor, CodeClimate, atp)

# Na co pullrequesty spíš nedělat? 

Pullrequesty v podobě, jak jsem je popsal (tedy bez nějaké předchozí domluvy a komunikace s autorem) se nehodí na radikální úpravy jako např.:

* přepsat formátování z mezer na taby
* přeformátovat pole, aby byla co klíč, to řádek
* přepsat část projektu z bashe do javascriptu
* předělat framework na PSR-7

Ne, že by se takovéto změny nedaly v pullrequestu udělat. Jsou nevhodné spíš proto, že by jim *měla předcházet větší diskuse*. To, jestli váš pullrequest autor přijme, je jen na něm. A byla by škoda nechat tolik práce na něčem, co se následně nepoužije. U větších věcí bývá lepší [nejprve úpravu navrhnou v rámci issue](https://github.com/sensiolabs/SensioDistributionBundle/issues/223). 

Už víme o pullrequestech všechno důležité, tak pojďme nějaký udělat. 
 
# <a name="jak-na-to"></a>Jak na pullrequest

Ať se nám to líbí, nebo ne, `opensource == github`. Jako první krok je tedy potřeba na Githubu mít účet. [Zaregistrujte se](https://github.com/join?source=header-home) nebo [se přihlaste](https://github.com/login). 
 
Dále si vyberte, do kterého projektu chcete pullrequest poslat. Abych ukazoval postup na konkrétním případě, vybral jsem si [blog Tomáše Votruby](http://www.tomasvotruba.cz/blog/). Ano, blog. Tomáš ho píše ve statickém generátoru [Sculpin](https://sculpin.io/), takže jsou všechny blogposty jen soubory. Takže tam opravím pár drobností a pošlu pullrequest. Tak tedy směle do toho. 

## Vidličkujeme aneb *hardcore forking action*

Prvním krokem je si udělat vlastní fork - tedy kopii repozitáře, do které můžete posílat nové commity. Otevřeme si [repozitář na Githubu](https://github.com/TomasVotruba/tomasvotruba.cz) a klikneme na tlačítko `Fork`. 
 
 ![Fork](/images/posts/hacktober/1-fork.png)

Pokud jste registrovaní v nějakých organizacích, tak ještě musíte vybrat, pod kterým profilem chcete forkovat. Já to udělám pod svým osobním profilem. 

![Výběr profilu](/images/posts/hacktober/2-profile-selection.png)

Za pár sekund máme fork připravený a můžeme si ho stáhnout pomocí `git clone` do počítače. 

## Připravujeme kód

Při dělání pullrequestu je dobré myslet na to, že autor bude muset kód pochopit. Bude tedy fajn, pokud si dáte záležet na **správném pojmenování** (a to se týká všeho - větve v gitu, proměnných, commitů, ...). Stejně tak se snažte **dodržovat konvence zavedené v projektu**, ať s tím má autor co nejméně práce. Pokud má projekt testy, tak je spusťte a zkontrolujte, pro novou funkcionalitu je přidejte.
  
Já jsem si udělal branch `korektura-opensource-2`. A commit jsem pojmenoval `Improved wording  of "How to write open-source 2"`. Mělo by z toho být jasné, co jsem upravil i bez koukání do kódu. Pokud je úprava složitější, tak se vyplatí se v commit message rozepsat, jako to udělal [Martin, když opravoval Windows bug v Symfony](https://github.com/sensiolabs/SensioDistributionBundle/commit/37b56f6f4d25d5924082f24eff55743fa1f73d0a).

## Konečně pullrequest

První věc, kterou musíte udělat, je pushnout svojí branch na Github. 

![Připraveno na Githubu](/images/posts/hacktober/4-commit-ready.png)

Pokud vytváříte pullrequest hned po tom, co jste pushnuli, tak se vám ve vašem forku objeví rovnou tlačítko na pullrequest. 

![Tlačítko na pullrequest](/images/posts/hacktober/8-pr-step1.png)

<a href="#pr-ready" class="btn">Tlačítko se mi objevilo, přeskočit ruční vytváření</a>

Pokud se vám tlačítko neobjevilo, tak si otevřete původní (!) projekt na Githubu, tedy ne svůj fork! A přejděte na záložku `Pull Requests` a tam je tlačítko `New Pull Request`. 
 
![Pullrequest](/images/posts/hacktober/5-pr-step1.png) 

Objeví se stránka, na které zdánlivě nejde nic udělat a je třeba přepnout `compare across forks`. 

![Přepnutí na porovnání forků](/images/posts/hacktober/6-pr-step2.png)

A zde již můžete vybrat váš fork. 

![Výběr forku](/images/posts/hacktober/7-pr-step3.png)

A také vaši branch. 

![Výběr branche](/images/posts/hacktober/9-pr-step4.png)

Potom se hned objeví zelené tlačítko `Create pull request`. Až ho stisknete, objeví se formulář na zadání pullrequestu. 
 
![Formulár na PR](/images/posts/hacktober/11-pr-step5.png)

<a name="pr-ready"></a>Název pullrequestu se automaticky předvyplní z commitu. Stejně ale raději **název a popis zkontrolujte a případně upravte tak, aby dával smysl**.  Zkontrolujte si také, jestli sedí názvy branchí z kterých a do kterých chcete pullrequest udělat. A nezapomeňte zkontrolovat, jestli **jsou v přehledu pouze commity, které tam očekáváte**. Pokud je všechno v pořádku, [můžete PR vytvořit](https://github.com/TomasVotruba/tomasvotruba.cz/pull/29). 
 
![Pullrequest připraven](/images/posts/hacktober/12-pr-step6.png)

A pak nezbývá než čekat a případně reagovat na dotazy autora, které k pullrequestu může mít. Speciálně pokud se jedná o novou feature nebo složitý problém. S Tomášem jsme ještě některé části doladili a já jsem přidal další commit. Teď už je mnou upravená verze článku přímo na webu. 

![Pullrequest mergnut](/images/posts/hacktober/13-pr-finished.png)

Jestli jste s vaším pullrequestem dospěli až sem, tak na sebe můžete být pyšní! Přispěli jste svoji troškou do celosvětového opensource mlýna. A i když se vám třeba nezadaří a autor váš pullrequest nepřijme, tak nevěšte hlavu. Neznamená to, že to byl špatný nápad nebo že posílání pullrequestů nemá cenu. Jen jste možná udělali moc radikální změnu bez předchozí domluvy nebo má autor prostě jiný názor. [Nenechte se odradit](https://github.com/phingofficial/phing/pull/227) a [zkuste udělat jiný](https://github.com/saltstack-formulas/mysql-formula/pull/122) :)

Zapomněl jsem na něco zásadního? Mám tu překlep? Můžete mi [poslat pullrequest](https://github.com/tomasfejfar/blog). Případně dejte vědět v komentářích.  
