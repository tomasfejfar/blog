---
id: 7
status: publish
comments: true
published: true
title: Nefunkční partials v ZF po upgradu na 1.7.5
date: '2011-05-16 01:35:44 +0200'
date_gmt: '2011-05-15 23:35:44 +0200'
categories:
- Uncategorized
tags:
- php
- tipy
- problem
- zend framework
---
> Requested scripts may not include parent directory traversal (”../”, “..\” notation)

Tahle práva mě dnes překvapila při ladění shopu. Používal jsem na  jednom serveru spoustu věcí na ZENDu, tak jsem si nechal dát ZF do  include_path, abych nemusel pokaždé tahat FTPčkem těch10MB (nemam shell  access). A ejhle, oni mi upgradovali na 1.7.5 a co se nestalo :)

Tahle chyba nastává, když vkládáte view s cestou např.: “../partials/muj-partial.phtml” :)

Řešení naštěstí existuje

```php
<?php
$view->setLfiProtection(false);
```

Po chvíli zlobení a nadávání jsem vygooglil tento článek:<br />
<a href="http://weierophinney.net/matthew/archives/206-Zend-Framework-1.7.5-Released-Important-Note-Regarding-Zend_View.html">Zend Framework 1.7.5 Released - Important Note Regarding Zend_View</a><br />
<a href="http://framework.zend.com/manual/en/zend.view.migration.html">53.6.1. Migrating from versions prior to 1.7.5</a> v manuálu Zend Frameworku

