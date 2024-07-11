## Indice
***
- [Dependencias](#dependencias)
- [Instrucciones de instalacion](#instrucciones)
- [Ejecucion](#ejecucion)

## Dependencias {#dependencias}
***
- PHP >= 7.4.0
- Composer >= 2.0.0
- Laravel >= 8.0.0
- NodeJS >= 14.16.0

## Instrucciones para instalar {#instrucciones}
***
- Clona el repositorio a tu computadora mediante el siguiente comando => `git clone https://github.com/OsdaGomez99/compras-desarrollo.git`
- En la carpeta del proyecto abre una consola y ejecuta el siguiente comando => `composer install`
- Luego ejecutamos el siguiente comando => `npm install`
- Ahora debemos crear el archivo .env para eso ejecutamos el siguiente comando => `cp .env.example .env`
- En el archivo .env que se acaba de crear se debe configurar la base de datos.
- Debemos generar la llave de encriptacion de la app que se realiza con el siguiente comando => `php artisan key:generate`
- Por ultimo ejecutamos => `npm run dev `

## Ejecucion {#ejecucion}
***
Con una consola en la carpeta del proyecto ejecutamos => `php artisan serve`
Lo que iniciara el servidor de desarrollo, una vez iniciado entramos desde la url proporcionada por el servidor de pruebas.
