---
redirect_from: "/266-jak-zacit-prodavat-na-internetu/"
layout: post
status: publish
comments: true
published: true
title: 'Jak začít prodávat na internetu? '
date: '2014-07-10 00:23:36 +0200'
date_gmt: '2014-07-09 22:23:36 +0200'
categories:
- Uncategorized
tags:
- tipy
- zamyšlení
- shopio
- ecommerce
---


Marek Prokop dnes na svém blogu Do košíku vydal článek s názvem <a href="http://dokosiku.blogspot.cz/2014/07/pustil-bych-se-do-vyvoje-e-shopu.html">Pustil bych se do vývoje e-shopu... kdybych věděl jak</a>. Marek by rád by svůj obchod s čajem <a href="http://www.cajtydne.cz/">Čaj Týdne</a> rozvinul do plnohodnotného eshopu, ale není si jistý, jakým směrem se s vývojem eshopu vydat - jestli si ho vyvíjet sám, nebo jeho vývoj někomu svěřit. Rád bych přidal svůj názor na tuto problematiku, ale na komentář to bylo příliš dlouhé.





<a href="#update">29.7.2014</a>: Text článku byl rozšířen o podněty ze souvisejících diskusí.




Předem musím přiznat to, že se podílím na vývoji <a href="http://www.shopio.cz/o-nas/shopio-tym/">Shopia</a>, takže je tím můj pohled trochu ovlivněn. Avšak ještě dlouho před Shopiem jsem si napsal vlastní eshopový systém <abbr title="Universal Shop Engine">USE</abbr>, takže mám zkušenost i z druhé strany.


<h2>Napsat si vlastní eshop</h2>


Vždycky, když člověk stojí před novým projektem, tak je lákavé začít na zelené louce. <em>"Napíšeme si to hezky postupně a přesně tak, jak potřebujem"</em>. Myslím, že je to velmi dobré řešení. Ale není pro každého. Vlastně vím o jediném člověku, u kterého mi tohle dávalo smysl - <a href="http://vavru.cz/">Vlasta Vávrů</a>. Psát si vlastní eshop dává smysl, pokud tak trochu rozumíte programování a baví vás to. Víte přesně co potřebujete, abyste mohli obchod rozjet. Stačí nabušit těch pár věcí a už prodáváte.




V opačném případě si musíte sehnat vývojáře. V ideálním případě dva - na Shopiu jsme si již několikrát ověřili, že rozdíl v kvalitě kódu, do kterého koukají dva vývojáři místo jednoho, je propastný. I ten nejschopnější vývojář časem "zahnije", pokud dělá na projektu úplně sám a nemá "vývojářskou" zpětnou vazbu.




Aby výsledek k něčemu vypadal, je ideální najmout vývojáře, který za sebou už má alespoň jeden ecommerce projekt. Vyhne se tak chybám, které člověka běžně nenapadnou. Například ví, že všechny údaje o položkách objednávky je třeba nakopírovat, nikoli jen napojit cizím klíčem - protože jinak se ve starých objednávkách mění např. názvy položek, v horším případě ceny. Stalo se to nejen mě, ale ve výchozí verzi tím trpí třeba jinak skvěle vypadající <a href="http://sylius.org/">Sylius</a>. Takový vývojář ovšem chce třeba 40k měsíčně (krát dva vývojáři). Vytvoření a otestování nějakého "základního" řešení je minimálně na měsíc až dva práce. To je 80-160 tisíc, jen aby člověk měl základ.




A na podobný problém narazíme i při správě - buď je třeba vývojáře vydržovat ve firmě, nebo hrozí, že si najde jinou práci a na vaše úpravy nebude mít čas. Mimo to je potřeba vývojáře řídit - aby na jednu stranu neodflakoval věci, na kterých záleží, a na druhou stranu se nenimral ve věcech, na kterých nezáleží. A třeba taky sledovat, jestli se čas od času připomene, že je něco potřeba refaktorovat, atp. Je to vlastně celá jedna další funkce, kterou někdo musí dělat (ideálně někdo kdo dřív už něco vyvíjel).


<h3>Na co si dát pozor?</h3>


Především na to, abyste vybrali správného vývojáře. Základy, které položí, budou pohánět váš eshop ještě hodně dlouho a k jejich přepsání se jen tak nedostanete. Rozhodně bych nedoporučoval vybírat vývojáře na eshop jako na první společný projekt. Vyzkoušejte ho v dostatečném předstihu na jiném projektu a ověřte si, že pracuje dobře a že si lidsky "sednete".


<h2>Použít open source eshop a vyvíjet in-house</h2>


Tato možnost řeší některé základní problémy prvního řešení. Začnete zadarmo a můžete hned prodávat. Pokud váš vývojář už dříve s daným systémem pracoval, je to ještě lepší. Nejspíš už pro něj napsal několik modulů, které jen někam zapojí a bude to.




Který opensource systém je nejlepší? Už je to delší dobu, co jsem opensource eshopy zkoumal (naposled když jsem psal USE), takže berte tyhle informace s rezervou. OsCommerce je <a href="https://github.com/osCommerce/oscommerce2/blob/master/catalog/index.php">zlo nejhrubšího zrna</a>. Wordpress je proti němu umělecké dílo. Na PrestaShop jsem slyšel docela chválu, a dokonce ani <a href="https://github.com/PrestaShop/PrestaShop/blob/1.6/classes/PaymentModule.php">pohled do kódu</a> nevyvolá v ostříleném vývojáři vyloženě záchvat vzteku (až na to skládání DB dotazů). Pokud bych se chtěl vydat cestou opensource, tak bych PrestaShop asi zvolil. Marek zmiňuje ještě Magento. Magento je podle mého ze zmíněných <a href="https://github.com/magento/magento2/blob/master/app/code/Magento/Checkout/Model/Cart.php">ten nejlépe napsaný</a>. Bohužel je psaný pro velké reklamky a firmy - <em>"Potřebujem prodávat na webu mistrovství světa plyšáky. -- Tak to hodíme na Magento. -- A nebude to pomalé? -- Nebude. Kdyžtak se koupí druhý server, ve 20M rozpočtu se to ztratí"</em>. Po nainstalování je zoufale pomalý a k běhu vyžaduje spoustu cachování a ne všude dostupných nástrojů. Na druhou stranu úpravy do něj jsou díky dobrému návrhu snazší, resp. více dlouhodobě udržitelné. Pokud bych si myslel, že můj eshop jednou vyroste tak, že bude mít celosvětový záběr, a bude ho vyvíjet tým 30 vývojářů, tak se Magento jeví jako dobrá volba.




Ale stále jsme se nezbavili zásadního problému - a to, že musíme vydržovat a řídit vývojáře (jednoho nebo více).


<h3>Na co si dát pozor?</h3>


Je jasné, že kritický je opět výběr vývojářů. Ale ani výběr technického řešení není možné podcenit a důrazně bych varoval před vybráním horšího technického řešení jen proto, že na to lepší zrovna není k sehnání vývojář. Jako v prvním případě - vývojáře časem dost možná vyměníte, ale přepsat od základu eshop na jiný systém se vám nejspíš nepodaří.


<h2>Nechat si vyvíjet eshop externě</h2>


Teď se bavíme o firmě, která se <strong>vývojem eshopů zabývá</strong> (kromě <a href="http://www.shopio.cz/">Shopia</a> třeba <a href="http://www.shopsys.cz/">Shopsys</a> nebo <a href="http://www.oxyonline.cz/">OxyOnline</a>), ne o IT firmě na náměstí, která dělá "<em>optické a telefonní sítě, internet, prodej PC, tvorba WWW a eshopů</em>". Tam si běžte koupit myš nebo klávesnici, ale ne eshop (to si ho raději udělejte inhouse)!




Nejprve si shrňme nevýhody. Tato možnost je na první pohled o dost dražší než inhouse vývoj. Prvotní zprovoznění eshopu vás může vyjít na pěkných pár desítek, ne-li stovek tisíc. A pravděpodobně budou úpravy trvat delší dobu, než pokud by je dělal inhouse vývojář. Navíc do návrhu úprav promítá své představy a interní omezení. V neposlední řadě je rizikem to, že kritickou součást vašeho podnikání svěřujete někomu mimo firmu.




To vypadá smutně, že? A nyní k výhodám (už trochu z pohledu Shopia).




Dlouhodobý vývoj jednoho projektu s sebou přináší (pokud je dobře nastavený) zásadní výhody. Je možné nastavit jasná pravidla pro psaní kódu, zaučovat průběžně nové vývojáře, z části zisku zaplatit vylepšení, která nepřinášejí momentální zisk, atd. Mimo to se stým běžícím eshopem zjistíte, že většinu problémů, na které narážíte, nevidíte poprvé (už se mi dokonce stalo, že jsem jednou vygooglil vlastní řešení problému). Optimalizujete dotaz do databáze, který je sice něčím unikátní, ale podobných už jste řešili několik. V dlouhodobém horizontu se tak samotný vývoj na straně psaní kódu zjednodušuje a zlevňuje. Typickým případem je implementace platební brány. To je úprava, která (podle toho, jak konkrétně se ji rozhodnete udělat) může zabrat klidně několik dnů (napsat, otestovat, nasadit). Pokud to firma rozloží mezi všechny své klienty, tak bude cena o dost nižší. Dále firma distribuuje znalosti mezi svými klienty. Pokud u jednoho z nich objeví chybu v implementaci, tak to dá vědět i ostatním. Příklad z praxe: Víte, že <a href="http://www.postovnibaliky.cz/">Česká pošta začala provozovat balíkomaty</a>? Možná ano. A víte o tom, že změnili bez ohlášení zpětně nekompatibilně chování XML feedu s informacemi o pobočkách, takže pokud jste ho implementovali podle dokumentace, tak vám nefunguje správně? Nejspíš ne. Shopio ano a už nasazujeme opravy.


<h3>Na co si dát pozor?</h3>


Jako v předchozích dvou příkladech se vyplatí dvakrát měřit a jednou řezat. Vendor lock-in je v případě na zakázku vyrobeného eshopu ještě markantnější. Ujistěte se, že si s dodavatelem sednete. Na Shopiu třeba obecně má klient relativně blízko k vývojářům - to má výhody (především je to flexibilní a nevzniká šum v komunikaci) ale i nevýhody (vyžaduje to větší angažovanost klienta a vývojáři občas píší/mluví složitě, takže se člověk nesmí bát zeptat na věci, kterým nerozumí). Někomu může naopak vyhovovat korporátnější přístup, kdy si požadavky vysvětlí na osobní schůzce s manažerem, a pak jen zkontroluje výsledek. Toto se, narozdíl od konkrétní hodinové sazby nebo podpory jedné konkrétní platební metody, nemění.




V rámci prvotního zadání bych vám doporučil držet se při zemi, co se týče úprav, a především vysvětlit dodavateli koncept svého podnikání. Zamyslete se nad věcmi, které vám skutečně pomohou od prvního dne v podnikání a ty udělejte. S dodavatelem budete stejně spolupracovat dlouhodobě, takže není důvod po něm chtít všechny úpravy hned najednou. Třeba v praxi zjistíte, že věci, které jste si naplánovali, nevyužijete. V praxi se často setkávám s tím, že klient si objedná nějakou úpravu, kterou pak ve výsledku nevyužívá. Typicky se jedná o různá napojování slev a kupónů na produkty, kategorie, dopravy a platby. To jsou věci, které jsou neuvěřitelně složité - co když zákazník použije kupón na 200 Kč na konkrétní produkt a má slevu 5 % z výše objednávky? Odečte se mu nejdříve kupón a pak sleva nebo naopak nebo nemůže použít oboje najednou? A má se sleva z kupónu počítat i na cenu za dopravu? Ve výsledku to jsou jen zbytečně proinvestované peníze a zbytečná komplexita, kterou lépe vyřeší selský rozum. Věci, které se vyplatí udělat hned na začátku, jsou: specifické požadavky vašeho podnikání, sběr dat a případné napojení na účetní systém. Specifický požadavek je něco, co vás odlišuje od konkurence - např. live zákaznická podpora nebo unikátní grafická šablona. Sběr dat (analytics, tag manager atp.) je nenahraditelný, protože data zpětně už nikdy nezískáte a historická data vám pomohou v rozhodování. A napojení na účetní systém je nutné vyřešit na začátku, protože většinou dost ovlivňuje způsob, jakým eshop nakládá s daty. Ostatní věci můžete udělat průběžně během provozu.




A poslední tip - skoro si myslím, že jeden z nejdůležitějších: Pokud chcete, aby se všechno včas stihlo, tak si naplánujte zadání tak, že se spolupráce rozjede těsně po Vánocích. Nějaký čas zabere, než se dořeší konkrétní implementace, detaily spolupráce a smlouva. Spouštět se bude někdy před prázdninami, případně těsně po nich. Eshop se v relativním klidu připraví na vánoční nápor a stihne nasbírat i nějaké zpětné odkazy. Dodavatel bude mít víc času a věnuje vašemu projektu větší péči. Pokud necháte začátek spolupráce až na podzim s tím, že "<em>se to musí stihnout do Vánoc</em>", tak výsledkem bude zbytečný stres a mnohdy i uspěchaná rozhodnutí, která mohou výsledek negativně ovlivnit.


<h2>Pronájem eshopu bez úprav</h2>


Tohle není vhodná možnost pro Marka, ale pokud je unikátní hodnota vašeho eshopu v nějakém konkrétním zboží nebo službě a nepotřebujete žádné speciální úpravy, tak je pro vás velmi vhodné si eshop pronajmout (např. <a href="http://www.shoptet.cz/">Shoptet</a> nebo <a href="https://www.simplia.cz/">Simplia</a>). Pronájmem typicky získáte průběžné upgrady a opravy chyb, ale přijdete o možnost se odlišit od ostatních eshopů nějakou speciální úpravou. Jako v předchozích případech se vyplatí pečlivě vybírat, protože největším problémem bývá migrace dat jinam. Vaše data vám z pronajatého eshopu vyexportují jen těžko a určitě to nebude levné.


<h2>Závěrem</h2>


Doufám, že vám článek pomůže s rozhodováním, pokud řešíte podobný problém jako Marek. Pokud máte nějaké další dotazy, tak se ptejte přes sociální sítě nebo email. Kontakty najdete <a href="http://www.tomasfejfar.cz">na mém webu</a>. Pokud vás zaujalo Shopio, tak <a href="mailto:info@shopio.cz">si rovnou domluvte schůzku</a>.


<h3 id="update">Update:</h3>


V seznamu opensource řešení jsem ještě přeskočil virtuemart (nadstavba nad Joomla). Opět nemám osobní zkušenost s vývojem, tak nemohu hodnotit, ale nutno říct, že jsem zrovna nedávno viděl (zvenku) slušně zpracovaný eshop, který na něm běžel. Za tip děkuji <a href="http://www.rtsoft.cz">Bohuslavu Němečkovi</a>. V emailu se mimochodem zmínil, že má zkušenosti se všemi možnými opensource/custom přístupy (virtuemart, pluginy do wordpressu, nette, ...).




Dále v komentářích hodně lidí zmiňovalo <a href="https://drupalcommerce.org/">Drupal Commerce</a> (speciálně <a href="https://twitter.com/jakubsuchy">@jakubsuchy</a> a Honza Pobořil). Musím říct, že na mě působí velmi dobře. Je hezky modulární a <a href="https://github.com/drupalcommerce/drupalcommerce">od pohledu na github</a> to vypadá že i otestovaný. Drupal je pověstný tím, že to není jen CMS, ale dá se na něm postavit cokoli od eshopu po CRM. Bez předchozích zkušeností s Drupalem jako takovým bych se do něj nepouštěl a bude nejspíš těžší sehnat na něj schopné vývojáře, ale se správným týmem by to mohla být ta nejlepší možnost v sekci opensource řešení.


