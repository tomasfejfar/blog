---
layout: post
status: publish
published: true
title: How to contribute to ZF2
date: '2012-12-13 22:01:03 +0100'
date_gmt: '2012-12-13 21:01:03 +0100'
categories:
- Uncategorized
tags:
- php
- zend framework
- programování
- zf2
- git
---
<p>... for git dummies</p>
<p>I'd like to show you how to contribute to Zend Framework 2. I'll focus on the technical issues you may encouter on the way. I assume you have set up Github correctly. If  not, <a href="https://help.github.com/articles/set-up-git">consult Github help</a>.</p>
<p>ZF2 is developed using Github and in contrast to ZF1, you don't need to sign CLA.</p>
<p>First step to contributong is creating your own fork (where you will push your changes and make pullrequests from). Go to <a href="https://github.com/zendframework/zf2">https://github.com/zendframework/zf2</a> and choose "Fork" in the top left corner. That will create a copy of ZF2 repo in your account - for me, it's <a href="https://github.com/tomasfejfar/zf2">https://github.com/tomasfejfar/zf2</a>.</p>
<p>Now clone the repo using</p>
<pre>git clone https://github.com/tomasfejfar/zf2</pre>
<p>Now you have the repo locally. It has two branches <strong>master</strong> and <strong>origin/master</strong>. <strong>Master</strong> is your local main branch. <strong>Origin/master</strong> is your fork's main branch. You need a way to communicate with the ZF2 official repo. So you need to add one more remote.</p>
<pre>git remote add upstream  https://github.com/zendframework/zf2</pre>
<p>Now you should have two remotes. Verify it using</p>
<pre>git remote</pre>
<p>You should see <strong>origin</strong> and <strong>upstream</strong>. If it's so - it's great. Remember it's generally a <strong>not</strong> a good idea TO COMMIT INTO MASTER. It will save you lot of problems and merge conflicts.</p>
<h3>How to create a pullrequest</h3>
<p>To contribute, you need to create a pullrequest. The pullrequest should ideally contain one branch. That branch should be branched from the most current master and it should contain ONLY the changes that are relevant to the pullrequest. If you are fixing two separate issues, create two separate pullrequests.</p>
<p>So, let's start. First you need to make sure your <strong>master</strong> is up to date. You may need to call</p>
<pre>git stash</pre>
<p>if you have some uncommited changes to clean your working copy. Don't worry, you may later return stashed changes using</p>
<pre>git stash pop</pre>
<p>When your working copy is clean, it's time to sync your repo with official zf2 repo (<strong>upstream</strong>).</p>
<pre>git checkout master

git pull upstream master

git push origin</pre>
<p>First, you checkout your <strong>master</strong>, than pull changes from official ZF2 repo and then push those changes to your fork. Now your <strong>master</strong> is in the same exact state as is the <strong>official zf2 master </strong>and so is your<strong> origin/master</strong>. And you may create a branch.</p>
<pre>git checkout -b fix-something master</pre>
<p>You are now on your local<strong> fix-something</strong> branch and you may commit as you wish. It's good idea to write descriptive commit messages (what is changed, what you tried to do), so that it's clear what your intentions are. When your changes are ready, you need to push that branch into your origin</p>
<pre>git push origin fix-something</pre>
<p>Now when your branch is on github, you go to your fork and there is a button "Pullrequest" on the top (or there may appear a message "you recently pushed branch fix-something, do you want to create a PR?". Yes, you do! From yourname/zf2 - fix-something branch to zendframework/zf2 - master.<em>Note:</em>  To be honest, I'm not sure whether you should pullrequest against master or develop. There are currently PRs for both and I can't find the pattern :) Important things are - create a branch for your PR and create that branch from recent master, not some two year old commit.</p>
<p>I hope this helps you to contribute to ZF2! For some more ideas about contributing to ZF2 read <a href="http://mwop.net/blog/255-How-to-Contribute-to-ZF2.html">MWOP's blogpost</a> (it's little outdated, but still have some important information). Documentation <a href="http://devzone.zend.com/2463/zf2-documentation-we-want-you/">needs your help too</a>. When in doubt, use the mailing list or ask on IRC.</p>
<p>Feel free to suggest improvements to this <em>howto</em> in comments or by sending me a mail ;)</p>
<p><a href="http://creativecommons.org/licenses/by/3.0/" rel="license"><img style="border-width: 0;" src="http://i.creativecommons.org/l/by/3.0/80x15.png" alt="Creative Commons License" /></a><br />
This work is licensed under a <a href="http://creativecommons.org/licenses/by/3.0/" rel="license">Creative Commons Attribution 3.0 Unported License</a>.</p>
