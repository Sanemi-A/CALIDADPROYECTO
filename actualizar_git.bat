@echo off
:: Cambia al directorio donde se encuentra tu carpeta o proyecto local
cd "C:\xampp\htdocs\laravel\seguimiento"

:: Asegúrate de que los archivos modificados se agreguen al índice
git add .

:: Realiza un commit con un mensaje indicando las modificaciones
git commit -m "Actualización de archivos"

:: Empuja los cambios al repositorio remoto en GitHub
git push origin main

:: Muestra mensaje de éxito
echo ¡Modificaciones subidas correctamente a GitHub!
pause
