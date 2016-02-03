---
layout: post
status: publish
published: true
title: How to apply patches from very different code in git
date: '2013-08-14 18:35:55 +0200'
date_gmt: '2013-08-14 16:35:55 +0200'
categories:
- Uncategorized
tags:
- php
- programování
- git
---


Out codebase has some archaic code, that was rewritten during one refactoring or other. But there is usually some cool feature that was not in the main branch, but in one of the archaic ones. When you need to use it in the new version - you can't merge it (in our case it's in completely different pre-git repo). So you create a patch. And you try to use it in git using



```bash
$ git apply cool-feature.patch
```



but you get something like



```
error: patch failed: data/www/models/Basket/Session.php:278
error: data/www/models/Basket/Session.php: patch does not apply
```



Well, that sucks! It's 21st century, I won't copy/paste it by hand! I WON'T!




But fear not, as there is a way to apply at least some of the mess and keep the rest elsewhere to fix it manually. It's a reject parameter. For me something like the next code worked the best:



```bash
$ git apply --reject --whitespace=fix cool-feature.patch
Applying patch data/www/models/Basket/Session.php with 1 reject...
Rejected hunk #1.
Hunk #2 applied cleanly.
```



That's great, but what about the rejected hunks, you say? They are stored in *.rej files for you to apply them manually.




I hope I saved you some googling and stress :P


