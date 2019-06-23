---
id: 15
title: Proč nepoužívat sessionId přenášené v URL? (praktická ukázka)
---

S HTTP protokolem, který byl navrhnut jako bezstavový, nastal velký problém ve  chvíli, kdy přišla potřeba identifikovat jednotlivé návštěvníky. Tento problém byl posléze vyřešen vznikem sessions. Session je vlastně vazba určitého unikátního klíče na každého jednotlivého návštěvníka a protože v dřevních dobách ne každý prohlížeč uměl používat cookies, předával se unikátní identifikátor pomocí url v promenné PHPSESSID. Jenže dnes jsme někde jinde. Cookies umí každý prohlížeč a kdo je má z bezpečnostních důvodů vypnuté, tak tak činí s vědomým rizikem, že mu nemusí všechno fungovat. Ale i přesto se dnes najdou weby, které session v URL používají. Jedním z nich je i [eshop s dárky](http://www.dinotoys.cz/) DinoToys (ať mají aspoň backlink k té negativní reklamě). Myslím, že po dnešku bude obchod DinoToys litovat, že kdy rozjel reklamní akci na slevu pomocí Slevomat.cz. Když posílali (nebo když admin Slevomatu vytvářel) doprovodný text k nabídce slevy na svém eshopu, zkopírovali v adrese URL i identifikátor session v parametru uid. To způsobilo, že všichni návštěvníci ze Slevomatu byli bráni jako jediný člověk. Tím pádem si různě přepisovali košíky a přidávali si navzájem zboží. Stejně tak byly vidět jejich registrační údaje a adresy. Jak se takové situaci vyvarovat? Velmi pěkně [bezpečné nastavení cookies](http://www.phpguru.cz/clanky/sid-do-url-nepatri) shrnul na svém blogu Honza Tichý.

Člověk si kolikrát říká, k čemu se píší všechny ty bezpečnostní poučky, když si poté nepohlídají ani základní věci. Jsem ochoten přijmout, že nastavení sessions souvisí se serverem a pokud se jedná o sdílený hosting, tak to často člověk nemůže nijak ovlivnit. Ale tenhle eshop obsahuje těch bezpečnostních chyb opravdu hodně. Namátkou… Mělo by stačit se odhlásit a vše by bylo v pořádku – pro přihlášení musíte znovu zadat heslo. Jenže kliknutím na odhlásit se nestane kromě přesměrování nic. Když vlezete znovu se stejným uid, jste ihned znovu přihlášeni (sice by to nic v tomhle případě neřešilo, ale i tak). Stejně tak pro změnu hesla by mělo být třeba znát původní heslo. Nikoliv. Stačí vyplnit 2× to stejné a je to :)

Vlastníka webu jsem informoval mailem a protože nemám za cíl poškodit ani vlastníka ani uživatele shopu, tak článek vychází se zpožděním, aby měl zmíněný eshop dostatek času chybu opravit. Bohužel už nyní si chyby někdo všimnul a vpisuje lidem do objednávek nesmyslné údaje.

Co říct na závěr?

**Chcete bezpečný eshop? Zkuste se podívat na [Shopio.cz](http://www.shopio.cz/)!**

Nemáte na Shopio a stačí vám jednoduchý eshop? Zkuste se podívat na [web Mpalan.cz](http://www.mpalan.cz/reference/internetove-obchody.php)

_Update:_ Eshop by dle vyjádření vlastníka již měl být opraven. Takže článek vydávám už teď.