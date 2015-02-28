<?php

namespace backend\modules\install\models;

use yii\base\Model;
use Yii;
use yii\db\Connection;

class DatabaseForm extends Model
{

    public $type;
    public $host = 'localhost';
    public $port;
    public $dbname;
    public $createdb;
    public $prefix = 'pre_';
    public $user;
    public $password;
    protected $dsn;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['type', 'host', 'dbname'], 'required'],
            [['user'], 'required'],
            [['password', 'port', 'prefix', 'createdb'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => Yii::t('install', 'Database type'),
            'host' => Yii::t('install', 'Host'),
            'port' => Yii::t('install', 'Port'),
            'dbname' => Yii::t('install', 'Database name'),
            'createdb' => Yii::t('install', 'Create database'),
            'user' => Yii::t('install', 'Username'),
            'password' => Yii::t('install', 'Password'),
            'prefix' => Yii::t('install', 'Tables Prefix'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $excepts = [];
        switch ($this->type) {
            case "sqlite":
                $excepts = ['user', 'dbname', 'port', 'prefix', 'password', 'createdb'];
                break;
        }
        foreach ($excepts as $index => $except) {
            $key = array_search($except, $scenarios['default']);
            unset($scenarios['default'][$key]);
        }
        return $scenarios;
    }


    public function getTypes()
    {
        $databases = [
            'MySQL, MariaDB' => [
                'mysql' => extension_loaded('pdo_mysql')
            ],
            'SQLite' => [
                'sqlite' => extension_loaded('pdo_sqlite')
            ],
            'PostgreSQL' => [
                'pgsql' => extension_loaded('pdo_pgsql')
            ],
            'CUBRID' => [
                'cubrid' => extension_loaded('pdo-cubrid')
            ],
            'MicroSoft SQL Server (sqlsrv)' => [
                'sqlsrv' => extension_loaded('pdo_sqlsrv')
            ],
            'MicroSoft SQL Server (dblib)' => [
                'dblib' => extension_loaded('pdo_dblib')
            ],
            'MicroSoft SQL Server (mssql)' => [
                'mssql' => extension_loaded('pdo_mssql')
            ],
            'Oracle' => [
                'oci' => extension_loaded('pdo_oci')
            ]
        ];
        $type = [];
        foreach ($databases as $key => $database) {
            $name = key($database);
            if ($database[$name]) {
                $type[$name] = $key;
            }
        }
        return $type;
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $this->setDsn();
    }

    protected function setDsn()
    {
        $port = null;
        $dbname = null;
        $host = null;
        switch ($this->type) {
            case "mysql":
            case "pgsql":
            case "dblib":
            case "mssql":
            case "cubrid":
                $host = "host={$this->host};";
                $port = $this->port ? "port={$this->port};" : null;
                $dbname = $this->createdb ? null : "dbname={$this->dbname}";
                break;
            case "sqlite":
                $host = $this->host;
                break;
            case 'sqlsrv':
                $host = "Server={$this->host};";
                $port = $this->port ? "port={$this->port};" : null;
                $dbname = $this->createdb ? null : "Database={$this->dbname}";
                break;
            case 'oci':
                $host = "dbname=//{$this->host};";
                $port = $this->port ? ":{$this->port};" : null;
                $dbname = $this->createdb ? null : "/{$this->dbname}";
                break;
        }
        $this->dsn = "{$this->type}:{$host}{$port}{$dbname}";
    }

    public function getDsn()
    {
        return $this->dsn;
    }

    public function createDb($connection = null)
    {
        if (is_null($connection) || !$connection instanceof Connection || !$this->createdb) {
            return null;
        }
        switch ($this->type) {
            case "mysql":
            case "pgsql":
            case "dblib":
            case "mssql":
            case "cubrid":
                $command = $connection->createCommand("CREATE DATABASE `{$this->dbname}`");
                break;
            case "sqlite":
                return true;
            case 'sqlsrv':

                break;
            case 'oci':
                break;
        }
        return $command->execute();
    }

    public function set()
    {
        Yii::$app->session->set('db', $this->attributes);
    }

}
