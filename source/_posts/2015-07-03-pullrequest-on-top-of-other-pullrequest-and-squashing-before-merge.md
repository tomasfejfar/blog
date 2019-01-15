---
id: 32
status: publish
comments: true
published: true
title: Pullrequest on top of other pullrequest and squashing before merge
date: '2015-07-03 16:14:40 +0200'
date_gmt: '2015-07-03 14:14:40 +0200'
tags:
- tipy
- problem
- ze života
- programování
- git
---

We use pull-requests for development. We do small commits, that allow us to do better review per-commit - usually you add new commit for each code-review issue to allow the reviewer to check that it's fixed. Just before merging the PR we squash all the commits to keep the history clean and tidy. And sometimes it happens that there is a pullrequest (usually refactoring) that is caused by changes required by some other PR. So you develop small PR for the refactoring and on top of it you work on your  feature branch. You happily rebase you working branch on top of the work in PR. Your history may look like this:

```
* 41ae4fd (feature) Feature 2
* 2e8c29d Feature 1
* 1244157 (HEAD, pr/small) Small PR 3
* 58da58e Small PR 2
* 1dd6fb3 (orphan) init
```

You're happy with the work so far, but alas, when the PR is merged and squashed you can't rebase now. Ton of conflicts, empty commits warnings, you have no idea which side of the diff is <em>mine</em> and which is <em>theirs. </em>Awful!

```
* 47a5eca (HEAD, pr/small) Finished PR
| * 41ae4fd (feature) Feature 2
| * 2e8c29d Feature 1
| * 1244157 Small PR 3
| * 58da58e Small PR 2
|/
* 1dd6fb3 (orphan) init
```

That's because your <strong>feature branch</strong> now has all the changes from the <strong>small PR</strong>, but in small commits. Git can't really tell that all the small commits are the same as the one big commit that is now merged. So it blows up in your face. But worry not, there is a simple fix. If you know which commits come from the small PR, you can use <code>git rebase pr/small -i</code> to interactivelly rebase and remove the offending commits.

```
[REMOVED] pick 58da58e Small PR 2
[REMOVED] pick 1244157 Small PR 3
pick 2e8c29d Feature 1
pick 41ae4fd Feature 2
```

You can safely remove them <strong>because you know that changes in those commits are part of the one big commit you're rebasing onto.</strong> And voila! The result:

```
* 557dc4d (HEAD, feature) Feature 2
* dd46b19 Feature 1
* 47a5eca (pr/small) Finished PR
* 1dd6fb3 (orphan) init
```

There are some edge cases that you need to keep in mind. Like when someone else made changes to the PR before squashing - so <em>the squashed commit is not the same as the "sum" of the small commits you have</em>, but in my case this has never been a problem. Let me know how you handle such situations.

