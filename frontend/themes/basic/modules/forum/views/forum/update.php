<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */
/* @var $action string */

$this->title = $model->forum_name;
$this->params['forum'] = $model->toArray;
?>
<div id="layout"></div>
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
              <a class="list-group-item" href="<?= Url::toRoute(['/forum/forum/update', 'id' => $model->forum_url, 'action' => 'dashboard']) ?>">
                <p><?= Yii::t('app', 'Information') ?></p>
              <a class="list-group-item" href="<?= Url::toRoute(['/forum/forum/update', 'id' => $model->forum_url, 'action' => 'board']) ?>">
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
