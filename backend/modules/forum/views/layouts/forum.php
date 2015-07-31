<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use frontend\widgets\Alert;

?>

<?php $this->beginContent('@backend/views/layouts/main.php') ?>
<div class="container-fluid main-content">
    <div class="row">
        <div class="col-lg-12">
            <?= Alert::widget() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a class="list-group-item" href="<?= Url::toRoute(['/forum/forum/index']) ?>"><i class="glyphicon glyphicon-chevron-right pull-right"></i><span><?= Yii::t('forum', 'Forum') ?></span></a>
                <a class="list-group-item" href="<?= Url::toRoute(['/forum/board/index']) ?>"><i class="glyphicon glyphicon-chevron-right pull-right"></i><span><?= Yii::t('forum', 'Board') ?></span></a>
                <a class="list-group-item" href="<?= Url::toRoute(['/forum/thread/index']) ?>"><i class="glyphicon glyphicon-chevron-right pull-right"></i><span><?= Yii::t('forum', 'Thread') ?></span></a>
                <a class="list-group-item" href="<?= Url::toRoute(['/forum/post/index']) ?>"><i class="glyphicon glyphicon-chevron-right pull-right"></i><span><?= Yii::t('forum', 'Post') ?></span></a>
            </div>
        </div>
        <div class="col-md-9">
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
