---
layout: post
status: publish
comments: true
published: true
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

Enzyme nám nabízí tři způsoby práce s komponentou.

## shallow (neboli "mělký")

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

## Full DOM rendering

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

Ten posléze musíme načítat při spouštění testů. Uděláme to úpravou příkazu:

```js
{
...
  "scripts": {
    "test": "mocha --compilers js:babel-core/register --compilers jsx:babel-core/register --require src/jsdom-test-helper.js", 
    ...
  },
```

Je důležité, aby byl skript načtený při prvním načtení reactu, protože react předpokládá, že DOM načtený při inicializaci je stále jeden a ten samý a znovu už ho nenačítá. Je proto také důležité, aby vaše testy neprováděli v DOMu side-efekty (což by ale stejně neměly). 
 
Teď už testy prochází. A můžete si všimnout, že vypisují HTML (to má na svědomí volání `component.debug()` v testové metodě. 
