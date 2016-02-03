---
layout: post
status: publish
published: true
title: Zend_Log_Writer_Firebug a logování v dispatchLoopShutdown()
date: '2011-05-16 02:12:39 +0200'
date_gmt: '2011-05-16 00:12:39 +0200'
categories:
- Uncategorized
tags:
- php
- tipy
- problem
- zend framework
---
Pro jeden svůj projekt jsem chtěl logovat data z DB profileru. Udělal jsem si plugin s hookem na dispatchLoopShut­down() a do něj dopsal logovací funkci. Jenže jaké bylo moje překvapení, když to nefungovalo. Zkoumal jsem to dosti dlouho a nemohl jsem najít chybu.
Nakonec jsem zjistil, že je problém v tom, že tenhle writer k samotnému zápisu používá Wildfire komponentu, která potřebuje k své práci controller plugin a data odesílá v dispatchLoop­Shutdown(). Oprava je poměrně jednoduchá – stačí plugin ručně přidat do Front Controlleru dříve než náš plugin. (Ne, že by to dávalo smysl – ale je to řešení) 

```php
<?php
$channel = Zend_Wildfire_Channel_HttpHeaders::getInstance();
$controller->registerPlugin(new USE_Controller_Plugin_Utilities());
$controller->registerPlugin($channel);
```

Jen pro úplnost doplním kód na logování profileru

```php
<?php
//setup loggeru / writeru - např. v bootstrapu$writer = new Zend_Log_Writer_Firebug();
$writer->setPriorityStyle(8, 'TABLE');
$logger = new Zend_Log($writer);
$logger->addPriority('TABLE', 8);
//My_Controller_Plugin_ProfillerDump::dispatchLoopShutdown()
$db = Zend_Db_Table::getDefaultAdapter();
$profiler = $db->getProfiler();
$data = array();
$i = 1;
$data[] = array(
    'ID',
    'Query',
    'Time (ms)',
);
foreach ($profiler->getQueryProfiles() as $query) {
    $time = round(($query->getElapsedSecs() * 1000), 1);
    $query = $query->getQuery();
    $data[] = array(
        $i,
        $query,
        $time,
    );
    $i++;
}
$table = array(
    'Profiller',
    $data,
);
$logger->table($table);
```
Doufám, že jsem vám ušetřil jednu bezesnou noc :) 
