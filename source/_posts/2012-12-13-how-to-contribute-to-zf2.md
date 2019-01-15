---
id: 23
title: How to contribute to ZF2
---

... for git dummies

I'd like to show you how to contribute to Zend Framework 2\. I'll focus on the technical issues you may encouter on the way. I assume you have set up Github correctly. If  not, [consult Github help](https://help.github.com/articles/set-up-git).

ZF2 is developed using Github and in contrast to ZF1, you don't need to sign CLA.

First step to contributong is creating your own fork (where you will push your changes and make pullrequests from). Go to [https://github.com/zendframework/zf2](https://github.com/zendframework/zf2) and choose "Fork" in the top left corner. That will create a copy of ZF2 repo in your account - for me, it's [https://github.com/tomasfejfar/zf2](https://github.com/tomasfejfar/zf2).

Now clone the repo using

```bash
git clone https://github.com/tomasfejfar/zf2
```

Now you have the repo locally. It has two branches **master** and **origin/master**. **Master** is your local main branch. **Origin/master** is your fork's main branch. You need a way to communicate with the ZF2 official repo. So you need to add one more remote.

```bash
git remote add upstream  https://github.com/zendframework/zf2
```

Now you should have two remotes. Verify it using

```bash
git remote
```

You should see **origin** and **upstream**. If it's so - it's great. Remember it's generally a **not** a good idea TO COMMIT INTO MASTER. It will save you lot of problems and merge conflicts.

### How to create a pullrequest

To contribute, you need to create a pullrequest. The pullrequest should ideally contain one branch. That branch should be branched from the most current master and it should contain ONLY the changes that are relevant to the pullrequest. If you are fixing two separate issues, create two separate pullrequests.

So, let's start. First you need to make sure your **master** is up to date. You may need to call

```bash
git stash
```

if you have some uncommited changes to clean your working copy. Don't worry, you may later return stashed changes using

```bash
git stash pop
```

When your working copy is clean, it's time to sync your repo with official zf2 repo (**upstream**).

```bash
git checkout master

git pull upstream master

git push origin
```

First, you checkout your **master**, than pull changes from official ZF2 repo and then push those changes to your fork. Now your **master** is in the same exact state as is the **official zf2 master** and so is your **origin/master**. And you may create a branch.

```bash
git checkout -b fix-something master
```

You are now on your local **fix-something** branch and you may commit as you wish. It's good idea to write descriptive commit messages (what is changed, what you tried to do), so that it's clear what your intentions are. When your changes are ready, you need to push that branch into your origin

```bash
git push origin fix-something
```

Now when your branch is on github, you go to your fork and there is a button "Pullrequest" on the top (or there may appear a message "you recently pushed branch fix-something, do you want to create a PR?". Yes, you do! From yourname/zf2 - fix-something branch to zendframework/zf2 - master._Note:_  To be honest, I'm not sure whether you should pullrequest against master or develop. There are currently PRs for both and I can't find the pattern :) Important things are - create a branch for your PR and create that branch from recent master, not some two year old commit.

I hope this helps you to contribute to ZF2! For some more ideas about contributing to ZF2 read [MWOP's blogpost](http://mwop.net/blog/255-How-to-Contribute-to-ZF2.html) (it's little outdated, but still have some important information). Documentation [needs your help too](http://devzone.zend.com/2463/zf2-documentation-we-want-you/). When in doubt, use the mailing list or ask on IRC.

Feel free to suggest improvements to this _howto_ in comments or by sending me a mail ;)

[![Creative Commons License](http://i.creativecommons.org/l/by/3.0/80x15.png)](http://creativecommons.org/licenses/by/3.0/)  
This work is licensed under a [Creative Commons Attribution 3.0 Unported License](http://creativecommons.org/licenses/by/3.0/).
