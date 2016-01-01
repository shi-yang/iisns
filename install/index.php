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

include('header.php');
include('install.class.php');

$sqlFile = 'data.sql';

header('Content-Type: text/html; charset=utf-8');
$PHP_SELF = addslashes(htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']));

@extract($_POST);
@extract($_GET);

function result($result = 1, $output = 1) {
    if ($result) {
        $text = '<span class="blue">OK</span>';
        if (!$output) {
            return $text;
        }
        echo $text;
    } else {
        $text = '<span class="red">Failed</span>';
        if (!$output) {
            return $text;
        }
        echo $text;
    }
}
function writable($var)
{
    $writeable = FALSE;
//    if(!is_dir($var)) {
//        @mkdir($var, 0777);
//    }
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
$dirarray = array (
    'data',
    '_runtime',
    'install',
    'config',
);
$writeable = array();
foreach ($dirarray as $key => $dir) {
    if (writable($dir)) {
        $writeable[$key] = $dir.result(1, 0);
    } else {
        $writeable[$key] = $dir.result(0, 0);
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
                <th>Situation</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>PHP OS</td>
                <td><?php echo PHP_OS; ?></td>
                <td><?php result(1, 1); ?></td>
            </tr>
            <tr>
                <td>PHP Version</td>
                <td><?php echo PHP_VERSION; ?></td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>PHP Memory</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
            <tr>
                <td>File Upload</td>
                <td><?php echo @ini_get('upload_max_filesize'); ?></td>
                <td><?php echo @ini_get('upload_max_filesize'); ?></td>
            </tr>
            <tr class="<?php echo (extension_loaded('mbstring')) ? 'success' : 'danger' ?>">
                <td><a href="http://php.net/manual/en/book.mbstring.php">Mbstring Extension</a></td>
                <td><?php //echo extension_loaded('mbstring'); ?></td>
                <td><?php echo (extension_loaded('mbstring')) ? 'Passed' : 'Warning' ?></td>
            </tr>
            <tr>
                <td>PHP Version</td>
                <td><?php echo PHP_VERSION; ?></td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>PHP Version</td>
                <td><?php echo PHP_VERSION; ?></td>
                <td>@fat</td>
            </tr>
            </tbody>
        </table>
        <div class="shade">
            <h5>PHP Version&nbsp;&nbsp;<span class="p">
                <?php
                echo PHP_VERSION;
                if (PHP_VERSION < '5.2.0') {
                    result(0, 1);
                    $quit = TRUE;
                } else {
                    result(1, 1);
                } ?>
                </span></h5>

            <h5><?php echo $i_message['php_memory'];?>&nbsp;&nbsp;<span class="p"><?php
                    echo $i_message['support'],'/',@ini_get('memory_limit');
                    if ((int)@ini_get('memory_limit') < (int)'32M') {
                        result(0, 1);
                        $quit = TRUE;
                    } else {
                        result(1, 1);
                    }
                    ?></span></h5>

            <h5><?php echo $i_message['file_upload'];?>&nbsp;&nbsp;<spam class="p"><?php
                    if (@ini_get('file_uploads')) {
                        echo $i_message['support'],'/',@ini_get('upload_max_filesize');
                    } else {
                        echo '<span class="red">'.$i_message['unsupport'].'</span>';
                    }
                    result(1, 1);
                    ?></spam></h5>

            <h5><?php echo $i_message['mysql'];?>&nbsp;&nbsp;<span class="p"><?php
                    if (function_exists('mysql_connect')) {
                        echo $i_message['support'];
                        result(1, 1);
                    } else {
                        echo '<span class="red">'.$i_message['mysql_unsupport'].'</span>';
                        result(0, 1);
                        $quit = TRUE;
                    }
                    ?></span></h5>

            <h5><?php echo $i_message['php_extention'];?></h5>
            <p>&nbsp;&nbsp;
                <?php
                if (extension_loaded('mysql')) {
                    echo 'mysql:'.$i_message['support'];
                    result(1, 1);
                } else {
                    echo '<span class="red">'.$i_message['php_extention_unload_mysql'].'</span>';
                    result(0, 1);
                    $quit = TRUE;
                }
                ?></p>
            <p>&nbsp;&nbsp;
                <?php
                if (extension_loaded('gd')) {
                    echo 'gd:'.$i_message['support'];
                    result(1, 1);
                } else {
                    echo '<span class="red">'.$i_message['php_extention_unload_gd'].'</span>';
                    result(0, 1);
                    $quit = TRUE;
                }
                ?></p>
            <p>&nbsp;&nbsp;
                <?php
                if (extension_loaded('curl')) {
                    echo 'curl:'.$i_message['support'];
                    result(1, 1);
                } else {
                    echo '<span class="red">'.$i_message['php_extention_unload_curl'].'</span>';
                    result(0, 1);
                    $quit = TRUE;
                }
                ?></p>
            <p>&nbsp;&nbsp;
                <?php
                if (extension_loaded('mbstring')) {
                    echo 'mbstring:'.$i_message['support'];
                    result(1, 1);
                } else {
                    echo '<span class="red">'.$i_message['php_extention_unload_mbstring'].'</span>';
                    result(0, 1);
                    $quit = TRUE;
                }
                ?></p>

        </div>
        <h2>Directory</h2>
        <div class="shade">
            <?php foreach ($writeable as $value) {
                echo '<p>'.$value.'</p>';
            } ?>
        </div>

        <a href="index.php?step=2" class="btn btn-success">Begin Intallation</a>
    <?php elseif ($step == 2): ?>
        <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66.6%;">
                Second
            </div>
        </div>
        <form method="post" action="index.php?step=2">
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

        <div style="overflow-y:scroll;height:300px;width:100%;padding:5px;border:1px solid #ccc;">
            <?php
            $fp = fopen($sqlFile, 'rb');
            $sql = fread($fp, filesize($sqlFile));
            fclose($fp);
            foreach (explode(";\n", trim($sql)) as $query) {
                $query = trim($query);
                if ($query) {
                    if (substr($query, 0, 12) == 'CREATE TABLE') {
                        $name = preg_replace("/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is", "\\2", $query);
                        echo '<p>Create table '.$name.' ... <span class="blue">OK</span></p>';
                        //$this->query($query);
                    } else {
                        //$this->query($query);
                    }
                }
            }
            ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-success" data-dismiss="alert"><strong>Success!</strong> Installation is completed.</div>
    <p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
    <p>If you want to reinstall, deleted <code>common\config\db.php</code> </p>
<?php endif; ?>
<?php include_once('footer.php'); ?>
