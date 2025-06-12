@echo off
REM ------------------------------------------------
REM Generar fecha en YYYYMMDD_HHMMSS
REM ------------------------------------------------
for /f "tokens=2-4 delims=/- " %%a in ("%date%") do (
  set DD=%%a
  set MM=%%b
  set YYYY=%%c
)
for /f "tokens=1-3 delims=:. " %%a in ("%time%") do (
  set HH=%%a
  set Min=%%b
  set Sec=%%c
)
set FECHA=%YYYY%%MM%%DD%_%HH%%Min%%Sec%
set FECHA=%FECHA: =0%

REM ------------------------------------------------
REM Rutas y credenciales
REM ------------------------------------------------
set MYSQLDUMP=C:\xampp\mysql\bin\mysqldump.exe
set DB_USER=root
set DB_PASS=
set DB_NAME=inventariomotoracer
set BACKUP_DIR=C:\xampp\htdocs\Proyecto SIMR\backups

REM ------------------------------------------------
REM Asegura que exista backups
REM ------------------------------------------------
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

REM ------------------------------------------------
REM Archivos de salida y logs
REM ------------------------------------------------
set OUT_SQL=%BACKUP_DIR%\%DB_NAME%_%FECHA%.sql
set ERR_LOG=%BACKUP_DIR%\dump_error.log
set RUN_LOG=%BACKUP_DIR%\dump_run.log

echo [%date% %time%] Iniciando mysqldump >> "%RUN_LOG%"

REM ------------------------------------------------
REM Ejecutar mysqldump sin -p si la contraseña está vacía
REM ------------------------------------------------
if "%DB_PASS%"=="" (
  echo Comando: "%MYSQLDUMP%" -u "%DB_USER%" -h localhost "%DB_NAME%" >> "%RUN_LOG%"
  "%MYSQLDUMP%" -u "%DB_USER%" -h localhost "%DB_NAME%" > "%OUT_SQL%" 2> "%ERR_LOG%"
) else (
  echo Comando: "%MYSQLDUMP%" -u "%DB_USER%" -p"%DB_PASS%" -h localhost "%DB_NAME%" >> "%RUN_LOG%"
  "%MYSQLDUMP%" -u "%DB_USER%" -p"%DB_PASS%" -h localhost "%DB_NAME%" > "%OUT_SQL%" 2> "%ERR_LOG%"
)

echo [%date% %time%] Codigo de salida: %ERRORLEVEL% >> "%RUN_LOG%"
if %ERRORLEVEL% neq 0 (
  echo Error en mysqldump, revisa dump_error.log >> "%RUN_LOG%"
) else (
  echo mysqldump completado con exito >> "%RUN_LOG%"
)
