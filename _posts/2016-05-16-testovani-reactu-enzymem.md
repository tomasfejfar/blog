---
layout: post
status: publish
comments: true
published: false
title: Testování Reactu pomocí Enzymu
date: '2016-04-15 00:00:00 +0200'
tags: ['react', 'enzyme', 'testing']
image:
    feature: 
excerpt: Píšete v Reactu a máte testy? A mohl bych je vidět? :) 
---

Před nedávnem jsem psal aplikaci na vyzkoušení React/Redux komba. Byl jsem uchvácen tím, jak snadno se dají testovat redux reducery - tím, že jsou to pure funkce - speciálně pokud člověk používá [Immutable.js](https://facebook.github.io/immutable-js/). Oproti tomu testování react komponent vypadalo jako hrozný pain. Než jsem se dostal k tomu, abych to dopsal, tak vyšel [Enzyme od Airbnb](http://airbnb.io/enzyme/). Dneska bych vám chtěl ukázat, jak snadno jdou react komponenty pomocí enzymu testovat.
 
Na GitHubu najdete základní setup React, Mocha, Chai, Babel, Webpack setup. I v testech můžete použít ES6 sytaxi (je to nastaveno pomocí direktivy `--compilers` v sekci `scripts` v `package.json`). V dalším commitu jsem pro začátek přidal dvě ukázkové pure komponenty:

```js
import React from 'react';

export default (props) => {
  return (
    <ul>
      {props.items.map((item) => {
        return <li>{item.name}</li>;
      })}
    </ul>
  );
}

```

Komponenta vypíše prostě seznam úkolů v `<ul>`. Tak si to pojďme zkusit otestovat. První věc kterou potřebujeme je samotný `enzyme`. Nainstalujeme ho a uložíme jako dev dependency. Povšimněte si, že používám čistou prezentační komponentu (prakticky je to jen anonymní funkce do které padají props.

```bash
npm i --save-dev enzyme
# pouze pokud používáte react > 13
npm i --save-dev react-addons-test-utils
npm i --save-dev react-dom
```

## Tři způsoby práce

Enzyme nám nabízí tři způsoby práce s komponentou z nichž každý má výhody i nevýhody. 

### shallow (neboli "mělký")

```js
import { shallow } from 'enzyme';

const rendered = shallow(<Component />);
```

Mělký render je určený k renderování pouze jedné komponenty. Je to ideální nástroj na unit-testování komponent. Dá se pomocí něj kontrolovat například to, že komponenta správně předává props do podkomponent, nebo že se volá správný callback. 

Ve složce `test` je připravený prázdný soubor pro testy, tak si do něj pojďmě doplnit první test. 

```js
// src/components/TodoList.jsx
import { expect } from 'chai';
import React from 'react';
import TodoList from '../src/components/TodoList';
import { shallow } from 'enzyme';

describe('<TodoList />', () => {
  const items = [
    { name: 'Dojít na nákup', key: 1 },
    { name: 'Naučit se testovat React komponenty', key: 2 },
    { name: 'Vyzkoušet Enzyme', key: 3 },
  ];

  it('renders list of todo items', () => {
    const component = shallow(<TodoList items={items}/>);
    expect(component.find('ul')).to.have.length(1);
    expect(component.find('li')).to.have.length(3);
  });
});
```

Nejprve si přidáme do importů potřebné moduly (react, komponentu a shallow renderer z enzyme). Předem jsem si připravil seznam úkolů do proměnné, abychom ho mohli znovupoužít v dalších testech. Dole je pak vidět, jak jednoduché API enzymu je. Pomocí `shallow` vyrenderuji komponentu a pak pomocí metody `find` hledám potomky a kontroluji, že se věci mají tak, jak chci. 

Když si testy pustíte, uvidíte, že si React stěžuje, že mu chybí u potomků klíče. Pojďme na to přidat test a pak komponentu přeprogramovat. 
 
```js
// test/componentTodoList.js
  it('assign keys to children', () => {
    const component = shallow(<TodoList items={items}/>);
    expect(component.find('ul').childAt(2).key()).to.eq('3');
  });
```

Použili jsme některé nové metody, které enzyme poskytuje. `childAt` nám vrátí potomka na N-tém indexu (od nuly) a metoda `key` vrátí klíč (který není mezi normálními props). Teď stačí upravit komponentu. [Seznam všech dostupných metod](http://airbnb.io/enzyme/docs/api/shallow.html) a jejich API je v dokumentaci. 

```js
// src/components/TodoList.jsx
return <li key={item.key}>{item.name}</li>;
```

Bylo by fajn nemít jednotlivé úkoly jen jako položky seznamu, ale jako samostatné komponenty. Pojďme tedy upravit testy a místo `<li>` používat novou komponentu `TodoItem`. 
 
```js
// test/componentTodoList.js
  it('renders list of todo items', () => {
    const component = shallow(<TodoList items={items}/>);
    const list = component.find('ul');
    expect(list).to.have.length(1);
    expect(component.find('TodoItem')).to.have.length(3); // <-------------
  });
```
```js
// src/components/TodoList.jsx
import TodoItem from './TodoItem';
// ...
        return <TodoItem key={item.key} name={item.name} />;
```
```js
// src/components/TodoItem.jsx
import React from 'react';

const TodoItem = (props) => {
  return (
    <li>{props.name}</li>
  );
};

export default TodoItem;
```

Tada, testy procházejí :)

### Integrační testy s renderováním DOMu (mount)

Druhou variantou jak pracovat s komponentami je plné renderování vč. lifecycle event (např. `componentDidMount`). Přidáme si tedy nový test, kterým chování vyzkoušíme. Používá se metoda `mount`, kterou je třeba doimportovat. 

```js
// test/componentTodoList.js
import { shallow, mount } from 'enzyme'; // <------------ doimporotvaná metoda
//...
  it('calls componentDidMount when mounted', () => {
    const component = mount(<TodoList items={items}/>);
    console.log(component.debug());
  });
```

Jistě jste si všimli, že se nám testy rozbily :(

```
Error: It looks like you called `mount()` without a global document being loaded.
```

Je to proto, že testy spouštíme v příkazové řádce a není tedy k dispozici DOM na kterém by se dalo renderování zavolat. Naštěstí existuje knihovna [jsdom](https://github.com/tmpvar/jsdom), která tento problém řeší tak, že impelementuje headless prohližeč v čistém javascriptu (takový typicky JS přístup - něco nemám, tak to napíšu v javascriptu). Máte ji staženou rovnou s enzymem. Jen je potřeba ji zprovoznit a "vylhat" si v node prostředí browser s DOMem. To uděláme snadno inicializačním skriptem. 
 
```js
var jsdom = require('jsdom').jsdom;

var exposedProperties = ['window', 'navigator', 'document'];

global.document = jsdom('');
global.window = document.defaultView;
Object.keys(document.defaultView).forEach((property) => {
  if (typeof global[property] === 'undefined') {
    exposedProperties.push(property);
    global[property] = document.defaultView[property];
  }
});

global.navigator = {
  userAgent: 'node.js'
};
```

Ten posléze musíme načítat při spouštění testů. Uděláme to přidáním `--require src/jsdom-test-helper.js` do příkazu pro spouštění testů:

```js
// package.json
{
...
  "scripts": {
    "test": "mocha --compilers js:babel-core/register --compilers jsx:babel-core/register --require src/jsdom-test-helper.js", 
    ...
  },
```

Je důležité, aby byl skript načtený při prvním načtení reactu, protože react předpokládá, že DOM načtený při inicializaci je stále jeden a ten samý a znovu už ho nenačítá. Je proto také důležité, aby vaše testy neprováděli v DOMu side-efekty (což by ale stejně neměly). 
 
Teď už testy prochází. A můžete si všimnout, že vypisují HTML (to má na svědomí volání `component.debug()` v testové metodě). Když si stejně vypíšete i výstup z předchozích testů, které používají `shallow`, je vidět, jak se oba přístupy liší. 

```
<!-- shallow -->
<ul>
<TodoItem name="Dojít na nákup" />
<TodoItem name="Naučit se testovat React komponenty" />
<TodoItem name="Vyzkoušet Enzyme" />
</ul>

<!-- mount -->
<Component items={{...}}>
  <ul>
    <TodoItem name="Dojít na nákup">
      <li>
        Dojít na nákup
      </li>
    </TodoItem>
    <TodoItem name="Naučit se testovat React komponenty">
      <li>
        Naučit se testovat React komponenty
      </li>
    </TodoItem>
    <TodoItem name="Vyzkoušet Enzyme">
      <li>
        Vyzkoušet Enzyme
      </li>
    </TodoItem>
  </ul>
</Component>
```

### Renderování čistého HTML (render)

Poslední možnost je vyrenderovat si čisté HTML pomocí metody `render`. V tomto případě máme kód očištěný od react elementů a dostáváme jen čisté HTML. 

```
<!-- render -->
<ul>
<li>Doj&#xED;t na n&#xE1;kup</li>
<li>Nau&#x10D;it se testovat React komponenty</li>
<li>Vyzkou&#x161;et Enzyme</li>
</ul>
```

Protože v testech nás bude zajímat struktura, je třeba HTML naparsovat. A protože to je docela dost práce, tak enzyme používá knihvnu `cheerio`, která už to umí. Kvůli tomu je trošku odlišnější API (prostě dostanete ten cheerio objekt) a místo `debug` voláme `toString`, abychom dostali celý výstup.
  
## Syntactic sugar 

Během testování jistě brzo zjistíte, že by se lépe četlo, kdybyste mohli psát trochu explicitnější asserty, než jen `to.eq` nebo `to.be.ok`. V tom případě vám může pomoci knihvna [chai-enzyme](https://github.com/producthunt/chai-enzyme), která přesně tohle přidává. Můžete pak assertovat třeba takto: 

```js
expect(wrapper.find('input')).to.have.value('test')
expect(wrapper).to.have.style('border', '1px')
expect(wrapper.find(User).first()).to.have.prop('user').deep.equal({name: 'Jane'})
```

Instalace je poměrně jednoduchá - jen do souboru, který se requiruje v testech [přidáte pár řádků z dokumentace](https://github.com/producthunt/chai-enzyme#setup). Nezanedbatelnou výhodou je také to, že vám u failnutého testu zobrazí diff a přesnější popis chyby a ne jen "true není false" :) 

## Závěr

Celkově musím říct, že mě testování s enzymem bavilo :) Ale i přesto už teď vidím potenciální problémy, které se mohou při testování vyskytnout. Speciálně v tom, že při shallow testování jen upravíte strukturu statu a začnete předávat trochu jiné props, ale do testů se to nepromítne. Testy pak vesele procházejí, ale aplikace je rozbitá. To lze však zas pokrýt integračními testy. 
 
 
 
 Testujete svoje reactové appky nebo na to není čas? A už jste zkoušeli enzyme? A pokud ano, narazili jste na nějaké problémy? 
