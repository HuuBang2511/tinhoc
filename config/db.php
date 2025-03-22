<?php

$db = [
    'class' => 'yii\db\Connection',
    //'dsn' => 'pgsql:host=192.168.1.44;dbname=quan11_quanlydonvikinhte;port=5454',
    'dsn' => 'pgsql:host=localhost;dbname=trungtamtinhoc;port=5433',
    'username' => 'postgres',
    //'password' => 'postgres',
    'password' => '123456',
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
