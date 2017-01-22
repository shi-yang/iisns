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
              <span class="info-box-number"><?= $userCount ?></span>
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
              <span class="info-box-number"><?= $postCount ?></span>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="glyphicon glyphicon-apple"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">CPU Traffic</span>
              <span class="info-box-number">9999999999<small>%</small></span>
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <div class="info-box">
            <span class="info-box-icon bg-yellow">
                <i class="glyphicon glyphicon-knight"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text">CPU Traffic</span>
              <span class="info-box-number">9999999999<small>%</small></span>
            </div>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">Headlines</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <h1>h1. Bootstrap heading</h1>

                <h2>h2. Bootstrap heading</h2>

                <h3>h3. Bootstrap heading</h3>
                <h4>h4. Bootstrap heading</h4>
                <h5>h5. Bootstrap heading</h5>
                <h6>h6. Bootstrap heading</h6>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>
                <h3 class="box-title">Text Emphasis</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <p class="lead">Lead to emphasize importance</p>

                <p class="text-green">Text green to emphasize success</p>

                <p class="text-aqua">Text aqua to emphasize info</p>

                <p class="text-light-blue">Text light blue to emphasize info (2)</p>

                <p class="text-red">Text red to emphasize danger</p>

                <p class="text-yellow">Text yellow to emphasize warning</p>

                <p class="text-muted">Text muted to emphasize general</p>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

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
