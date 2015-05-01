<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
?>

<?php if (!empty($posts)): ?>
    <ul class="posts" id="posts">
        <?php foreach ($posts as $post) :?>
            <li class="post-container">
                <div class="post post-full">
                    <div class="post-wrapper">
                        <div class="post-content">
                            <h3><?php echo Html::encode($post['title']); ?></h3>
                            <?php //$this->beginWidget('HtmlPurifier'); ?>
                            <?php echo $post['content']; ?>
                            <?php //$this->endWidget(); ?>
                        </div>
                        <div class="post-footer">
                            <div class="time">
                                <?= \app\components\Tools::formatTime($post['create_time']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?= LinkPager::widget([
           'pagination' => $pages,
    ]) ?>
<?php else: ?>
    <div class="no-data-found">
        <i class="glyphicon glyphicon-folder-open"></i>
        <?php echo Html::encode(Yii::t('app', 'No posts found.')); ?>
    </div>
<?php endif; ?>    