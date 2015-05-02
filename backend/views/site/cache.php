<?php

use yii\helpers\Url;

?>
<a href="<?= Url::toRoute(['/site/cache', 'action' => 'clearall']) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete all cache?') ?>" data-method="post">
    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'removes all data items from the cache.') ?>
</a>
