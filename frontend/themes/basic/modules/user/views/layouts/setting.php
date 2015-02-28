<?php
use yii\bootstrap\Nav;

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Setting');
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>
      <div class="col-xs-12 col-sm-4 col-md-2">
      <?= Nav::widget([
          'encodeLabels' => false,
          'items' => [
              ['label' => '<span class="glyphicon glyphicon-home"></span> ' . Yii::t('app', 'Profile'), 'url' => ['setting/profile']],
              ['label' => '<span class="glyphicon glyphicon-user"></span> ' . Yii::t('app', 'Account'), 'url' => ['setting/account']],
              ['label' => '<span class="glyphicon glyphicon-cog"></span> ' . Yii::t('app', 'Security'), 'url' => ['setting/security']],
          ],
          'options' => ['class' => 'nav-pills nav-stacked']
      ])
      
      ?>
      </div>
      <div class="col-xs-12 col-sm-8 col-md-10">
        <?php echo $content; ?>
      </div>
<?php $this->endContent(); ?>