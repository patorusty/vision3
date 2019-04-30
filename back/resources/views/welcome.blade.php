<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    </head>
    <body>
    <?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))){
echo 'La zona horaria del script DIFIERE  de la zona horaria de la configuracion ini.';
} else {
echo 'La zona horaria del script y la zona horaria de la configuracion ini COINCIDEN.';
}

echo date_default_timezone_get();
?>
    </body>
</html>
