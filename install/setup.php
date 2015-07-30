<?php
include_once('header.php');
include_once('install.class.php');
if (file_exists('../common/config/db.php')) {
    echo '</div>
		<div class="alert alert-success" data-dismiss="alert"><strong>Success!</strong> Installation is completed.</div>
		<p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
		<p>If you want to reinstall, deleted <code>common\config\db.php</code> </p>
	 ';
    return;
} else {
    echo '<div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66.6%;">
                Second
            </div>
    </div>';
}
?>

    <?php $install = new Install(); ?>
    <form method="post" action="setup.php">
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
                <button type="submit" class="pull-right btn btn-primary">Install</button>
            </div>
        </div>
    </form>
<?php include_once('footer.php'); ?>
