<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\forum\models\Board;

$this->params['forum'] = $forum->toArray;

$subBoards = $model->getSubBoards($parentId);
$totalRecords = count($subBoards);
$columnsCount = $model->columns;
?>

<div class="tbox boarder">
    <div class="category" style="boarder-bottom:none;">
        <h2><?= Html::encode($model->name) ?></h2>
    </div>
    <table class="table" style="margin-bottom:0">
        <tbody>
            <?php if ($model->columns > 1): ?>
                <?php 
                    $rowsCount=ceil($totalRecords / $columnsCount);
                    $counter = 0; 
                ?>
                <?php for ($i=0; $i < $rowsCount; $i++): ?>
                    <tr class="boardinfo">
                        <?php for ($j=0; $j < $columnsCount; $j++): ?>
                            <?php if ($counter < $totalRecords): ?>
                                <?php $subBoard = $subBoards[$counter]; ?>
                                <td width="<?= (100.0 / $columnsCount) ?>%" onclick="window.location.href= '<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>';return false">
                                    <div class="pull-left">
                                        <a href="<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>">
                                            <img src="<?= Yii::getAlias('@web') . '/images/forum.gif' ?>">
                                        </a>
                                    </div>
                                    <dl style="margin-bottom:0">
                                        <dt>
                                            <?= Html::a(Html::encode($subBoard['name']), ['/forum/board/view', 'id' => $subBoard['id']]) ?>
                                        </dt>
                                        <dd class="hidden-xs" data-toggle="tooltip" data-placement="top" title="Thread Count">
                                            <i class="glyphicon glyphicon-comment"></i> <?= Board::getThreadCount($subBoard['id']) ?> 
                                        </dd>
                                        <dd class="hidden-xs"><i class="glyphicon glyphicon-time"></i> <?= Yii::$app->formatter->asRelativeTime(Board::getLastThread($subBoard['id'])['created_at']) ?></dd>
                                    </dl>
                                </td>
                            <?php endif ?>
                            <?php $counter += 1; ?>
                        <?php endfor ?>
                    </tr>
                <?php endfor ?>
            <?php else: ?>
                <?php foreach ($subBoards as $subBoard): ?>
                    <tr  class="boardinfo" onclick="window.location.href= '<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>';return false">
                        <td style="vertical-align:middle;">
                            <div class="pull-left">
                                <a href="<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>">
                                    <img src="<?= Yii::getAlias('@web') . '/images/forum.gif' ?>">
                                </a>
                            </div>
                            <dl style="margin-bottom:0">
                                <dt><?= Html::a(Html::encode($subBoard['name']), ['/forum/board/view', 'id' => $subBoard['id']]) ?></dt>
                                <dd><?= Html::encode($subBoard['description']) ?></dd>
                            </dl>
                        </td>
                        <td class="smallFont" style="vertical-align:middle;width:220px;">
                            <?= Board::getLastThread($subBoard['id'])['username'] ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>
