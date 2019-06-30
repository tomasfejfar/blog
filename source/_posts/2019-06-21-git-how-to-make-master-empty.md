---
id: 41
title: How to reset master to empty commit
date: '2019-06-21 00:00:00 +0200'
excerpt: Most people I know are using PR-based development and some companies even make this a hard requirement for legal reasons, so that every piece of code is seen at least by two people. You usually create a branch, push it to origin and make a PR against master. But what to do if you forgot to do this in a new repo and now you have a bunch of commits already in master? And how to prevent it in the future? 
---

### TL;DR

> Add an alias `start = !git init && git commit --allow-empty -m \"Initial commit\"` and use it to create an empty repository. 

## How do I fix this mess?

What you need to do is make master empty again without loosing your precious code.  

* `git checkout master` - First you need to make sure your `master` branch is checked out (that's where your code is at the moment).  
* `git branch whatever` - Create a backup branch, that will hold your code so that it does not get lost, when you reset master.
* `git branch -D master` - Now you delete master (!). Don't worry, we'll recreate it in a minute. 
* `git checkout --orphan master` - vytvořím master "z ničeho"
* `git reset` - vyprázdnit staging aby byl commit empty
* `git commit --allow-empty -m "Initial commit"` - udělám prázdný initial commit
* `git push origin master:master --force` - forcepushnu ten master
* `git checkout whatever`- vrátím se na svoji branch
* `git rebase origin/master` - rebasnu ji na ten nový master (edited)
