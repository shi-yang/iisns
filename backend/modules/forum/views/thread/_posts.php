<?php 

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use shiyang\infinitescroll\InfiniteScrollPager;

$floor = 1;
if (isset($_GET['page']) >= 2) //分页标识大于2才开始计算
    $floor += ($pageSize * $_GET['page']) - $pageSize;
?>
<section class="posts">
    <div class="post-title">
        <h3><?= Yii::t('app', '{postCount} comments', ['postCount' => $postCount]) ?></h3>
    </div>
    <div id="post-list">
        <?php foreach($posts as $post):
            $floor_number=$floor++; //楼层数减少
            ?>
            <div class="row post-item">
                <div class="col-sm-2">
                    <div class="post-user-info">
                        <div class="hidden-xs">
                            <img class="img-circle" src="<?= Yii::getAlias('@avatar') . $post['avatar'] ?>" alt="User avatar">
                        </div>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="post-meta">
                        <?= Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['username']), ['/user/view', 'id' => $post['username']]) ?>
                        &nbsp;•&nbsp;
                        <span class="post-time">
                            <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?>
                        </span>
                        <a class="floor-number" id="<?= $floor_number ?>" href="#<?= $floor_number ?>">
                           <span class="badge"><?= $floor_number ?>#</span>
                        </a>
                    </div>
                    <div class="post-content">
                        <?= HtmlPurifier::process($post['content']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $pages,
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
    </div>
</section>
