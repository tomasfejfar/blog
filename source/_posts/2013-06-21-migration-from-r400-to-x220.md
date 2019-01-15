---
id: 27
status: publish
comments: true
published: true
title: Migration from R400 to X220
date: '2013-06-21 14:35:25 +0200'
date_gmt: '2013-06-21 12:35:25 +0200'
categories:
- Uncategorized
tags: []
---
<p><strong>Updated: </strong>The "hotfix" for SSD works very well. I have been using it for a year now and I had no problems whatsoever.</p>
<hr />
<p>When buying the X220 I hadn't thought much about the implications of the actual migration to the new model. But there were surprises awaiting. Good and bad.</p>
<p>First - good - the display in X220 is awesome. If you can get your hand on one, buy it! It has very nice colors (compared to the yellow-green tint on R400, and practically any other recent ThinkPad) and is much brighter. In combination with matte surface it's ideal for working outside.</p>
<p>Second - bad - the touchpad sucks. A little. It has the "revolutionary" dotted surface, that is supposed to help sliding the fingers. It does. But it also creates not very pleasant feeling. Something like you have when working with sandpaper for extended period of time. I hope I'll get used to it. If not, TrackPoint to the rescue!</p>
<p>Third - good - the exact model I got is a beast! It's i7 with 8 gigs of RAM and 7200RPM HDD.  Just screaming for SSD. And I have one. 256GB Intel 320. But...</p>
<p>Fourth - bad - the X220 is so small that it saves space by using 7mm HDD. Ouch. The Intel 320 is very 9.5mm-ish :(</p>
<h2>How to fit 9.5mm drive into X220 7mm hole?</h2>
<p>It was surprisingly simple, well it's simple if you use SSD. With SSD you don't care about vibrations and other physical effects like sudden acceleration, etc. For HDDs Lenovo uses rubber bands that go along the sides of the drive to reduce vibration and act as a pillow (in addition to Active Protection System) in case of  a fall. Those are not needed with SSD. And luckily those together with the HDD case are exactly 2.5mm high. That means that if you don't use the case and rubbers you can fit the 9.5mm drive into the slot.</p>
<p>One problem is that the HDD case has a band on it, used to pull the drive out of the casing. That can be easily fixed using two pieces of duct tape. Put one long piece on the top and one on the bottom of the drive so that there is a bit of a loose end on the side opposite to the connectors. Then press them together in front of the drive to form something that resembles the original band. If the pieces are long enough, they can withstand quite some pulling power. I managed to pull the drive out sing two pieces of transparent tape. With duct tape you're on the safe side. Make the band long enough, so that when you close the door to the casing, it will be collapsed between the door and the drive - that will stop the drive from falling out of the connectors in case of sudden side acceleration.</p>
<p>The credit for this solution goes to <a href="http://superuser.com/questions/403565/different-versions-of-2-5-drives-unscrewing-intel-320-for-slimmer-drive-to-fit/404112#404112">adam on SuperUser</a>, who claims he has been using it for past 5 months without problems.</p>
<p>Last surprise was that I could just switch the drives and Windows 8 on SSD worker with only minor hiccup. I put the SSD in X200, turn it on. It failed to boot the first time. The second time it ran some tests, displayed something about "Configuring devices" and booted happily after restart. One other thing surprised me - it forgot most of the sensitive information (filled wifi passwords being the most prominent example). Obviously the cipher used is based on some unique identifier of the machine and does not work when the drive is moved to different one. Nice security feature.</p>
<p>I'm quite happy with the new machine. I'll add some more thoughts after I explore it little more.</p>