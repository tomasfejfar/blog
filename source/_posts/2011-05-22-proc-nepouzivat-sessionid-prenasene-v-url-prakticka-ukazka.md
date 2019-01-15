---
id: 15
status: publish
comments: true
published: true
title: Proč nepoužívat sessionId přenášené v URL? (praktická ukázka)
date: '2011-05-22 01:33:10 +0200'
date_gmt: '2011-05-21 23:33:10 +0200'
categories:
- Uncategorized
tags:
- zend framework
- programování
- bezpečnost
---
<p>S HTTP protokolem, který byl navrhnut jako bezstavový, nastal velký problém ve  chvíli, kdy přišla potřeba identifikovat jednotlivé návštěvníky. Tento problém byl posléze vyřešen vznikem sessions. Session je vlastně vazba určitého unikátního klíče na každého jednotlivého návštěvníka a protože v dřevních dobách ne každý prohlížeč uměl používat cookies, předával se unikátní identifikátor pomocí url v promenné PHPSESSID. Jenže dnes jsme někde jinde. Cookies umí každý prohlížeč a kdo je má z bezpečnostních důvodů vypnuté, tak tak činí s vědomým rizikem, že mu nemusí všechno fungovat. Ale i přesto se dnes najdou weby, které session v URL používají. Jedním z nich je i <a href="http://www.dinotoys.cz/" target="_blank">eshop s dárky</a> DinoToys (ať mají aspoň backlink k té negativní reklamě). Myslím, že po dnešku bude obchod DinoToys litovat, že kdy rozjel reklamní akci na slevu pomocí Slevomat.cz. Když posílali (nebo když admin Slevomatu vytvářel) doprovodný text k nabídce slevy na svém eshopu, zkopírovali v adrese URL i identifikátor session v parametru uid. To způsobilo, že všichni návštěvníci ze Slevomatu byli bráni jako jediný člověk. Tím pádem si různě přepisovali košíky a přidávali si navzájem zboží. Stejně tak byly vidět jejich registrační údaje a adresy. Jak se takové situaci vyvarovat? Velmi pěkně <a href="http://www.phpguru.cz/clanky/sid-do-url-nepatri" target="_blank">bezpečné nastavení cookies</a> shrnul na svém blogu Honza Tichý.</p>
<p>Člověk si kolikrát říká, k čemu se píší všechny ty bezpečnostní poučky, když si poté nepohlídají ani základní věci. Jsem ochoten přijmout, že nastavení sessions souvisí se serverem a pokud se jedná o sdílený hosting, tak to často člověk nemůže nijak ovlivnit. Ale tenhle eshop obsahuje těch bezpečnostních chyb opravdu hodně. Namátkou… Mělo by stačit se odhlásit a vše by bylo v pořádku – pro přihlášení musíte znovu zadat heslo. Jenže kliknutím na odhlásit se nestane kromě přesměrování nic. Když vlezete znovu se stejným uid, jste ihned znovu přihlášeni (sice by to nic v tomhle případě neřešilo, ale i tak). Stejně tak pro změnu hesla by mělo být třeba znát původní heslo. Nikoliv. Stačí vyplnit 2× to stejné a je to :)</p>
<p>Vlastníka webu jsem informoval mailem a protože nemám za cíl poškodit ani vlastníka ani uživatele shopu, tak článek vychází se zpožděním, aby měl zmíněný eshop dostatek času chybu opravit. Bohužel už nyní si chyby někdo všimnul a vpisuje lidem do objednávek nesmyslné údaje.</p>
<p>Co říct na závěr?</p>
<p><strong>Chcete bezpečný eshop? Zkuste se podívat na <a href="http://www.shopio.cz/" target="_blank">Shopio.cz</a>!</strong></p>
<p>Nemáte na Shopio a stačí vám jednoduchý eshop? Zkuste se podívat na <a href="http://www.mpalan.cz/reference/internetove-obchody.php" target="_blank">web Mpalan.cz</a></p>
<p><em>Update: </em>Eshop by dle vyjádření vlastníka již měl být opraven. Takže článek vydávám už teď.</p>
