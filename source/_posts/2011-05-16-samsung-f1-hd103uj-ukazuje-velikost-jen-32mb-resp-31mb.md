---
id: 9
status: publish
comments: true
published: true
title: Samsung F1 HD103UJ ukazuje velikost jen 32MB (resp. 31MB)
date: '2011-05-16 01:30:18 +0200'
---
<p>
    <strong>English version below. </strong>Dneska sem zase chtěl pracovat. Ale osud tomu chtěl jinak. Při spuštění naběhly Windowsy v pohodě, ale co to?! Chybí mi dvě partition na mém 1TB disku ! Říkal sem si, že se třeba jen nějak uvolnilo napájení a disk se nezapnul. Tak sem vypnul, zkontroloval a zapnul. Ta samá situace. Ve správě disků byl disk nalezený, ale ukazoval jen 32MB. Aj.
</p>
<p>Po chvíli googlení jsem zjistil, že s tímto problémem nejsem sám. Ukázalo se, že zmíněných 32MB je velikost cache disku, ke které mám tímto přímý přístup. To je sice fajn, ale já chci svých 700GB dat ! :D Nebudu vás dále napínat a řeknu, že řešení existuje. A není ani tak moc složité. Nepříjemnou zprávou je, že se jedná o problém, který se stává občas, náhodně a na Windows systémech- tzn. dá wse čekat, že se s tím setkáte znovu :)</p>
<p><strong><em>Předem upozorňuji, že neručím za to, že postup bude funkční. Ani za to, že nepřijdete o data. Ale ve valné většině případů by to mělo být úspěšné. </em></strong></p>
<p>Problém je v tom, že v disku se nějak poskáče firmware a hlásí všude (i do BIOSu) jen 32MB. Nějaké špatné nastavení LBA. Řešením je <a href="http://www.samsung.com/global/business/hdd/support/utilities/ES_Tool.html" target="_blank">ES Tool od Samsungu</a>. Problém je, že pokud si stahnete CD verzi ESTool, tak nefunguje. Vypálené CD naběhne, ale vyskočí jakýsi error „out of memory“ a ESTool se nespustí. Řešením je vytvořit si bootovací disketu nebo
    <a href="http://www.google.com/search?q=HP+USB+Disk+Storage+Format+Tool+create+boo" target="_blank">USB klíčenku</a>. A nakopírovat na ní stažené exečko <a href="http://www.samsung.com/global/business/hdd/support/utilities/ES_Tool.html"
                                                                                                                                                                target="_blank">ESTool.exe</a> (na webu SAMSUNGU je to ta FDD verze).</p> <p>
    <strong>Postup krok za krokem</strong></p>
<ul>
    <li>vytvořit něco čím nabootujete do DOSu (viz výše)</li>
    <li>na tento vytvořený disk přikopírovat ESTool.exe (fdd verzi) z výše zmíněného odkazu</li>
    <li>vypnout PC</li>
    <li>odpojit jakékoli jiné disky v PC, kromě toho poškozeného -<em> pro jistotu</em></li>
    <li>restartovat PC a nabootovat z USB
        <ul>
            <li>unovějších desek stačí během POST (první obrazovka po špuštění PC) zmáčknout F12</li>
            <li>pokud to nefunguje dá se nastavit v BIOSu které zařízení bude první bootovat (Advanced &gt; Boot Order nebo tak nějak)</li>
            <li>pokud je disk nefunkční, v CD-ROM nemáte CD a je připojená USB klíčenka, tak je velká šance, že to bude fungovat samo od sebe</li>
        </ul>
    </li>
    <li>až se objeví příkazový řádek (c:\&gt; nebo jiné písmeno), tak napíšete estool.exe a stisknete Enter</li>
    <li>po chvíli (trpělivost…) se objeví modrá obrazovka, kde proběhne autodetekce disků… následně by se mělo objevi <em>0: a za tím nějaké informace o vašem disku</em></li>
    <li>Najedete šipkami na ten záznam a enter</li>
    <li>V sekci <strong>INFORAMTION </strong>byste měli vidět<em> Current Size 31 MB (LBA: 65134) Native Size 953869 MB (LBA: 1953525168)</em></li>
    <li>Esc se vrátíte zpět a v sekci <strong>SET MAX ADDRESS </strong>zvolíte <strong>Recover Native Size</strong>
        <ul>
            <li><strong>POZOR! musíte použít tl. </strong><strong>Recover Native Size</strong><strong> protože pokud použijete tl. Process, tak přijdete o data</strong></li>
        </ul>
    </li>
    <li>Po projití tímto procesem by měl být disk opět v pořádku a neměli byste přijít o žádná data. V mém případě se objevil disk v průzkumníku včetně všech partition a souborů.</li>
</ul> <p><strong>ENGLISH VERSION</strong>:English version available here (I mirror it just in case it won't work anymore): <a href="http://forums.whirlpool.net.au/forum-replies.cfm?t=1069572#r8"
                                                                                                                              target="_blank">http://forums.whirlpool.net.au/…-replies.cfm?…</a></p> <p>The normal ESTool won't work. Create bootable floppy or<a
        href="http://www.google.com/search?q=HP+USB+Disk+Storage+Format+Tool+create+boot" target="_blank"> USB pendrive</a> and unzip the FDD version of ESTool onto it.</p> <p><strong>First Problem: Can't convert Dynamic Drive back to Basic</strong></p>
<ul>
    <li>Installed Samsung HD103UJ terabyte drive</li>
    <li>Windows (XP SP3) wanted to make it a Dynamic Drive and I said OK.</li>
    <li>Bad move! Poor performance, like treacle when copying files</li>
    <li>I tried to repartition but discovered Dynamic doesn't support them :( </li>
    <li>I tried to convert back to Basic using Windows tools and also EASEUS Partition Manager but without success</li>
</ul> <p><strong>Solution</strong></p>
<ol>
    <li>Use <a rel="nofollow" href="http://gparted.sourceforge.net/livecd.php" target="_blank">gParted Live CD</a> to wipe, repartition and reformat as NTFS</li>
    <li>Problem solved. I chose two 480GB partitions as XP seems faster that way</li>
    <li>Tell everyone „whenever Windows wants a Dynamic drive, SAY NO“</li>
</ol> <p>
    <strong>Second Problem: HD103UJ partition disappears, drive only 32MB</strong> It had been working well, connected to an old Sil3114 SATA controller. I filled it with my stuff and retired the old drive as a backup. But next day for unknown reason, after reboot the new partitions vanished. Fortunately it wasn't the system drive so I could still boot.
</p> <p>I tried messing with BIOS settings, reflashed Sil3114 and motherboard BIOS, reinstalled Sil3114 driver etc, all to no avail.</p> <p><strong>Solution</strong></p>
<ol>
    <li>Download <a rel="nofollow" href="http://www.samsung.com/global/business/hdd/support/utilities/ES_Tool.html" target="_blank">Samsung's ES Tool</a>. I burned the <a rel="nofollow" href="http://www.samsung.com/global/business/hdd/support/downloads/estool_CDROM.zip" target="_blank">ISO image</a> [1.86MB] onto CD.
    </li>
    <li>Boot and run. ES Tool detected my Sil3114 card and HD103UJ no problem.</li>
    <li>Under INFORMATION menu option the problem became evident: <code>Current Size 31 MB (LBA: 65134) Native Size 953869 MB (LBA: 1953525168)</code></li> <li>Under „SET MAX ADDRESS“ menu option choose „Recover Native Size“. NB. Don't use „LBA MODE | Process“ because that option needs to wipe your data.</li>
<li>Reboot. Drive reappears in all its 931.51GB of glory. Data is restored! :)</li>
