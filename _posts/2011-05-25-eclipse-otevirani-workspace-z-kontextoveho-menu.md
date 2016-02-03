---
layout: post
status: publish
comments: true
published: true
title: 'Eclipse: Otevírání Workspace z kontextového menu'
date: '2011-05-25 01:36:07 +0200'
date_gmt: '2011-05-24 23:36:07 +0200'
categories:
- Uncategorized
tags:
- tipy
- windows
---


Poslední dobou jsem nějak rozpolcen mezi projekty od různých  zadavatelů, své projekty a vůbec se začínám ztrácet. Abych od sebe měl  oddělené tyhle věci při práci, používám Workspaces v Eclipse PDT. Jenže  přepínání Workspaces je vopruz ! :) Navíc klasicky před začátkem práce potřebuji Updatnout přes TortoiseSVN working copy, takže musím do té které složky.




A tak by mi spoustu času ulehčilo, kdybych měl v kontextovém menu  něco jako `Start Eclipse Workspace here`. A posléze jsem na to přišel a  taky se o to podělím.




Eclipse se spuští s určeným workspacem pomocí parametru <em>data</em>.  Takže si nejdříve připravíme cestu, kterou budeme Eclipse spouštět. U  mě je to `c:\Program Files (x86)\eclipse\eclipse.exe`, nakonec připojíme  parametr data a %1, které se nahrdí cestou – tedy `c:\Program Files  (x86)\eclipse\eclipse.exe -data %1`. A nyní ta zajímavá část.




Kontextové menu složky najdeme v registrech. Takže si spustíme  regedit (ve Vistách musíme mít admin privledges). Najdeme si větev  `HKEY_CLASSES_ROOT\Directory\shell\`. V ní jsou jednotlivé položky. Do  větve přidáme větev `Eclipse.OpenWorkspaceHere`. Poklepáním na `Výchozí`  v pravé části nastavíme výchozí hodnotu – to bude text, který se objeví  v menu. Pak do vytvořené větve vložíme větev `command` a do její  hodnoty `Výchozí` vložíme připravenou cestu k eclipse. Tada ! Hotovo :)




Případně, pokud chcete komfortnější variantu, tak si vytvořte soubor Eclipse.reg a do něj vložte:



```
Windows Registry Editor Version 5.00

[HKEY_CLASSES_ROOT\Directory\shell\Eclipse.OpenWorkspace]
@="Open Eclipse Workspace here"

[HKEY_CLASSES_ROOT\Directory\shell\Eclipse.OpenWorkspace\command]
@="c:\Program Files (x86)\eclipse\eclipse.exe -data %1"
```



Samozřejmně upravený – se správnou cestou. A pozor na zpětná lomítka


