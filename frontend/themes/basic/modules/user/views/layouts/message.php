<?php
use yii\helpers\Url;

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Notification');
?>
<?php $this->beginContent('@app/modules/user/views/layouts/user.php'); ?>
<div class="row">
    <div id="inbox-sidebar">
        <!-- Start #inbox-sidebar -->
        <div class="p15">
            <a id="write-inbox" href="<?= Url::toRoute(['/user/message/create']) ?>" class="btn btn-success btn-block uppercase"><?= Yii::t('app', 'Compose') ?></a>
        </div>
        <ul id="inbox-nav" class="nav nav-pills nav-stacked">
            <li><a href="<?= Url::toRoute(['/user/message/inbox']) ?>"><i class="glyphicon glyphicon-inbox"></i> <?= Yii::t('app', 'Inbox') ?> <span class="label label-danger"><?= $this->params['count']['inbox'] ?></span></a>
            </li>
            <li><a href="<?= Url::toRoute(['/user/message/outbox']) ?>"><i class="glyphicon glyphicon-send"></i> <?= Yii::t('app', 'Sent') ?> <span class="label label-success"><?= $this->params['count']['outbox'] ?></span></a>
            </li>
            <li><a href="<?= Url::toRoute(['/user/message/comment']) ?>"><i class="glyphicon glyphicon-comment"></i> <?= Yii::t('app', 'Comment') ?> <span class="label label-success"><?= $this->params['count']['comment'] ?></span></a>
            </li>
        </ul>
    </div>
    <div id="inbox-content">
    <!-- Start #inbox-content -->
        <div class="inbox-wrapper">
            <div class="inbox-toolbar col-lg-12">
                <div class="pull-left" role="toolbar">
                    <a href="#" class="btn btn-default btn-round btn-sm tip mr5" title="Refresh inbox"><i class="glyphicon glyphicon-refresh"></i></a>
                    <a href="#" class="btn btn-default btn-round btn-sm tip mr5" title="Reply"><i class="glyphicon glyphicon-arrow-left"></i></a>
                    <a href="#" class="btn btn-default btn-round btn-sm tip mr5" title="Forward"><i class="glyphicon glyphicon-arrow-right"></i></a>
                    <a href="#" class="btn btn-danger btn-round btn-sm tip mr5" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                </div>
                <div class="inbox-toolbar-search pull-right">
                    <form>
                        <input type="text" class="form-control input-xlarge" name="search" placeholder="Search for inbox ...">
                    </form>
                </div>
            </div>

            <?php echo $content; ?>
        </div>
    <!--End #inbox-content -->
    </div>
</div>
<?php $this->endContent(); ?>
