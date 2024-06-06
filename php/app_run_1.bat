@echo off
:: 要启动的进程的完整路径
set prog_path=""D:\GreenSoft\Eserver\core\software\tool\Notepad3\Notepad3.exe""
:: 启动进程
start "" %prog_path%

:: 获取进程 ID
for /F "tokens=1 delims= " %%i in ('tasklist /FI "PID eq %pid%"/FI "imagename eq %prog_path%" 2^>nul') do set pid=%%i

:: 将进程 ID 写入文件
php think common:appstarted 1 %pid%