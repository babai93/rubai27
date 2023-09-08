@echo on

set wallfolder=D:\Wall

cd /D %wallfolder%

curl -o BITS.jpg https://smartservice.mahindrafs.com/sop/wallpaper/uploads/BITS.jpg

reg add "HKCU\Control Panel\Desktop" /v Wallpaper /f /t REG_SZ /d d:\Wall\BITS.jpg

RUNDLL32.EXE USER32.DLL,UpdatePerUserSystemParameters ,1 ,True

gpupdate /force

pause