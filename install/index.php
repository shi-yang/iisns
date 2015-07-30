<?php
/**
 * iiSNS installer
 * @author       Shiyang <dr@shiyang.me>
 * @copyright    Copyright © 2015 iiSNS
 * @link         http://www.iisns.com
 */
 include_once("header.php");

 //Check for db connect file
	if (file_exists('../common/config/db.php')) {
	    echo '</div>
		<div class="alert alert-success" data-dismiss="alert"><strong>Success!</strong> Installation is completed.</div>
		<p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
		<p>If you want to reinstall, deleted <code>common\config\db.php</code> </p>
	    ';
	} else {
	    echo '
        <div class="progress">
          <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 33.3%;">
            First
          </div>
        </div>
        <h2>Database Installer</h2>
        <p class="lead">Setup your database in minutes! Super easy installation wizard to walk you through the setup process.</p>
		<a href="setup.php" class="btn btn-success">Begin Intallation</a>
	    ';
	}

include_once("footer.php");
