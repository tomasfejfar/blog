---
id: 3
title: BIOS zmrzne na "Memory T"
---

Objevil se mi na PC závažný problém. Pokaždé při bootování PC zamrzne na POST a poslední řádek je „Memory T“. Jednou se to samo opravilo, napodruhé už ne. První pokus směřoval na RAM. Nejdříve jsem žongloval s moduly, zkoušel měnit sloty, zkoušel jsem bootovat s jedním modulem, dokonce jsem si nechal od kámoše dovézt jiný modul. Žádný úspěch. Zkusil sem CMOS reset. Zkusil jsem odpojit všechny disky. Nic. Vydal jsem se proto Googlit a hledat řešení. Tenhle problém se v 99% případů objevuje na základních deskác firmy Gigabyte. U mě konkrétně se jedná o model S3 (P965). Nebudu vás dlouho napínat. [Řešení existuje a je triviální](http://whrl.pl/RbE0Tb). Pro neanglicky mluvící přikládám českou verzi.

Pokud tato chyba nastane, zkuste vypnout pc, odpojit ho od sítě (aby byla jistota že je vypnuté). Potom odpojte veškerá USB zařízení, která máte připojená. Běžné věci (myš + klávesnice) většinou fungují bez problémů. U mě osobně byla problémem asi čtečka karet All-in-one. V části, kdy se vypisuje Memory Testing BIOS ve skutečnosti na pozadí vyhledává USB zařízení jako např. klávesnici, myš a disky. A pokud některé ze zařízení neodpovídá, BIOS se zasekne a čeká na odpověď. A to je přesně tenhle případ.