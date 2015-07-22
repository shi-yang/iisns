<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = $model['title'] . '_' . Yii::$app->setting->get('siteName');
$this->params['title'] = Yii::t('app', 'Explore');
$this->params['breadcrumb'][] = $model['title'];
$this->registerMetaTag(['name' => 'keywords', 'content' => $model['title'] . Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => $model['summary']]);
?>
<article class="content">
  <header>
    <a href="<?= Url::toRoute(['/explore/view-post', 'id' => $model['id']]) ?>">
      <h1><?= Html::encode($model['title']) ?></h1>
    </a>
    <address class="meccaddress">
      <time><span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($model['created_at']) ?></time>
      <?php
        if (!empty($model['origin'])) {
          echo " - 来源：" . Html::encode($model['origin']);
        }
      ?>
      - 
      <?php
        if (!empty($post['author'])) {
          echo Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($model['author']), ['/user/view', 'id' => $model['author']]);
        } else {
          echo '<span class="glyphicon glyphicon-user"></span> ' . Html::encode($model['username']);
        }
      ?>
      -
      <span title="<?= Yii::t('app', 'View Count') ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= $model['view_count'] ?></span>
    </address>
  </header>
  <div class="content-text">
    <?= HtmlPurifier::process($model['content']) ?>
  </div>
</article>
