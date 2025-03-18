<?php

$db = [
    'class' => 'yii\db\Connection',
    //'dsn' => 'pgsql:host=192.168.1.44;dbname=quan11_quanlydonvikinhte;port=5454',
    'dsn' => 'pgsql:host=localhost;dbname=nongho_03032025;port=5432',
    'username' => 'postgres',
    //'password' => 'postgres',
    'password' => 'ngohuubang',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    // 'enableSchemaCache' => true,
    // 'schemaCacheDuration' => 3600,
    // 'schemaCache' => 'cache',
];

// if (YII_ENV_DEV) {
//     $db['dsn'] = 'pgsql:host=localhost;dbname=hcmgis_nongnghiep_bentre;port=5445';
//     $db['enableSchemaCache'] = false;
//     $db['password'] = '@hcmgis#';
// }

return $db;
