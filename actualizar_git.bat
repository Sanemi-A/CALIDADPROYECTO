@echo off
cd /d "C:\xampp\htdocs\laravel\Cinfo"

:: Verifica si Git está instalado
git --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Git no está instalado o no está en el PATH.
    pause
    exit /b
)

:: Cambiar a la rama main
git checkout main

:: Solicitar mensaje para el commit
set /p commit_msg=Escribe un mensaje para esta actualización: 
if "%commit_msg%"=="" set commit_msg=Actualización automática

:: Agregar cambios y hacer commit
git add .
git commit -m "%commit_msg%"

:: Subir la rama main al repositorio remoto
git push origin main
if %errorlevel% neq 0 (
    echo ERROR: No se pudieron subir los cambios. Verifica tu conexión o credenciales.
    pause
    exit /b
)

echo ¡Modificaciones subidas correctamente a 'main' en GitHub!
pause
