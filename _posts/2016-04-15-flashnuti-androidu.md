---
layout: post
status: publish
comments: true
published: true
title: Jak jsem flashnul Samsung Galaxy S3 Mini na Android 5.1
date: '2016-04-15 00:00:00 +0200'
tags: ['android', 'it']
image:
    feature: 
excerpt: Už nějakou dobu bylo moje S3 Mini neúnosně pomalé a místo resetu do továrního nastavení jsem chtěl zkusit flashnout. 
---

Flashnutí libovolného telefonu je otázka několika kroků, které jsou typicky všude stejné. Liší se jen konkrétní verze operačního systému Android dostupné pro konkrétní modely. Takže i pokud nemáte zrovna *S3 Mini (GT-I8190N)*, tak vám tento návod pomůže. Sepisuji si ho mimo jiné i pro sebe, abych měl checklist, až to budu dělat přístě.  

Pro S3 Mini je nejnovější Android k dispozici na [Novafusion.pl](http://www.novafusion.pl/). Odtamtud jsem pro jistotu také stahoval všechny ostatní nástroje. Při stahování buďte obezřetní. Rozumný zdroj bývá krom jiných také forum XDA Devs. Ale existuje i mnoho jiných webů, odkud bych se stahovat bál.  



První věcí, která je k flashnutí potřeba je **Odin** - program v PC, přes který nahrajete přímo do interní paměti telefonu utilitu na flashnutí (a mimo jiné taky zálohování, formátování, atp.). Najdete ho v sekci Downloads. Dále potřebujete TWRP - recovery tool, kterým budete posléze nahrávat samotný OS. V sekci download pozor na to, abyste vybrali verzi "odin". A Samsung USB driver. 

## Nahrávání TWRP

Telefon nejprve zapněte do módu vzdáleného nahrávání. To se udělá vypnutím a stisknutím `[Volume-][Home][Power]`. Až telefon naběhne do nahrávacího módu, tak zapněte v PC Odin (potřebuje oprávnění správce) a připojte telefon kabelem k PC. Odin by měl telefon zachytit a vypsat nějaké ladící informace do textového logu vlevo dole. Jakmile je Odin připravený, tak pod tlačítkem `PDA` vyberte stažený TWRP soubor (`twrp2.8_golden.nova.20140911.tar.md5`). Zkontrolujte si, že máte zaškrtnuté POUZE `Force Reboot` a `F. Reset Time`! Pak můžete pokračovat kliknutím na `Start`. Po několika desítkách sekund by mělo být hotovo. Telefon se vypne. Odteď by mělo být možné zapnutím pomocí `[Volume+][Home][Power]` nabootovat telefon do TWRP. V nové verzi má TWRP hezké dotykové rozhraní, které se dobře používá.

## Flashnutí  

Doporučuji pomocí Backup zazálohovat současnou verzi telefonu. Zálohu si uložte ideálně na SD kartu, odkud si ji můžete snadno přetahnout do PC pro jistotu. 

Dále si stahněte z Novafusion odpovídající verzi Androidu ve verzi "recovery" (tj. pro TWRP - `cm12.1_golden.nova.20160412.zip`). A GApps - tam si vyberte co vám vyhovuje (nejspíš chcete ARM, 5.1, Mini - `open_gapps-arm-5.1-mini-20160414.zip`).  

Až budete připraveni, tak telefon nabootujte do normálního systému. Připojte ho k PC a normálního správcem souborů nahrajte do rootu stažené soubory. 

Dalším krokem je smazání současných dat. Ten uděláte v TWRP v podmenu Wipe. Až budete mít, tak v menu Install vyberte stažený OS a spusťte instalaci. Může trvat docela dlouho - u mě asi 15 minut. Na konci se zeptá, co dál. Vraťte se zpět do hlavního menu a nainstalujte ještě GApps. Po jejich instalaci využijte nabízené možnosti `Wipe Dalvik Cache` a pak restartujte telefon. 

## Závěr 

První boot bude trvat velmi dlouho (max. však přibližně pět minut). V průběhu se budou optimalizovat nainstalované aplikace. Pokud máte štěstí, tak nyní telefon naběhne do nového OS. Pokud nenaběhne, tak to můžete zkusit celé znovu, případně zkusit jinou verzi.  
