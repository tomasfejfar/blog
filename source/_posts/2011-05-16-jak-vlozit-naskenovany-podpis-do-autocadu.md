---
id: 4
status: publish
comments: true
published: true
title: Jak vložit naskenovaný podpis do AutoCADu
date: '2011-05-16 01:32:18 +0200'
date_gmt: '2011-05-15 23:32:18 +0200'
categories:
- Uncategorized
tags:
- tutorial
- autocad
---
<p>AutoCAD je z mého pohledu jedním z <em>nejzáhadnějších </em>softů, co existuje. Je plný „black-box“ magie, kdy se někde něco děje a kvuli tomu se něco nedá udělat.</p>
<p>Dneska sem byl konfrontován s problémem <strong>jak vložit do AutoCADu naskenovaný podpis</strong>. Abych vám ušetřil případné sakrování (a konec konců, i sobě, až na tuhle zkušenost zapomenu a budu to někdy potřebovat), tak sem sepíšu (ve výsledku celkem snadný) postup jak to udělat. <strong>Na práci je využito (krom AutoCADu) jen opensourcových nástrojů.</strong></p>
<ol>
<li>Naskenujte si podpis. Čím větší, tím lepší. Tak aby výsledné 	rozlišení oříznutého podpisu bylo alespoň 500×500px. V nastavení 	skeneru by to mělo být asi označené jako „dokument ve stupních šedé“ 	což bývá 300DPI a to nám stačí.</li>
<li>Uložený obrázek ořízněte na minimální velikost např. pomocí <a href="http://www.getpaint.net/" target="_blank">Paint.net</a> nebo pro profíky windowsovým 	Malováním ;)</li>
<li>Oříznutý obrázek (nejlépe jako JPG s minimální kompresí) nahrajte 	na <a href="http://vectormagic.com/online/how_it_works" target="_blank">VectorMagic</a>. 	K stažení výsledku potřebujete nějaký email (jako dobrý nápad se jeví 	narychlo založená schránka <a href="mailto:fgfgfg@seznam.cz" target="_blank">fgfgfg@seznam.cz</a>). Zadáte ho 	a pak potvrdíte kliknutím na odkaz v mailu (disposable mail z mailinatoru 	bohužel nefunguje)</li>
<li>Stahnete si výsledek ve formátu SVG. (pokud víte jak převést EPS na 	WMF, tak můžete použít EPS, mě se to nepodařilo)</li>
<li>Nainstalujte <a href="http://www.inkscape.org/" target="_blank">IncScape</a> a otevřete 	v něm stažené SVG, udělejte případné úpravy (smazání pozadí atp.). 	A uložte jako DXF</li>
<li>Otevřete soubor DXF. Je třeba spojit bloky, protože jsou jako jednotlivé 	čáry.<strong> </strong><strong>Další kroky proveďte pouze v případě, 	že se vám nepodaří vytvořit/vložit blok (jako mně). </strong>Je to něco 	v rámci oné černé magie o které jsem mluvil na začátku. Prostě to 	najednou nefunguje a vy nevíte proč :P</li>
<li>Když máte sjednocené čáry, tak uložte celý soubor jako DWG (čím 	nižší verze tím IMO líp).</li>
<li>Zavřete DXF, otevřete vytvořené DWG a postupujte běžně jako kdybyste 	dělali BLOK. (Vytvořit blok, vybrat referenční bod, měřítko, uložit) a 	HOTOVO :)</li>
</ol>
<p>Doufám, že se někomu tahle informace bude hodit. Podělte se o úspěchy v komentářích.</p>
