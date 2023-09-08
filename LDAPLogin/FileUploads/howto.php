<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DYI Documents</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
<ul>
	<li>Create a folder called <strong>Wall</strong> in the <strong>D Drive</strong> on the computer</li>
	<li>make a batch file called <strong>setwall.bat</strong></li>
	<li>add the following contain
	<!--<li><img style="width: auto;" src="./uploads/batchfile.jpg"/></li>-->
	<li><pre>
@echo off

curl -k -o BITS.jpg https://smartservice.mahindrafs.com/sop/wallpaper/uploads/BITS.jpg

reg add "HKCU\Control Panel\Desktop" /v Wallpaper /f /t REG_SZ /d d:\Wall\BITS.jpg

RUNDLL32.EXE USER32.DLL,UpdatePerUserSystemParameters ,1 ,True</pre></li>
	<li>Save this file and run the same.</li>
	<li>Set this file auto executable through the <strong>Task Scheduler</strong>, which will run once a day, E.g. 11:45am</li>
	<li>Set the Wallpaper through <strong>GPeditor</strong> (optional)* </li>
	<li>Done!</li>
</ul>
</body>
</html>