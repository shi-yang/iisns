<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use justinvoelker\tagging\TaggingWidget;

/* @var $this yii\web\View */

$this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Posts');
$this->params['breadcrumb'][] = Yii::t('app', 'Posts');

$this->registerCss('
.widget {
    position: relative;
    margin-bottom: 20px;
	position: relative;
	margin-bottom: 15px;
	background-color: #fff;
	overflow: hidden;
 	clear: both;
}
.widget .panel-heading, .widget .panel-body {
    padding: 0px;
}
.widget .panel-heading{
	position: relative;
}
.widget .panel-heading:after{
	content: "";
    width: 67px;
    height: 1px;
    background: #007aff;
    position: absolute;
    left: 0;
    bottom: 10px;
}
.widget h3 {
	width: 100%;
	color:#666; /*#666#1FA756*/
	font-size: 16px;
	font-weight: normal;
	padding: 11px 15px 5px 0;
	margin: 0px 0px 10px;
    border-bottom: 1px solid #DFDFDF;
    line-height: 26px;
}
');
?>
<div class="row">
    <div class="col-md-9" id="home-post">
        <?php foreach ($posts['result'] as $post): ?>
            <section class="post-item">
                <div class="row">
                    <div class="post-content col-md-9">
                        <article>
                            <a class="mecctitle" href="<?= Url::toRoute(['/user/view/view-post', 'id' => $post['id']]) ?>" target="_blank" data-pjax="0">
                                <h2><?= Html::encode($post['title']) ?></h2>
                            </a>
                            <address class="meccaddress">
                                <time><span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?></time>
                                -
                                <?= Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['username']), ['/user/view', 'id' => $post['username']]) ?>
                            </address>
                        </article>
                    </div>
                    <div class="post-image col-md-3 hidden-xs">
                        <?php
                            $pattern = "/<[img|IMG].*?src=\"([^^]*?)\".*?>/";
                            preg_match_all($pattern, $post['content'], $match);
                            if (!empty($match[1][0])) {
                                echo Html::a(Html::img($match[1][0], ['class' => 'pull-right']), ['/explore/view-post', 'id' => $post['id']], ['target' => '_blank']);
                            }
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </section>
        <?php endforeach ?>
        <?= LinkPager::widget([
            'pagination' => $posts['pages']
        ]); ?>
    </div>
    <div class="col-md-3">
        <section class="widget widget-tag">
            <header class="panel-heading">
                <h3 class="widget-tit">热门标签</h3>
            </header>
            <section class="panel-body">
                <?= TaggingWidget::widget([
                    'items' => $tags,
                    'url' => ['/explore/posts'],
                    'format' => 'ul',
                    'urlParam' => 'tag',
                    'listOptions' => ['class' => 'tag-group'],
                    'liOptions' => ['class' => 'tag-group-item']
                ]) ?>
            </section>
        </section>
    </div>
</div>
