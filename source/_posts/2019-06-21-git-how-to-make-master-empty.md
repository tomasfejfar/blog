---
id: 41
title: How to reset master to empty commit
date: '2019-06-21 00:00:00 +0200'
excerpt: Most people I know are using PR-based development and some companies even make this a hard requirement for legal reasons, so that every piece of code is seen at least by two people. You usually create a branch, push it to origin and make a PR against master. But what to do if you forgot to do this in a new repo and now you have a bunch of commits already in master? And how to prevent it in the future? 
---

### TL;DR

> Add an alias `start = !git init && git commit --allow-empty -m \"Initial commit\"` and use it to create an empty repository. 

> 
> To fix the issue, run the following commands
>

> * `git checkout -b my-feature-1 master`
> * `git branch -D master`
> * `git checkout --orphan master`
> * `git reset --hard`
> * `git commit --allow-empty -m "Initial commit"`
> * `git push origin master:master --force-with-lease`
> * `git checkout my-feature-1`
> * `git rebase origin/master`
> * `git push origin my-feature-1:my-feature-1 --force-with-lease`
>
> Continue reading if you want to know why.
> 
> If you want to understand little bit more about git internals, there is also a [method using *plumbing* commands](#under-the-hood-method). 

## How do I fix this mess?

What you need to do is make master empty again without loosing your precious code.  

First of all check that you **have everything commited** and your **working copy is clean**. You can stash everything (also untracked) using `git stash -u`. 

**Create a backup branch**, that will hold your code so that it does not get lost, when you reset master.
 
`git checkout -b my-feature-1 master`

Now you **delete master** (!). Don't worry, we'll recreate it in a minute. 

`git branch -D master`

You will **create new `master`** out of thin air. The `--orphan` flag will do that for you. Orphan branch is not based off of anything. 
  
`git checkout --orphan master`

But now your working copy contains changes from `my-feature-1` branch. So we need to reset it. 

`git reset --hard`

You can't just **commit empty commit** as git will refuse to do so. So you need to add `--allow-empty` flag.  
  
`git commit --allow-empty -m "Initial commit"` 

Now your **master contains only one empty commit** and you can **push it to the server**. But because the branch changed completely you need to force push. 

`git push origin master:master --force-with-lease`

Notice we did not use a simple `--force`. When you force with lease, git makes sure that the **remote branch is where it's supposed to be**. In case someone pushed after you last fetched the `origin/master` the force push will fail. 

Now you're done when it comes to the master branch. But there are still your changes in the `my-feature-1` branch. If you push it and try to create a PR from it, you will see an error. Something along the lines:

> `master` and `my-feature-1` are completely different trees

To fix this you need to rebase the feature branch on `master`.  

`git checkout my-feature-1`
`git rebase origin/master`
`git push origin my-feature-1:my-feature-1 --force-with-lease`

## Why should I always have empty commit on master? 

There are multiple reasons why starting `master` with an empty commit is a good idea. Apart from being nice and clean, it's **more practical** when you need to rebase any branch based off of it. The commit you rebase onto is not part of the interactive rebase list. So if your first commit was titled `Dummy test 999`, you're not getting rid of that that easily as **you can't rebase a commit that has no parent**.  

To prevent the situation altogether there is this handy [alias](https://git-scm.com/book/en/v2/Git-Basics-Git-Aliases). 

`start = !git init && git commit --allow-empty -m \"Initial commit\"`

When you call `git start` in a directory, it will init the repository as well as add an empty commit on `master`.  

## Under-the-hood method

The above method of fixing master is made for mere mortals. It's using mostly the commands you know and love. But with git there is always more then one way to skin the cat. If you feel adventurous, you can try the "under the hood" method. 

First we need to know what an **empty tree** (e.g. empty directory) looks like. For that we'll employ git's `hash-object`, that returns a hash that git would internally use to represent whatever we pass to it. 

`git hash-object -t tree /dev/null`

Here we're asking git to give us a **hash of a tree that is created from `/dev/null`** (`-t tree` means object of type `tree`). 

You'll probably get `4b825dc642cb6eb9a060e54bf8d69288fbee4904`, unless you're reading this in the future when git changed hashes from SHA1 to SHA256 to avoid collisions.

Now that you know the hash of the tree, you can easily **create a new commit at that tree**. 

`git commit-tree -m "inital commit" 4b825dc642cb6eb9a060e54bf8d69288fbee4904` 

That will give you a hash of the empty commit. The commit is not part of any branch. You just created it using the *plumbing* command. But as you may know, branches are just labels assigned to commits. So all you need to do is to **make the `master` label point to this commit**. In my case the commit hash was `a5c0737b`, so I used it in the reset command. 

`git reset --hard a5c0737b`

And voila! Done. 

You still need to rebase your feature branch on top of it, though. 
