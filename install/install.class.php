<?php
/**
 * iiSNS installer
 * @author       Shiyang <dr@shiyang.me>
 * @copyright    Copyright © 2015 iiSNS
 * @link         http://www.iisns.com
 */
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

use yii\base\Security;

class Install {
    public $sqlFile = 'data.sql';
    private $error;
    private $link;
    private $settings = array();
/*    function __construct() {
        $this->checkInstall($hideError = true);
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->settings[$key] = $value;
            }
            $this->validate();
        }
        if (!empty($this->error)) echo $this->error;
    }*/
    // Run queries
    private function query($query) {
        $result = mysql_query($query);
        if (!$result) {
            echo 'Could not run query:' . mysql_error() . '<br/>';
            include_once ('footer.php');
            exit;
        }
        return $result;
    }
    // Check for all form fields to be filled out
    private function validate() {
        if (empty($this->settings['dbHost']) || empty($this->settings['dbUser']) || empty($this->settings['dbName'])
            || empty($this->settings['adminUser']) || empty($this->settings['adminPass']) || empty($this->settings['email'])
            || empty($this->settings['siteName']) || empty($this->settings['siteTitle']) || empty($this->settings['siteDescription'])) {
            $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Fill out all the details please</div>';
        }
        if(strlen($this->settings['adminPass']) < 5) {
            $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Password must be at least 5 characters.</div>';
        } else {
            $this->settings['adminPass'] = (new Security)->generatePasswordHash($this->settings['adminPass']);
        }
        // Check the database connection
        $this->dbLink();
    }
    // Check if there is a connection to the mysql server
    private function dbLink() {
        if (empty($this->error)) {
            $this->link = @mysql_connect($this->settings['dbHost'], $this->settings['dbUser'], $this->settings['dbPass']);
            if (!$this->link) {
                $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Your Database details are incorrect.</div>';
            } else {
                $this->dbSelect();
            }
        }
    }
    // Check for database selection
    private function dbSelect() {
        if (empty($this->error)) {
            $dbSelect = mysql_select_db($this->settings['dbName'], $this->link);
            if (!$dbSelect) {
                $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Database name doesn\'t exist!</div>';
            } else {
                $this->existingTables();
            }
        }
    }
    // Check for an existing installation
    private function existingTables() {
        if (empty($this->error)) {
            $this->insertSQL();
            $this->writeFile();
            $this->checkInstall();
        }
    }
    // Insert SQL data
    public static function insertSQL() {
        if (empty($this->error)) {
            $now = time();
            $username = $this->settings['adminUser'];
            $password_hash = $this->settings['adminPass'];
            $auth_key = (new Security)->generateRandomString();
            $email = $this->settings['email'];

            $fp = fopen($this->sqlFile, 'rb');
            $sql = fread($fp, filesize($this->sqlFile));
            fclose($fp);
            foreach (explode(";\n", trim($sql)) as $query) {
                $query = trim($query);
                if ($query) {
                    if (substr($query, 0, 12) == 'CREATE TABLE') {
                        $name = preg_replace("/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is", "\\2", $query);
                        echo '<p>Create table '.$name.' ... <span class="blue">OK</span></p>';
                        $this->query($query);
                    } else {
                        $this->query($query);
                    }
                }
            }

            $this->query("
              INSERT INTO `pre_user` (`id`, `username`, `password_hash`, `auth_key`, `role`, `email`, `status`, `created_at`, `updated_at`, `avatar`) VALUES
              (10000, '{$username}', '{$password_hash}', '{$auth_key}', 10, '{$email}', 10, {$now}, {$now}, 'default/10.jpg');
            ");
            $this->query("
              INSERT INTO `pre_setting` (`key`, `value`) VALUES
              ('siteName', '" . $this->settings['siteName'] . "'),
              ('siteTitle', '" . $this->settings['siteTitle'] . "'),
              ('siteDescription', '" . $this->settings['siteDescription'] . "'),
              ('version', '2.1.4');
            ");
        } else $this->error = 'Your tables already exist! I won\'t insert anything.';
    }
    private function writeFile() {
        if ($this->error == '') {
            /** Write db.php if it doesn't exist */
            $fp = @fopen("../common/config/db.php", "w");
            if (!$fp):
                echo '<div class="alert alert-warning">Could not create <code>common/config/db.php</code>, please confirm you have permission to create the file.</div>';
                return false;
            endif;
            fwrite($fp, "<?php
////////////////////
// This file contains the database access information. 
// This file is needed to establish a connection to MySQL
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host={$this->settings['dbHost']};dbname={$this->settings['dbName']}',
    'username' => '{$this->settings['dbUser']}',
    'password' => '{$this->settings['dbPass']}',
    'tablePrefix' => 'pre_',
    'enableSchemaCache' => true //No need to modify
];
      ");
            fclose($fp);
        }
    }
    private function checkInstall($hideError = false) {
        if (file_exists('../common/config/db.php')):
            echo '
  <div class="progress">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
      Success.
    </div>
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="alert alert-success"><strong>Success!</strong> Installation is completed </div>
      <p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
    </div>
  </div>
  ';
            include ('footer.php');
            exit();
        else:
            if (!$hideError) $this->error = '<div class="alert alert-error">Installation is not complete.</div>';
        endif;
    }
}
