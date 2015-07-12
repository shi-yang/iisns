<?php
////////////////////
// This file contains the database access information. 
// This file is needed to establish a connection to MySQL

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=iisns',
    'username' => 'root',
    'password' => '123456',
    'tablePrefix' => 'pre_',
    'enableSchemaCache' => true //No need to modify
];
