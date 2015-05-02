<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = $model->forum_name;
$this->params['forum'] = $model->toArray;
?>
<div id="layout"></div>
<!-- Statistics -->
<div class="row">
    <div class="col-lg-12">
        <div class="widget-container stats-container">
            <div class="col-md-3">
                <div class="number">
                    <div class="icon glyphicon glyphicon-search"></div>
                    99<small>%</small>
                </div>
                <div class="text">
                    Overall growth
                </div>
            </div>
            <div class="col-md-3">
                <div class="number">
                    <div class="icon glyphicon glyphicon-search"></div>
                    <?= $model->followerCount ?>
                </div>
                <div class="text">
                    Followers
                </div>
            </div>
            <div class="col-md-3">
                <div class="number">
                    <div class="icon glyphicon glyphicon-search"></div>
                    999
                </div>
                <div class="text">
                    Views
                </div>
            </div>
            <div class="col-md-3">
                <div class="number">
                    <div class="icon glyphicon glyphicon-search"></div>
                    <?= $model->threadCount ?>
                </div>
                <div class="text">
                    Threads
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
              <a class="list-group-item" href="<?= Url::toRoute(['/forum/forum/update', 'id' => $model->id, 'action' => 'dashboard']) ?>">
                <p><?= Yii::t('app', 'Information') ?></p>
              <a class="list-group-item" href="<?= Url::toRoute(['/forum/forum/update', 'id' => $model->id, 'action' => 'board']) ?>">
                <p><?= Yii::t('app', 'Board Manage') ?></p>
              </a>
        </div>
    </div>
    <div class="col-md-9">
        <?php 
          switch ($action) {
            case 'dashboard':
              echo $this->render('_dashboard', [
                'model'=>$model, 
              ]); 
              break;
            case 'board':
              echo $this->render('_board_manage', [
                'model'=>$model,
                'newBoard'=>$newBoard,
              ]);
              break;
            default:
              echo $this->render('_dashboard', [
                'model'=>$model,
              ]);
              break;
          }
        ?>
    </div>
</div>
