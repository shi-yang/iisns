<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 *
 * @author  Shiyang <dr@shiyang.me>
 */

error_reporting(0);
set_time_limit(600);

define('IISNS_ROOT', str_replace('\\', '/', substr(dirname(__FILE__), 0, -7)));

include_once('header.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

use yii\base\Security;

$sqlFile = 'data.sql';
$iisnsVersion = '2.1.3';

header('Content-Type: text/html; charset=utf-8');
$PHP_SELF = addslashes(htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']));

@extract($_POST);
@extract($_GET);

function writable($var)
{
    $writeable = FALSE;
    $var = IISNS_ROOT . $var;
    if (is_dir($var)) {
        $var .= '/temp.txt';
        if (($fp = @fopen($var, 'w')) && (fwrite($fp, 'iisns'))) {
            fclose($fp);
            @unlink($var);
            $writeable = TRUE;
        }
    }
    return $writeable;
}
function query($query) {
    $result = mysql_query($query);
    if (!$result) {
        echo 'Could not run query:' . mysql_error() . '<br/>';
        exit;
    }
    return $result;
}

$dirarray = array (
    'common/config',
    'common/cache',
    'frontend/runtime',
    'frontend/web/assets',
    'frontend/web/uploads',
    'backend/runtime',
    'backend/web/assets',
);
$writeable = array();
foreach ($dirarray as $key => $dir) {
    $writeable[$key]['name'] = $dir;
    if (writable($dir)) {
        $writeable[$key]['status'] = 'OK';
    } else {
        $writeable[$key]['status'] = 'False';
        $quit = TRUE;
    }
}
?>

<?php if (!file_exists('../common/config/db.php')): ?>
    <?php if (!$step): ?>
        <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 33.3%;">
                First
            </div>
        </div>
        <h2>Database Installer</h2>
        <p class="lead">Setup your database in minutes! Super easy installation wizard to walk you through the setup process.</p>
        <table class="table table-hover">
            <caption>Environmental requirements</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Current server</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PHP OS</td>
                    <td><?php echo PHP_OS; ?></td>
                    <td>OK</td>
                </tr>
                <tr>
                    <td>PHP Version</td>
                    <td><?php echo PHP_VERSION; ?></td>
                    <td><?php echo (PHP_VERSION >= '5.4')? 'OK':'False' ?></td>
                </tr>
                <tr>
                    <td>File Upload</td>
                    <td><?php echo @ini_get('upload_max_filesize'); ?></td>
                    <td><?php echo (PHP_VERSION >= '0M')? 'OK':'Warning' ?></td>
                </tr>
                <tr>
                    <td><a href="http://php.net/manual/en/book.mbstring.php">Mbstring Extension</a></td>
                    <td><?php //echo extension_loaded('mbstring'); ?></td>
                    <td><?php echo (extension_loaded('mbstring')) ? 'OK' : 'False' ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-hover">
            <caption>Directory</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($writeable as $item): ?>
                <tr class="<?php echo ($item['status'] == 'OK') ? 'success' : 'danger' ; ?>">
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($quit): ?>
            <a href="index.php" class="btn btn-success">Refresh</a>
        <?php else: ?>
            <a href="index.php?step=2" class="btn btn-success">Begin Intallation</a>
        <?php endif; ?>
    <?php elseif ($step == 2): ?>
        <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66.6%;">
                Second
            </div>
        </div>
        <form method="post" action="index.php?step=3">
            <div class="col-md-6">
                <fieldset>
                    <legend><small>Enter your Database details</small></legend>
                    <div class="form-group">
                        <label class="control-label" for="dbHost">Host</label>
                        <input type="text" class="form-control" id="dbHost" name="dbHost" value="<?php if(isset($_POST['dbHost'])) echo $_POST['dbHost']; else echo 'localhost'; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="dbName">Database name</label>
                        <input type="text" class="form-control" id="dbName" name="dbName" value="<?php if(isset($_POST['dbName'])) echo $_POST['dbName']; ?>" placeholder="Database Name">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="dbUser">Username</label>
                        <input type="text" class="form-control" id="dbUser" name="dbUser" value="<?php if(isset($_POST['dbUser'])) echo $_POST['dbUser']; ?>" placeholder="Database Username">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="dbPass">Password</label>
                        <input type="text" class="form-control" id="dbPass" name="dbPass" value="<?php if(isset($_POST['dbPass'])) echo $_POST['dbPass']; ?>" placeholder="Database Password">
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset>
                    <legend><small>Website Settings</small></legend>
                    <p class="help-block">You can modify it in backend later.</p>
                    <div class="form-group">
                        <label class="control-label" for="siteName">Website Name</label>
                        <input type="text" class="form-control" id="siteName" name="siteName" value="<?php if(isset($_POST['siteName'])) echo $_POST['siteName']; else echo 'iiSNS'; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="siteTitle">Website Title</label>
                        <input type="text" class="form-control" id="siteTitle" name="siteTitle" value="<?php if(isset($_POST['siteTitle'])) echo $_POST['siteTitle']; else echo 'iiSNS - Global Village Entrance'; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="siteDescription">Website Description</label>
                        <textarea class="form-control" id="siteDescription" name="siteDescription"><?php if(isset($_POST['siteDescription'])) echo $_POST['siteDescription']; else echo 'A forum, a blog, and a user center.'; ?></textarea>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><small>Admin Account</small></legend>
                    <div class="form-group">
                        <label class="control-label" for="adminUser">Username</label>
                        <input type="text" class="form-control" id="adminUser" name="adminUser" value="<?php if(isset($_POST['adminUser'])) echo $_POST['adminUser']; else echo 'admin'; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Admin email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo 'admin@'.$_SERVER['HTTP_HOST']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="adminPass">Password</label>
                        <input type="text" class="form-control" id="adminPass" name="adminPass" value="<?php if(isset($_POST['adminPass'])) echo $_POST['adminPass']; ?>">
                    </div>
                </fieldset>
                <div class="form-actions">
                    <button type="submit" class="pull-right btn btn-primary">Next</button>
                </div>
            </div>
        </form>
    <?php elseif ($step == 3): ?>
        <?php if (empty($dbHost) || empty($dbUser) || empty($dbName) || empty($adminUser) || empty($adminPass) || empty($email)
                || empty($siteName) || empty($siteTitle) || empty($siteDescription)): ?>
            <div class="alert alert-danger" role="alert"><strong>Error.</strong> Fill out all the details please</div>
            <a href="index.php?step=2" class="btn btn-default">Previous</a>
        <?php elseif (strlen($adminPass) < 5): ?>
            <div class="alert alert-danger" role="alert"><strong>Error.</strong> Password must be at least 5 characters.</div>
            <a href="index.php?step=2" class="btn btn-default">Previous</a>
        <?php elseif (!@mysql_connect($dbHost, $dbUser, $dbPass)): ?>
            <div class="alert alert-danger" role="alert"><strong>Error.</strong> Your Database details are incorrect.</div>
            <a href="index.php?step=2" class="btn btn-default">Previous</a>
        <?php elseif (!mysql_select_db($dbName, @mysql_connect($dbHost, $dbUser, $dbPass))): ?>
            <div class="alert alert-danger" role="alert"><strong>Error.</strong> Your Database details are incorrect.</div>
            <a href="index.php?step=2" class="btn btn-default">Previous</a>
        <?php else: ?>
            <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66.6%;">
                    Third
                </div>
            </div>
            <div class="well" style="overflow-y:scroll;height:300px;width:100%;">
                <?php
                    $fp = @fopen("../common/config/db.php", "w");
                    fwrite($fp, "
<?php
////////////////////
// This file contains the database access information.
// This file is needed to establish a connection to MySQL
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host={$dbHost};dbname={$dbName}',
    'username' => '{$dbUser}',
    'password' => '{$dbPass}',
    'tablePrefix' => 'pre_',
    'enableSchemaCache' => true //No need to modify
];
");
                    fclose($fp);

                    $fp = fopen($sqlFile, 'rb');
                    $sql = fread($fp, filesize($sqlFile));
                    fclose($fp);
                    foreach (explode(";\n", trim($sql)) as $query) {
                        $query = trim($query);
                        if ($query) {
                            if (substr($query, 0, 12) == 'CREATE TABLE') {
                                $name = preg_replace("/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is", "\\2", $query);
                                echo '<p>Create table '.$name.' ... <span class="label label-success">OK</span></p>';
                                query($query);
                            } else {
                                query($query);
                            }
                        }
                    }
                    $now = time();
                    $username = $adminUser;
                    $password_hash = (new Security)->generatePasswordHash($adminPass);
                    $auth_key = (new Security)->generateRandomString();
                    query("
                        INSERT INTO `pre_user` (`id`, `username`, `password_hash`, `auth_key`, `role`, `email`, `status`, `created_at`, `updated_at`, `avatar`) VALUES
                        (10000, '{$username}', '{$password_hash}', '{$auth_key}', 10, '{$email}', 10, {$now}, {$now}, 'default/10.jpg');
                    ");
                    query("
                        INSERT INTO `pre_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
                        ('/*', 2, NULL, NULL, NULL, {$now}, {$now}),
                        ('超级管理员', 1, '拥有最高权限', NULL, NULL, {$now}, {$now});
                        ");
                    query("
                        INSERT INTO `pre_auth_item_child` (`parent`, `child`) VALUES
                        ('超级管理员', '/*');
                        ");
                    query("
                        INSERT INTO `pre_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
                        ('超级管理员', '10000', {$now});
                        ");
                    query("
                        INSERT INTO `pre_setting` (`key`, `value`) VALUES
                        ('siteName', '{$siteName}'),
                        ('siteTitle', '{$siteTitle}'),
                        ('siteDescription', '{$siteDescription}'),
                        ('version', '" . $iisnsVersion . "');
                    ");
                    query("
                        INSERT INTO `pre_user_data` (`user_id`) VALUES
                        (10000);
                    ");
                    query("
                        INSERT INTO `pre_user_profile` (`user_id`) VALUES
                        (10000);
                    ");
                ?>
            </div>
            <a href="index.php?step=4" class="btn btn-default pull-right">Next</a>
        <?php endif; ?>
    <?php elseif ($step == 4): ?>
        <div class="alert alert-success"><strong>Success!</strong> Installation is completed.</div>
        <p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
        <p>If you want to reinstall, delete <code>common\config\db.php</code> </p>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-success"><strong>Success!</strong> Installation is completed.</div>
    <p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
    <p>If you want to reinstall, deleted <code>common\config\db.php</code> </p>
<?php endif; ?>
<?php include_once('footer.php'); ?>
