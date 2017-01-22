<?php
/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteName');
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="glyphicon glyphicon-user"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text"><?= Yii::t('app', 'Registered users') ?></span>
              <span class="info-box-number"><?= $statistics['userCount'] ?></span>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <div class="info-box">
            <span class="info-box-icon bg-red">
                <i class="glyphicon glyphicon-education"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">Forum Posts</span>
              <span class="info-box-number"><?= $statistics['postCount'] ?></span>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="glyphicon glyphicon-apple"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Photos</span>
                <span class="info-box-number"><?= $statistics['photoCount'] ?></span>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <div class="info-box">
            <span class="info-box-icon bg-yellow">
                <i class="glyphicon glyphicon-knight"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Forum</span>
                <span class="info-box-number"><?= $statistics['forumCount'] ?></span>
            </div>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= Yii::t('app', 'Service Data Table') ?></h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>iiSNS version</td>
                            <td><?= Yii::$app->setting->getVersion() ?></td>
                        </tr>
                        <tr>
                            <td>The operating system</td>
                            <td><?= php_uname() ?></td>
                        </tr>
                        <tr>
                            <td>PHP version</td>
                            <td><?= phpversion() ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
