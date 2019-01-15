---
id: 9
title: Samsung F1 HD103UJ ukazuje velikost jen 32MB (resp. 31MB)
date: '2011-05-16 01:30:18 +0200'
---

**English version below.** Dneska sem zase chtěl pracovat. Ale osud tomu chtěl jinak. Při spuštění naběhly Windowsy v pohodě, ale co to?! Chybí mi dvě partition na mém 1TB disku ! Říkal sem si, že se třeba jen nějak uvolnilo napájení a disk se nezapnul. Tak sem vypnul, zkontroloval a zapnul. Ta samá situace. Ve správě disků byl disk nalezený, ale ukazoval jen 32MB. Aj.

Po chvíli googlení jsem zjistil, že s tímto problémem nejsem sám. Ukázalo se, že zmíněných 32MB je velikost cache disku, ke které mám tímto přímý přístup. To je sice fajn, ale já chci svých 700GB dat ! :D Nebudu vás dále napínat a řeknu, že řešení existuje. A není ani tak moc složité. Nepříjemnou zprávou je, že se jedná o problém, který se stává občas, náhodně a na Windows systémech- tzn. dá wse čekat, že se s tím setkáte znovu :)

**_Předem upozorňuji, že neručím za to, že postup bude funkční. Ani za to, že nepřijdete o data. Ale ve valné většině případů by to mělo být úspěšné._**

Problém je v tom, že v disku se nějak poskáče firmware a hlásí všude (i do BIOSu) jen 32MB. Nějaké špatné nastavení LBA. Řešením je [ES Tool od Samsungu](http://www.samsung.com/global/business/hdd/support/utilities/ES_Tool.html). Problém je, že pokud si stahnete CD verzi ESTool, tak nefunguje. Vypálené CD naběhne, ale vyskočí jakýsi error „out of memory“ a ESTool se nespustí. Řešením je vytvořit si bootovací disketu nebo [USB klíčenku](http://www.google.com/search?q=HP+USB+Disk+Storage+Format+Tool+create+boo). A nakopírovat na ní stažené exečko [ESTool.exe](http://www.samsung.com/global/business/hdd/support/utilities/ES_Tool.html) (na webu SAMSUNGU je to ta FDD verze).

**Postup krok za krokem**

*   vytvořit něco čím nabootujete do DOSu (viz výše)
*   na tento vytvořený disk přikopírovat ESTool.exe (fdd verzi) z výše zmíněného odkazu
*   vypnout PC
*   odpojit jakékoli jiné disky v PC, kromě toho poškozeného - _pro jistotu_
*   restartovat PC a nabootovat z USB
    *   unovějších desek stačí během POST (první obrazovka po špuštění PC) zmáčknout F12
    *   pokud to nefunguje dá se nastavit v BIOSu které zařízení bude první bootovat (Advanced > Boot Order nebo tak nějak)
    *   pokud je disk nefunkční, v CD-ROM nemáte CD a je připojená USB klíčenka, tak je velká šance, že to bude fungovat samo od sebe
*   až se objeví příkazový řádek (c:\> nebo jiné písmeno), tak napíšete estool.exe a stisknete Enter
*   po chvíli (trpělivost…) se objeví modrá obrazovka, kde proběhne autodetekce disků… následně by se mělo objevi _0: a za tím nějaké informace o vašem disku_
*   Najedete šipkami na ten záznam a enter
*   V sekci **INFORAMTION** byste měli vidět _Current Size 31 MB (LBA: 65134) Native Size 953869 MB (LBA: 1953525168)_
*   Esc se vrátíte zpět a v sekci **SET MAX ADDRESS** zvolíte **Recover Native Size**
    *   **POZOR! musíte použít tl.** **Recover Native Size** **protože pokud použijete tl. Process, tak přijdete o data**
*   Po projití tímto procesem by měl být disk opět v pořádku a neměli byste přijít o žádná data. V mém případě se objevil disk v průzkumníku včetně všech partition a souborů.

**ENGLISH VERSION**:English version available here (I mirror it just in case it won't work anymore): [http://forums.whirlpool.net.au/…-replies.cfm?…](http://forums.whirlpool.net.au/forum-replies.cfm?t=1069572#r8)

The normal ESTool won't work. Create bootable floppy or [USB pendrive](http://www.google.com/search?q=HP+USB+Disk+Storage+Format+Tool+create+boot) and unzip the FDD version of ESTool onto it.

**First Problem: Can't convert Dynamic Drive back to Basic**

*   Installed Samsung HD103UJ terabyte drive
*   Windows (XP SP3) wanted to make it a Dynamic Drive and I said OK.
*   Bad move! Poor performance, like treacle when copying files
*   I tried to repartition but discovered Dynamic doesn't support them :(
*   I tried to convert back to Basic using Windows tools and also EASEUS Partition Manager but without success

**Solution**

1.  Use [gParted Live CD](http://gparted.sourceforge.net/livecd.php) to wipe, repartition and reformat as NTFS
2.  Problem solved. I chose two 480GB partitions as XP seems faster that way
3.  Tell everyone „whenever Windows wants a Dynamic drive, SAY NO“

**Second Problem: HD103UJ partition disappears, drive only 32MB** It had been working well, connected to an old Sil3114 SATA controller. I filled it with my stuff and retired the old drive as a backup. But next day for unknown reason, after reboot the new partitions vanished. Fortunately it wasn't the system drive so I could still boot.

I tried messing with BIOS settings, reflashed Sil3114 and motherboard BIOS, reinstalled Sil3114 driver etc, all to no avail.

**Solution**

1.  Download [Samsung's ES Tool](http://www.samsung.com/global/business/hdd/support/utilities/ES_Tool.html). I burned the [ISO image](http://www.samsung.com/global/business/hdd/support/downloads/estool_CDROM.zip) [1.86MB] onto CD.
2.  Boot and run. ES Tool detected my Sil3114 card and HD103UJ no problem.
3.  Under INFORMATION menu option the problem became evident: `Current Size 31 MB (LBA: 65134) Native Size 953869 MB (LBA: 1953525168)`
4.  Under „SET MAX ADDRESS“ menu option choose „Recover Native Size“. NB. Don't use „LBA MODE | Process“ because that option needs to wipe your data.
5.  Reboot. Drive reappears in all its 931.51GB of glory. Data is restored! :)