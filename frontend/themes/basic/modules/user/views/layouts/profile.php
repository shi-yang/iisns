<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\themes\basic\modules\user\ProfileAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

ProfileAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
      <div class="btn-panel">
        <?= Html::a(Yii::$app->setting->get('siteName'), ['/'], ['class' => 'btn btn-warning']) ?>
      </div>
      <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="blog-header">
          <div>
            <img src="<?= Yii::getAlias('@avatar') . $this->params['user']['avatar'] ?>" alt="User Avatar" class="img-thumbnail blog-img">
            <h1 class="blog-title"><?= Html::a(Html::encode($this->params['user']['username']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]) ?></h1>
          </div>
          <div class="clearfix"></div>
          <p class="lead blog-description"><?= Html::encode($this->params['profile']['signature']) ?></p>
        </div>
        <div class="clearfix"></div>
        <div class="row blog-content">
          <div class="col-sm-9 blog-main">
            <?= $content ?>
          </div><!-- /.blog-main -->
          <div class="col-sm-3 blog-sidebar hidden-xs">
            <?php if(!empty($this->params['profile']['description'])): ?>
              <div class="panel">
                <div class="panel-heading">About me</div>
                <div class="panel-body">
                  <?= Html::encode($this->params['profile']['description']) ?>
                </div>
              </div>
            <?php endif ?>
            <div class="panel">
              <div class="panel-heading">
                <span class="glyphicon glyphicon-tags"></span> <?= Yii::t('app', 'Tags') ?>
              </div>
              <div class="panel-body">
                <?php
                  $query = new \justinvoelker\tagging\TaggingQuery;
                  $tags = $query
                      ->select('tags')
                      ->from('{{%blog_post}}')
                      ->where('user_id=:user_id', [':user_id' => $this->params['profile']['user_id']])
                      ->getTags();
                  echo \justinvoelker\tagging\TaggingWidget::widget([
                      'items' => $tags,
                      'liOptions' => ['class' => 'label label-success tags'],
                  ]);
                ?>
              </div>
            </div>
            <!-- /.pancel -->
          </div><!-- /.blog-sidebar -->
        </div><!-- /.row -->
      </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; iiSNS <?= date('Y') ?>
          <?= Html::a (' 中文简体 ', '?lang=zh-CN') . '| ' . 
            Html::a (' English ', '?lang=en') ;  
          ?>
        </p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>