<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php foreach ($posts as $post): ?>
    <section class="post-item">
        <div class="row">
            <div class="titleimg col-md-3 hidden-xs">
                <?php
                    $pattern = "/<[img|IMG].*?src=\"([^^]*?)\".*?>/";
                    preg_match_all($pattern, $post['content'], $match);
                    if (!empty($match[1][0])) {
                        $img = Html::img($match[1][0]);
                        echo Html::a($img, ['/explore/view-post', 'id' => $post['id']], ['target' => '_blank']);
                    }
                ?>
            </div>
            <div class="mecc col-md-9">
                <article>
                    <a class="mecctitle" href="<?= Url::toRoute(['/explore/view-post', 'id' => $post['id']]) ?>" target="_blank">
                        <h2><?= Html::encode($post['title']) ?></h2>
                    </a>
                    <address class="meccaddress">
                        <time><span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?></time>
                        -
                        <?php
                            if (!empty($post['author'])) {
                                echo Html::a('<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['author']), ['/user/view', 'id' => $post['author']]);
                            } else {
                                echo '<span class="glyphicon glyphicon-user"></span> ' . Html::encode($post['username']);
                            }
                        ?>
                        -
                        <span title="<?= Yii::t('app', 'View Count') ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= $post['view_count'] ?></span>
                    </address>
                    <p class="hidden-xs"><?= Html::encode($post['summary']) ?> ... </p>
                </article>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
<?php endforeach ?>
