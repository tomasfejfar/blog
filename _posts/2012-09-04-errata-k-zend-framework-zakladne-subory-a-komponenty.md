---
layout: post
status: publish
comments: true
published: true
title: 'Errata k "Zend framework: základné súbory a komponenty"'
date: '2012-09-04 00:06:23 +0200'
date_gmt: '2012-09-03 22:06:23 +0200'
categories:
- Uncategorized
tags:
- php
- zend framework
- tutorial
- programování
- zend
---

Originální <a href="http://www.zdrojak.cz/clanky/zend-framework-zakladne-subory-a-komponenty/" target="_blank">článek najdete na zdrojáku</a>. Vzhledem k tomu, že se autor neobtěžoval opravit oznámené chyby v minulých dílech, jsem se rozhodl, že je zde zveřejním pěkně všechny pohromadě. Pokusím se opravit některé nepřesnosti, které se v článku objevily a doplnit věci, které tam podle mého chybí.

<h2>index.php</h2>

APPLICATION_ENV není ani tak název serveru, jako spíš typ prostředí. Podle této konstanty se následně načte příslušná část konfiguračního souboru `application.ini`. Ve výchozím stavu jsou do `application.ini` předgenerovaná prostředí: `production, development, staging, testing`

Jednotlivá nastavení od sebe mohou navzájem dědit a díky tomu není nutné vypisovat všechno 4x, ale stačí všechno napsat do `production` a do ostatních psát jen odlišné hodnoty.

Hodnota APPLICATION_ENV je určena nastavením stejnojmenné proměnné prostředí v .htaccess. Jedná se o jednoduchou direktivu, která určitě není neprůstřelná (proto není v ofic. ZF), ale pro naše potřeby stačí<br />

```php
<?php
    public static function isLocalhost()
    {
        if (Config::isIIS()) {
            return $_SERVER['LOCAL_ADDR'] == '127.0.0.1';
        }
        return $_SERVER['SERVER_ADDR'] == '127.0.0.1';
    }

    public static function isIIS()
    {
        if (isset($_SERVER['SERVER_SOFTWARE']) &amp;&amp; substr($_SERVER['SERVER_SOFTWARE'], 0, 14) == 'Microsoft-IIS/') {
            return true;
        }
        return false;
    }
```

<h2>Bootstrap.php</h2>

Rozhodně nesouhlasím s tím, že by někdo používal kombinaci nastavení v index.php a Bootstrapu. Nedává to smysl. Bootstraping pomocí Zend_Application představuje značný overhead. Ten je daní za flexibilní možnosti boostrapování.

`Zend_Application` používá sadu takzvaných `Resources`, což jsou jednotlivé součásti aplikace, které mohou být znovu použity a jednoduše nastaveny pomocí `application.ini`. Typickým zástupcem je například `Zend_Application_Resource_Db`, což je vlastně třída bootstrapující připojení k databázi. Díky tomu stačí do application.ini přidat

```
resources.db.adapter = "pdo_mysql"
resources.db.params.host = "localhost"
resources.db.params.username = "webuser"
resources.db.params.password = "XXXXXXX"
resources.db.params.dbname = "test"
resources.db.isDefaultTableAdapter = true
```

Od té chvíle máte automaticky nastavené připojení k databázi, aniž byste napsali jedinou řádku výkonného PHP kódu. Navíc editaci ini souboru zvládne i průměrně zručný sysadmin, narozdíl od zkoumání PHP. Není to nic světoborného. Něco podobného umí určitě i nette, cakephp nebo codeigniter. Velká výhoda v tomto případě spočívá ale v tom, že `Resource` si můžete tvořit sami. Můžete si tedy např. udělat resource na připojení k twitteru, nějakému API, nastavení cachování. Záleží na vás. Tyto resource pak můžete používat jako drop-in napříč projekty.

Pokud je pro vás prioritní rychlost a znovupoužitelné resources nepoužijete, není důvod Zend_Application používat. Můžete snadno všechny komponenty instancovat ručně v index.php <a href="http://framework.zend.com/manual/en/zend.db.adapter.html#zend.db.adapter.connecting.factory-config" target="_blank">klidně i pomocí nastavení zapsaného v ini souboru</a>. Na Shopiu Zend_Application z důvodů rychlosti nepoužíváme a máme vlastní třídu na boostrapování aplikace. Osobně fakt, že je si možné framework přizpůsobit mým potřebám, vnímám jako jednu z hlavních výhod ZF.

<h2>Zend_Registry</h2>

Registr je objektovou náhradou globálních proměnných s trochu širšími možnostmi (je zbytečné do nich zabíhat, <a href="http://framework.zend.com/manual/en/zend.registry.using.html" target="_blank">vizte manuál</a>). Protože ZF1 ještě neobsahuje žádný DIC, je předávání závislostí poněkud problematické. Je to řešeno tak, že se do určitých klíčů registru umisťují předpřipravené objekty tak, aby bylo možné je kdekoli získat. Příkladem jsou například překlady. Každá třída, která může používat překlady se podívá do registru, jestli existuje klíč `Zend_Translate` a pokud ano, načte si z něj třídu pro překlady a začne automaticky překládat. A podobně to funguje s dalšími součástmi.

Ukládat si do registru jen tak nějaké proměnné, protože "zrovna nevim co s ní" je rozhodně <strong>BAD PRACTICE</strong>. Takže příklad je zcela zcestný.

Naprosto nechápu proč autor uvádí metodu `_unsetInstance`. `Zend_Registry` je singleton. A tím pádem má i metody `setInstance` a `unsetInstance`. Ale naprosto nechápu, proč je to potřeba uvádět, nota bene, když není uvedeno milion důležitějších věcí.

<h2>Zend_Log</h2>

Když už je na začátku uvedené použití Zend_Application, tak by bylo fajn ukázat, že i log se inicializuje pomocí resource:

```
resources.log.stream.writerName = "Stream"
resources.log.stream.writerParams.stream = APPLICATION_PATH "/../data/logs/application.log"
resources.log.stream.writerParams.mode = "a"
resources.log.stream.filterName = "Priority"
resources.log.stream.filterParams.priority = 4
```

Jen pro úplnost zmíním, že `Zend_Log_Writer_Null` nezapisuje do `/dev/null`. On prostě nezapisuje nikam - tam kde by měl zapisovat, nedělá nic. Je určen k tomu, když máte třeba nějaký speciální log nějaké komponenty a chcete aby najednou nelogovala. Místo abyste mazali všechny volání logu v kódu nebo úplně vypli logování, jen přehodíte konkrétní writer na Null ;)

<h2>Závěr</h2>

Celkově na mě seriál působí tak, že ho píše někdo kdo v ZF dělá pár měsíců. Nechci tím nějak snižovat to, že do toho investuje svůj čas. Já na psaní takového seriálu v odpovídající kvalitě kupříkladu čas nemám. Ale myslím, že by bylo lepší se pro začátek třeba držet minimálně strukturou <a href="http://framework.zend.com/manual/en/learning.quickstart.intro.html">QuickStartu, který je v ZF manuálu</a>. Nebo třeba <a href="http://akrabat.com/zend-framework-tutorial/">Akrabatova tutorialu</a>... Cokoli by bylo lepší než toto. Pominu-li, že si tím autor nedělá úplně nejlepší jméno (i když když neodkáže a jen napíše, že publikuje na odborném serveru, tak to nebude špatné), tak tím dělá velmi špatné jméno i celému frameworku. Ale celkově - začít psát pár měsíců před vydáním kompletně přepsané major verze frameworku tutoriál k zastaralé verzi na hranici morální živostnosti není asi úplně ideální postup. Bohužel (resp. bohudík), ne všechny frameworky jsou vyvíjeny tak agilně, jako nette. A v ZF máme zpětnou kompatibilitu už od verze někde 3--4 roky zpátky, to se holt nedá zfleku přepsat a tak v ZF1 jsou stále některé (v té době zcela běžné) bad practices (narážím na zmíněný Zend_Registry.

