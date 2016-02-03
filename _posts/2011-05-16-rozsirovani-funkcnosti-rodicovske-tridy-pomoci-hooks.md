---
layout: post
status: publish
published: true
title: Rozšiřování funkčnosti rodičovské třídy pomocí hooks
author:
  display_name: tomas.fejfar
  login: tomas.fejfar
  email: tomas.fejfar@gmail.com
author_login: tomas.fejfar
author_email: tomas.fejfar@gmail.com
wordpress_id: 37
wordpress_url: http://blog.tomasfejfar.cz/?p=37
date: '2011-05-16 01:34:49 +0200'
date_gmt: '2011-05-15 23:34:49 +0200'
categories:
- Uncategorized
tags:
- php
- tipy
- zend framework
---


K napsání tohoto příspěvku mě inspirovala práce na jednom  projektu v Zend Frameworku, který je opravdu dobře napsaný z hlediska  dědičnosti atp. Někdo bude mít možná pocit, že tu znovuobjevuji kolo,  ale někomu to třeba pomůže. Pokud vás zajímá co jsou to <strong>hooks</strong>, tak čtěte dále.


## Problém


Rodičovský controller má v sobě většinu funkcionality. Takže třeba  pro update stačí načíst data, do proměnné controlleru dát form a zavolat  <em>parent::update()</em>. Všechno šlape jako hodinky do chvíle, než je  potřeba nějak rozšířit funkcionalitu nad možnosti parent controlleru.  Např. přidat nějakou složitou validaci dat, přidat nějaký ruhý form,  atp. V tu chvíli se na první pohled zdá, že jediná šance je zkopírovat  kód parent controlleru a udělat v něm potřebné úpravy. A docela dlouho  sem to takhle (prasecky) dělal.


## Řešení


Do chvíle, než mě <a href="http://replay.web.archive.org/20090324072520/http://www.martinhujer.cz/">Martin Hujer</a> upozornil na to, že se na tohle dají hezky použít <strong>hooks</strong>! <img src="http://replay.web.archive.org/20090324072520im_/http://blog.red-pill.cz/wp-includes/images/smilies/icon_smile.gif" alt=":)" /> Ne že bych je neznal už dřív. V ZendFrameworku je používám dnes a denně  např. ve FrontController pluginech (dispatchLoopShutdown, preDispatch,  …). Ale vůbec mi nedošlo, že bych je mohl použít.


## Coto, toto?


Cože to ty hooks jsou? Pro neznalé: Hooks jsou procedury, které  nalepíte někam doprostřed kódu a ve zděděné třídě do nich pak napíšete  co potřebujete, aniž byste museli měnit rodičovskou třídu. Pochopitelné?  Moc ne, že.




Příklad pomůže.




<strong>Původní zdrojový kód</strong>

```php
<?php
// ParentController
function updateAction()
{
    //nějaký kód co nastavuje třeba form, title, oescapování, atp.
    $this->view->headTitle('test');
    //semhle bych chtěl vložit nějaký svůj kód
    $this->_model->update($this->_data);
    //nějaký další kód
}

```


<strong>Zdrojový kód s hooks</strong>


```php
<?php
// ParentController
function updateAction()
{
    //nějaký kód co nastavuje třeba form, title, oescapování, atp.
    $this->view->headTitle('test');
    $this->_beforeUpdate();
    $this->_model->update($this->_data);
    $this->_afterUpdate();
    //nějaký další kód
}

```

```php
<?php
protected function _beforeUpdate(){}
protected function _afterUpdate(){}
```

```php
<?php
class IndexController extends ParentController {
    protected function _beforeUpdate()
    {
        //tady si můžu zavolat co potřebuji a provede se to
        //před updatem DB
        //např.:
        $this->_data['date'] = '2009-01-01';
    }
}

```
