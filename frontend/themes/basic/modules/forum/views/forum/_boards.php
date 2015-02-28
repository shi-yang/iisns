<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Tools;
use app\modules\forum\models\Board;
?>
<?php foreach($boards as $board): ?>
    <?php
        $totalRecords = count($board->subBoards);
        if (($board->parent_id !== Board::AS_CATEGORY && $board->parent_id !== Board::AS_BOARD)
            || ($board->parent_id === Board::AS_CATEGORY && $totalRecords == 0)) {
            continue;
        }
    ?>
    <div class="tbox boarder">
        <?php if ($board->parent_id === Board::AS_CATEGORY): ?>
            <div class="category">
                <h2><?= Html::a(Html::encode($board->name), $board->url) ?></h2>
            </div>
        <?php elseif ($board->parent_id === Board::AS_BOARD): ?>
            <div class="board" onclick="window.location.href= '<?= $board->url ?>';return false">
                <img src="<?= Yii::getAlias('@forum_icon') . '../forum.gif' ?>" class="pull-left">
                <div class="pull-left">
                    <?= Html::a(Html::encode($board->name), $board->url) ?> <br>
                    <?= Html::encode($board->description) ?>
                </div>
                <div class="hidden-xs pull-right" style="width:130px">
                    <i class="glyphicon glyphicon-user"></i> <?= Board::getLastThread($board['id'])['username'] ?> <br>
                    <i class="glyphicon glyphicon-time"></i> <?= Tools::formatTime(Board::getLastThread($board['id'])['create_time']) ?>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php endif ?>

        <table class="table" style="margin-bottom:0">
            <tbody>
                <?php if ($board->columns > 1): ?>
                    <?php 
                        $rowsCount=ceil($totalRecords / $board->columns);
                        $counter = 0; 
                    ?>
                    <?php for ($i=0; $i < $rowsCount; $i++): ?>
                        <tr>
                            <? for ($j=0; $j < $board->columns; $j++): ?>
                                <?php if ($counter < $totalRecords): ?>
                                    <?php $subBoard = $board->subBoards[$counter]; ?>
                                    <td class="boardinfo" width="<?= (100.0 / $board->columns) ?>%" onclick="window.location.href= '<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>';return false">
                                        <div class="pull-left">
                                            <a href="<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>">
                                                <img src="<?= Yii::getAlias('@forum_icon') . '../forum.gif' ?>">
                                            </a>
                                        </div>
                                        <dl style="margin-bottom:0">
                                            <dt>
                                                <?= Html::a(Html::encode($subBoard['name']), ['/forum/board/view', 'id' => $subBoard['id']]) ?>
                                            </dt>
                                            <dd class="hidden-xs" data-toggle="tooltip" data-placement="top" title="Thread Count">
                                                <i class="glyphicon glyphicon-comment"></i> <?= Board::getThreadCount($subBoard['id']) ?> 
                                            </dd>
                                            <dd class="hidden-xs"><i class="glyphicon glyphicon-time"></i> <?= Tools::formatTime(Board::getLastThread($subBoard['id'])['create_time']) ?></dd>
                                        </dl>
                                    </td>
                                <?php endif ?>
                                <?php $counter += 1; ?>
                            <?php endfor ?>
                        </tr>
                    <?php endfor ?>
                <?php else: ?>
                    <?php foreach ($board->subBoards as $subBoard): ?>
                        <tr  onclick="window.location.href= '<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>';return false">
                            <td class="boardinfo" style="vertical-align:middle;">
                                <div class="pull-left">
                                    <a href="<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>">
                                        <img src="<?= Yii::getAlias('@forum_icon') . '../forum.gif' ?>">
                                    </a>
                                </div>
                                <dl style="margin-bottom:0">
                                    <dt><?= Html::a(Html::encode($subBoard['name']), ['/forum/board/view', 'id' => $subBoard['id']]) ?></dt>
                                    <dd><?= Html::encode($subBoard['description']) ?></dd>
                                </dl>
                            </td>
                            <td class="hidden-xs" style="width:100px;">
                                <i class="glyphicon glyphicon-comment"></i> <?= Board::getThreadCount($subBoard['id']) ?> 
                            </td>
                            <td class="hidden-xs" style="width:150px;">
                                <i class="glyphicon glyphicon-user"></i> <?= Board::getLastThread($subBoard['id'])['username'] ?> <br>
                                <i class="glyphicon glyphicon-time"></i> <?= Tools::formatTime(Board::getLastThread($subBoard['id'])['create_time']) ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>