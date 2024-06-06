<?php

require_once 'config_Prod.php';

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Crear una nueva instancia de Capsule
$capsule = new Capsule;

// Configurar la conexión a la base de datos
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Hacer que esta instancia de Capsule esté disponible globalmente vía métodos estáticos
$capsule->setAsGlobal();

// Inicializar Eloquent ORM
$capsule->bootEloquent();
