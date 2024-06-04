chcp 65001

@echo off & setlocal
rem echo arg0=%0
rem echo arg1=%1
rem echo arg1 no quotes=%~1
rem echo batfile fullpath=%~f0
rem echo batfile=%~n0
rem echo batfolder=%~dp0

rem set var2="var2"
if "%~1"=="" ( 
    echo arg1 undefined
    set port=8080
) else ( 
    echo arg1 is passed, the value is: %~1
    set port=%~1
)
 

%~dp0/php.exe %~dp0/../src/think run --port %port%
echo %~dp0/php.exe %~dp0/../src/think run --port %port%
rem pause
rem return code demo
exit /b %1