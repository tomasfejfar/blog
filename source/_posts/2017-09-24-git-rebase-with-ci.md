---
id: 38
title: Be safe, rebase! 
date: '2017-09-24 00:00:00 +0200'
excerpt: Even if your build is green and tests pass it's not a guarantee that it won't fail after you merge. You should always rebase onto master before merging! To learn more read the full blogpost.  
---

When versioning code with Git, you have two options. You can treat the history as immutable and use merging as a way to pull new changes. Or you use rebase, recreating the history many times over.  I've been using rebase for more than five years. And I've been endorsing it to other developers all the time. The usual selling point is better readability or easier integration of changes from other branches. But today I want to talk about a different value of rebasing – and that is codebase stability.

## TL;DR

> If you merge a branch that is not rebased on top of current master, your code may break even if your tests were fine before and there were no merge conflicts. **Always make sure the merge request is rebased onto master before merging.**

## Further explanation

There are three developers - *Alice*, *Bob* and *Carrie*. They all work on the same project. Their codebase is of reasonable quality and with good test coverage. They have continuous integration server in place and never merge anything if tests fail.
 
On that sunny afternoon, everything seemed as usual. *Alice* was refactoring the `Person` class, creating new class `User` to replace it. *Bob*’s merge request implementing new authentication method was already reviewed, tests were green and *Carrie* merged it. Then she reviewed *Alice*'s merge request. She noticed that CI server showed green badge as well and felt confident merging it. She merged it and launched deployment. Why not? Tests passed, no merge conflicts, all green. But before the deploy finished, she noticed a new message in her inbox. Its subject sent a chill down her spine: `"Build failed for branch master"`. Support inbox started filling with messages from customers that could not log in. *Carrie* eventually found the problem and fixed it. But the incident resulted in more than five minutes of downtime.

## What happened? 

How could the master build fail if the merge request was green? Was there a malfunction in the CI server? No. The reason is simple. *Bob*'s code that added new authentication method was merged first. It was in master, using the `Person` class. At the time *Alice*’s branch was branched from master the new auth method was not there yet. *Alice* replaced all the usages of the `Person` class unaware that there is *Bob*’s new auth method in master is using it as well. When *Alice*'s change was merged later, it removed the `Person` class causing the auth method to fail. Observe the git log below.
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gitgraph.js/1.11.4/gitgraph.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/gitgraph.js/1.11.4/gitgraph.min.js"></script>
<div style="width:99%;margin:0 auto;overflow-x:scroll"><canvas id="gitGraph"></canvas></div>
<script src="/assets/js/posts/be-safe-rebase.js"></script>
 
But how does one prevent such a problem? It's simple. Never merge a branch that has not been rebased onto master. Let's see how the event would unfold if they were using rebase.
 
* *Carrie* merges *Bob*'s merge request. 
* Then she moves on to review *Alice*'s merge request. 
* She notices that the branch is not based off current master. 
* She either rebases it herself or asks *Alice* to do so. 
* In any case, the build fails and *Alice* updates the authentication method code. 
* PROFIT! 

There are also other ways to mitigate the danger of merging buggy code. One of them is CI running on merged code. The CI server needs to first merge the code to master, try to run the build and then report the result. That makes sure that everything will work after the merge as well. There is almost a two-year-old [GitLab issue for that feature](https://gitlab.com/gitlab-org/gitlab-ce/issues/4176). There is also an option to use [Semi-linear history merge requests](https://docs.gitlab.com/ee/user/project/merge_requests/index.html#semi-linear-history-merge-requests) that will ensure that merge button will only appear if fast-forward merge would be possible. 

Other possible way to mitigate this is to pull latest master to the branch before merge. But that would make the history very hard to read and reason about. So please do not do this! 

To quickly check if there is something new in master, you can do `git log origin/master ^my-feature-branch --no-merges` that will show any commits in master that are not in your feature branch. 

## Be safe, rebase

To sum up - always make sure your feature branches are based on the current master to ensure that the code will work after you merge it. 




 
