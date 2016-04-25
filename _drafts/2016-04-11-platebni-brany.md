---
layout: post
status: publish
comments: true
published: true
title: Jak řeší různé platební brány zabezpečení přenášených údajů
date: '2016-04-11 00:00:00 +0200'
tags: []
image:
    feature: 
excerpt: Za dobu práce na Shopiu jsem se potkal s množství různých platebních bran. Různé brány přistupují různě k tomu, jak zabezpečit přenášená data. Některé metody jsou lepší než jiné. 
---

Blog jsem měl vždycky na [wordpressu](http://www.wordpress.org). Ale s tím je tak trochu potíž. Člověk se musí starat o to, jestli blog běží, jestli mu upgrade nerozbil nějaké pluginy, atd. Když se mi teď nějak poškodila instalace, tak jsem se rozhodl, že takhle už ne. Blog mám na prezentování myšlenek, ne na to, abych se o něj staral. A po tom, co mi zavřeli [Postero.us](http://www.posterous.com/) jsem poučen, že ani SaaS řešení není *to pravé ořechové*.  

Jako logická volba se tedy jeví využít statický generátor stránek. Ty typicky fungují tak, že si v gitu verzujete pár textových souborů a potom z nich pomocí nějakého nástroje vygenerujete kompletní strukturu statických HTML souborů, CSS, JS a obrázků. Možná ještě někdo z vás pamatuje dobu, kdy se takhle (tj. bez PHP, ASP a dalších) stránky psaly (největší znalci budou pamatovat, když se pak objevila novinka - `cgi-bin` v URL a dynamicky generované stránky).  

Na poli statických generátorů stránek je toho na výběr hodně. Tolik, že dokonce existuje i [přehled statických generátorů](https://www.staticgen.com/). Já jsem v prvním sledu hned zredukoval kandidáty na [Jekyll](https://jekyllrb.com/), [Hexo](https://hexo.io/) a [Huga](http://gohugo.io/). Tři systémy, poměrně kompatibilní a každý z nich na jiné platformě. **Jekyll** je napsaný v Ruby, **Hexo** v node.js a **Hugo** v Go. V praxi se ukázalo, že jsou systémy velmi podobné a do velké míry kompatibilní. Nebudu vás příliš napínat - nakonec jsem zprovoznil blog na Jekyllu. Za hlavní výhody považuji množství pluginů, obří komunitu a v neposlední řadě také to, že je to řešení, které pohání [Github Pages](https://pages.github.com/). A tam blog plánuji hostovat. 
 
## Jekyll

Pro zprovoznění Jekyllu budete chtě-nechtě muset nainstalovat Ruby. Stáhněte si tedy [Rubyinstaller](http://rubyinstaller.org/). A když už na tom webu budete, tak si stáhněte i *DevKit*, který budete stejně potřebovat. Buildují se s jeho pomocí gemy s nějakým nativním rozšířením.  

Pokud budete chtít začít co nejrychleji, tak se jako nejrozumnější možnost jeví použít [gh-pages gem](https://rubygems.org/gems/github-pages/). Ve složce, kde chcete začít vytvoříte soubor `Gemfile` a do něj:

```ruby
source 'https://rubygems.org'
gem 'github-pages'
```

`Gemfile` je něco jako `composer.json` v PHP světě. Je to prostě seznam závislostí. O jejich instalací se stará `bundler`. Ten je třeba nainstalovat `gem install bundler`. Pak ve složce s projektem zavoláte `bundle install` a za chvíli máte připravené prostředí. Do samotné složky se vám nic nezkopíruje a zůstane v ní jen Gemfile. 

### Template

Pro Jekyll jsou šablony vlastně jen několik souborů a s nimi související `_config.yml`. Já jsem si vybral template [minimal mistakes](http://mmistakes.github.io/minimal-mistakes/). Stačilo stahnout zazipovanou verzi z githubu, překopírovat do složky a upravit pár věcí v `_config.yml`. Například přidat do `exclude` složku `.idea` (jestli jste četli [můj seriál o PhpStormu na Zdrojáku](https://www.zdrojak.cz/?s=Jak+b%C3%BDt+produktivn%C3%AD+v+PHPStormu&submit=Hledat), tak víte, že v něm píšu všechno - i tenhle blogpost).
  
### Servírování
 
V Jekyllu můžete web buď vygenerovat pomocí `bundle exec jekyll build` (případně s přepínačem `--watch` průběžně) nebo si můžete nechat přímo udělat server, na kterém si můžete web prohlédnout, pomocí `bundle exec jekyll serve`. Co si vyberete, je na vás. Ale bez serveru možná budete muset vyplnit parametr `url` v `_config.yml`, protože jinak nebudou sedět absolutní cesty. 

## Problémy na které jsem narazil

Zprovoznění rozhodně nebylo bezbolestné. Narazil jsem na různé problémy s kompatibilitou. Navíc ještě 31.1., když jsem dělal většinu práce, podporovaly Github Pages jen Jekyll verze 2. A včera přepnuli na Jekyll 3, takže jsem si to zprovoznil celé znovu. Objevil jsem několik bugů[^1] a komplikací[^2]. Avšak je třeba říci, že většinu problému bylo možné obratem vyřešit. 

Důležitá věc je, abyste Jekyll vždy spouštěli přes `bundle exec jekyll` a ne přímo, protože jinak není jisté, že se použije správná verze z *bundleru* a můžete se pak setkat třeba s takovouto chybou.  

{% highlight text%}
Configuration file: W:/www/projects/gh-pages/_config.yml
C:/Ruby22/lib/ruby/gems/2.2.0/gems/jekyll-3.0.2/lib/jekyll/plugin_manager.rb:30:in 'require': cannot load such file -- jekyll-sitemap (LoadError)
        from C:/Ruby22/lib/ruby/gems/2.2.0/gems/jekyll-3.0.2/lib/jekyll/plugin_manager.rb:30:in 'block in require_gems'
        ...
{% endhighlight %}

Pokud ho spustíte skrz bundler `bundle exec jekyll serve`, tak to v pohodě projde. Skrz bundler to používá ty dependency specifikované v `Gemfile`. Jinak to může použít libovolnou, zrovna globálně nainstalovanou verzi.  

## Livereload

Výhodou nejrozšířenějšího řešení je, že najdete návody na prakticky jakýkoli scénář. Napadlo mě, že by bylo hezké mít udělaný livereload. Build trvá mezi 0.5 až 2s a tak se často stane, že musím panel obnovit 2x, protože to stihnu dřív než se to dokončí. Nastavení je úplně jednoduché a nutno podotknout, že by fungovalo i na jakýkoli jiný projekt (nejen Jekyll). Do `Gemfile` přidejte

```ruby
gem 'guard'
gem 'guard-jekyll'
gem 'guard-livereload'
```

Ve složce s projektem vytvořte `Guardfile`

```ruby
guard 'jekyll' do
  # watch anything but '_site' folder
  watch(%r(^(?!_site).*))
end

guard 'livereload' do
  # watch '_site' folder
  watch(%r(_site/.+))
end
```
  
Mimochodem - na internetu najdete návody, které používají `ignore /_site/`. Ve výsledku se mi to však minimálně na Windows nepodařilo spolehlivě zprovoznit. Výše zmíněný kód mi naopak funguje naprosto spolehlivě.

Do prohlížeče si nainstalujte [livereload extension](http://livereload.com/extensions/) a spusťte `bundle exec guard`. Pro livereload je podle mého názoru lepší oddělit zobrazování souborů od generování. Já jsem na to využil integrovaný PHP server `php -S localhost:8080` a web tedy lokálně prohlížím na [http://localhost:8080/](http://localhost:8080/).
  
## Zprovoznění Github Pages
  
Posledním krokem je nahrání na Github Pages. Založíte si repository s názvem subdomény, pod kterou chcete blog provozovat. V mém případě [tomasfejfar/blog](https://github.com/tomasfejfar/blog) a pushnete do branche `gh-pages`. **Necommitujte vygenerovanou složku `_site`!** To udělají Github Pages za vás. Ideálně si ji přidejte do `.gitignore`. 

Pushnutím se vám vytvoří url `username.github.io/repository-name`. Pokud chcete provozovat doménu třetího řádu jako to mám já, musíte vytvořit soubor `CNAME`[^4] a do něj dát název subdomény. Pak zbývá jen nasměrovat DNS. U mě například takto: 

```
blog.tomasfejfar.cz.                    CNAME	tomasfejfar.github.io.
```

A je hotovo. Pokud vám něco nefunguje, tak se podívejte do dokumentace[^3] nebo napište v komentářích. 

Jen pozor na to, že Github nepovoluje žádné speciální pluginy, kromě těch, které se vám nainstalovaly s bundlem. U šablon se tedy dívejte, jestli jsou kompatibilní s Github Pages. 

[^1]: [Unclosed rouge highlighting #4432](https://github.com/jekyll/jekyll/issues/4432)
[^2]: [Compability with Jekyll 3? #99](https://github.com/poole/poole/issues/99)
[^3]: [Setting up a custom domain with GitHub Pages](https://help.github.com/articles/setting-up-a-custom-domain-with-github-pages/)
[^4]: [CNAME](https://github.com/tomasfejfar/blog/blob/gh-pages/CNAME)