<?php
use yii\helpers\Url;
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>


<div class="social-wrapper row">
    <div id="social-container">
        <div class="col-xs-12 col-sm-8 col-md-8">
            <!-- Share Form -->
            <div class="widget-container share-widget fluid-height clearfix">
                <div class="clearfix">
                    <div class="col-xs-3 share-options">
                        <a href="<?= Url::toRoute(['/blog/post']) ?>">
                            <i class="glyphicon glyphicon-pencil"></i>
                            <p><?= Yii::t('app', 'Text') ?></p>
                        </a>
                    </div>
                    <div class="col-xs-3 share-options">
                        <a href="<?= Url::toRoute(['/blog/album']) ?>">
                            <i class="glyphicon glyphicon-picture"></i>
                            <p><?= Yii::t('app', 'Photo') ?></p>
                        </a>
                    </div>
                    <div class="col-xs-3 share-options">
                        <a href="<?= Url::toRoute(['/blog/photo']) ?>">
                            <i class="glyphicon glyphicon-music"></i>
                            <p><?= Yii::t('app', 'Music') ?></p>
                        </a>
                    </div>
                    <div class="col-xs-3 share-options">
                        <a href="<?= Url::toRoute(['/blog/photo']) ?>">
                            <i class="glyphicon glyphicon-facetime-video"></i>
                            <p><?= Yii::t('app', 'Video') ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end Share Form -->
            <?= $content ?>
        </div>
    </div>
</div>


<?php $this->endContent(); ?>