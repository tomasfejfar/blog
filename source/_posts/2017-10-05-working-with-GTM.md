---
id: 39
title: Google Tag Manager - dev & marketing collaboration workflow
date: '2017-10-05 00:00:00 +0200'
excerpt: I've heard it a million times. 'Marketing team broke production web! They put something in Google Tag Manager and caused a JavaScript error. GTM sucks. We should have implemented all the codes ourselves.' What if I tell you there is a better way?
---

I've heard it a million times.

> Marketing team broke production web! They put something in <abbr title="Google Tag Manager">GTM</abbr> and caused a JavaScript error. GTM sucks. We should have implemented all the codes ourselves. 

What if I tell you there is a better way?

## TL;DR

> * Workspace is branch.
> * Published container is master.
> * Only devs have *Publish* access.
> * Do code reviews.

## How it usually goes down?

1. Marketing asks development team to implement GTM
2. Development implements GTM
3. Marketing team starts using GTM
4. Site is broken because of JavaScript error
5. … lots of finger-pointing
6. Unnecessary animosity between dev and marketing

## How do we prevent this?

We use branching and code reviews to prevent bugs in development. We could use the same tools in GTM too!

### Get your user management right

As you would not let marketing deploy your website to production, you should not let them deploy GTM. There are two levels of User Management - *Account* and *Container*. For *Account* permissions you can set either **User** or **Admin** permissions. **Admin** permissions will allow user to change *Permissions* - so that's something only handful of people should have. Everyone else should be just **User**. It's probably a good idea to have a service account with Admin permissions that no-one is actually using. This ensures that you'll always have a way to assign permissions in case of emergencies and vacations. We usually create `sa@example.com` as in "Service Account" and use it as registration mail for services that do not allow multiple users.

For *Container* there are following permissions:

* **No access** - User won't even see the container.
* **Read** - User will be able to see the container, but would not be able to change anything. This is probably useful only for someone whom you don't trust but absolutely HAS to have access.
* **Edit** - This is what you want your marketing team to have.
* **Approve** - This means user is allowed Edits as well as creating new container versions. This could also be useful, but since you can't edit versions after they are created, it's not ideal if you want to do code reviews.
* **Publish** - This only goes to people you'd trust with production deploy rights.

### Create Workspace

In GTM there is a powerful concept of "Workspaces". Workspace is an isolated version of the container where you are safe to make any (even destructive) changes. It's very much like Git branch. You can add new tags, triggers, variables, etc. All the changes are tracked in the workspace. Any change can easily be reverted (*Abandon*) if needed. There is also a *Preview mode* that allows you to see the changes before they are published. If you go to the production web with Preview mode turned on, you'll see *Quick preview* pane at the bottom of the screen. It shows which tags were fired, what values variables hold and what data is in data layer.

### Data belongs to the Data Layer and Variables

Make sure you publish all the data that marketers and SEO specialists may need to the [**data layer**](https://developers.google.com/tag-manager/devguide#adding-data-layer-variables-to-a-page). Also account IDs should go to **Variables** (for more information [this tutorial](https://www.simoahava.com/analytics/variable-guide-google-tag-manager/) is a great resource). It's usually a good idea to create GTM events (for example `datalayer.push({event: purchase})`) for every important website event like submitted subscription form, checkout, purchase, etc. You will be asked to add some more eventually, but great many tracking scripts only need to know that transaction happened so this will take you a long way. If you want to go the extra mile, prepare a Trigger with descriptive name in the GTM. For example, a trigger named `User purchased a product` (Trigger type: `Custom event`, Event name: `purchase`) is much easier to use for non-technical folk.

## Setup a workflow

We actually mimic our development process 1:1 with GTM workspaces.

1. You create a Trello **card in Backlog** explaining the desired change
2. You **move the card to Working**
3. You **create a new Workspace** that has the same name as the card and add a card link to description
4. You copy the link to the Workspace into the card description
5. You do whatever you need in the workspace
6. When you're ready, you **move the card to Ready for review**
7. **Changes are reviewed**
8. Reviewer can **suggests changes** (checklist in the card)
9. Reviewer **publishes the Workspace** (Title and Description are pre-filled from step 3)
10. Reviewer **moves the card to Done**

## Protips

* **Keep in mind you only have 3 workspaces!** If this gives you trouble, [try employing Environments](https://support.google.com/tagmanager/answer/6311518?hl=en) for reviewed workspaces even though you lose some of the flexibility.
* **Make sure every workspace only contains one small change** - [separation of concerns](https://en.wikipedia.org/wiki/Separation_of_concerns#Origin)
* **Don't let workspaces rot** - they are either done or gone.
* **Update your workspaces** - you may need to *Update* your workspace if someone published a container while you were working. It's like pulling master into your branch or rebasing onto master. It even has a nice conflict resolution interface!
* **Don't forget to let marketing know** that you published their changes if they are not part of your review/publish workflow.
* **Be friendly when giving feedback** - both of you are working towards the same goal. Also **be humble** - you may not have all the context of the change - don't assume you do.

