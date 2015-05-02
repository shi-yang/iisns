<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\home\models\Album;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
$this->registerCss('
.index-all {
    margin-top:20px;
}
.album-all {
list-style-type: none;
}
.album-item {
    float:left;
    padding: 6px;
    border-width: 0;
    border-bottom-width: 1px\9;
    box-shadow: 0 1px 4px rgba(0,0,0,.15);
    width: 170px;
}
.album-cover {
    width:158px;
    height:158px;
}
');
$this->registerCssFile(Yii::getAlias('@web').'/css/forum/css/forum.css');
?>
<div class="index-all">
    <div class="album-all">
        <div class="panel panel-default">
          <div class="panel-heading"><?= Yii::t('app', 'Albums') ?></div>
          <div class="panel-body">
            <div class="row">
                <?php 
                    if ($this->beginCache('explore-album', ['duration' => 3600])) {
                        foreach ($albums as $album) :
                            $coverSrc = Album::getCoverPhoto($album['id']);
                            $link = Url::toRoute(['/explore/view-album', 'id' => $album['id']]);
                ?>
                        <div class="album-item col-md-2 col-sm-6">
                            <div class="album-img">
                                <a href="<?= $link ?>">
                                    <img src="<?= $coverSrc ?>" class="album-cover" alt="album-cover">
                                </a>
                            </div>
                            <?= Html::a(Html::encode($album['name']), ['/explore/view-album', 'id' => $album['id']]) ?>
                        </div>
                        <?php endforeach;
                       $this->endCache();
                    }
                ?>
            </div>
          </div>
        </div>
    </div>
    <div class="forum-all">
        <?= $this->render('_forum', ['forums' => $forums]) ?>
    </div>
</div>
