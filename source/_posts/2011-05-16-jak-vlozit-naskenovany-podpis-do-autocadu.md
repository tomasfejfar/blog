---
id: 4
title: Jak vložit naskenovaný podpis do AutoCADu
---

AutoCAD je z mého pohledu jedním z _nejzáhadnějších_ softů, co existuje. Je plný „black-box“ magie, kdy se někde něco děje a kvuli tomu se něco nedá udělat.

Dneska sem byl konfrontován s problémem **jak vložit do AutoCADu naskenovaný podpis**. Abych vám ušetřil případné sakrování (a konec konců, i sobě, až na tuhle zkušenost zapomenu a budu to někdy potřebovat), tak sem sepíšu (ve výsledku celkem snadný) postup jak to udělat. **Na práci je využito (krom AutoCADu) jen opensourcových nástrojů.**

1.  Naskenujte si podpis. Čím větší, tím lepší. Tak aby výsledné rozlišení oříznutého podpisu bylo alespoň 500×500px. V nastavení skeneru by to mělo být asi označené jako „dokument ve stupních šedé“ což bývá 300DPI a to nám stačí.
2.  Uložený obrázek ořízněte na minimální velikost např. pomocí [Paint.net](http://www.getpaint.net/) nebo pro profíky windowsovým Malováním ;)
3.  Oříznutý obrázek (nejlépe jako JPG s minimální kompresí) nahrajte na [VectorMagic](http://vectormagic.com/online/how_it_works). K stažení výsledku potřebujete nějaký email (jako dobrý nápad se jeví narychlo založená schránka [fgfgfg@seznam.cz](mailto:fgfgfg@seznam.cz)). Zadáte ho a pak potvrdíte kliknutím na odkaz v mailu (disposable mail z mailinatoru bohužel nefunguje)
4.  Stahnete si výsledek ve formátu SVG. (pokud víte jak převést EPS na WMF, tak můžete použít EPS, mě se to nepodařilo)
5.  Nainstalujte [IncScape](http://www.inkscape.org/) a otevřete v něm stažené SVG, udělejte případné úpravy (smazání pozadí atp.). A uložte jako DXF
6.  Otevřete soubor DXF. Je třeba spojit bloky, protože jsou jako jednotlivé čáry.**Další kroky proveďte pouze v případě, že se vám nepodaří vytvořit/vložit blok (jako mně).** Je to něco v rámci oné černé magie o které jsem mluvil na začátku. Prostě to najednou nefunguje a vy nevíte proč :P
7.  Když máte sjednocené čáry, tak uložte celý soubor jako DWG (čím nižší verze tím IMO líp).
8.  Zavřete DXF, otevřete vytvořené DWG a postupujte běžně jako kdybyste dělali BLOK. (Vytvořit blok, vybrat referenční bod, měřítko, uložit) a HOTOVO :)

Doufám, že se někomu tahle informace bude hodit. Podělte se o úspěchy v komentářích.