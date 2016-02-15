<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\modules\forum\models\Board;
?>

<?php foreach($model->boards as $board): ?>
    <?php
        $totalRecords = count($board->subBoards);
    ?>
    <div class="tbox boarder">
        <div class="<?= ($board->parent_id == Board::AS_CATEGORY) ? 'category' : 'board' ; ?>" style="boarder-bottom:none;">
            <h2>
                <?php if ($board->parent_id == Board::AS_BOARD): ?>
                    <img src="<?= Yii::getAlias('@forum_icon') . '../forum.gif' ?>">
                <?php endif ?>
                <?= Html::a(Html::encode($board->name), $board->url) ?>
                <div class="pull-right">
                    <a href="<?= Url::toRoute(['/forum/board/update', 'id' => $board['id']]) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                    <?php if ($totalRecords >= 1): ?>
                        <a data-confirm="You must first delete the sub-board."><span class="glyphicon glyphicon-trash"></span></a>
                    <?php else: ?>
                        <a href="<?= Url::toRoute(['/forum/board/delete', 'id' => $board['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="board"><span class="glyphicon glyphicon-trash"></span></a>
                    <?php endif ?>
                </div>
            </h2>
        </div>

        <table class="table" style="margin-bottom:0">
            <tbody>
                <?php if ($board->columns > 1): ?>
                    <?php 
                        $rowsCount=ceil($totalRecords / $board->columns);
                        $counter = 0; 
                    ?>
                    <?php for ($i=0; $i < $rowsCount; $i++): ?>
                        <tr>
                            <?php for ($j=0; $j < $board->columns; $j++): ?>
                                <?php if ($counter < $totalRecords): ?>
                                    <?php $subBoard = $board->subBoards[$counter]; ?>
                                <td class="boardinfo" width="<?= (100.0 / $board->columns) ?>%">
                                    <div class="pull-left">
                                        <a href="<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>">
                                            <img src="<?= Yii::getAlias('@forum_icon') . '../forum.gif' ?>">
                                        </a>
                                    </div>
                                    <dl style="margin-bottom:0">
                                        <dt>
                                            <?= Html::a(Html::encode($subBoard['name']), ['/forum/board/view', 'id' => $subBoard['id']]) ?>
                                        </dt>
                                        <dd>
                                               <a href="<?= Url::toRoute(['/forum/board/update', 'id' => $subBoard['id']]) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href="<?= Url::toRoute(['/forum/board/delete', 'id' => $subBoard['id']]) ?>" data-confirm="Are you sure to delete it?" data-method="board"><span class="glyphicon glyphicon-trash"></span></a>
                                        </dd>
                                        <dd class="hidden-xs"></dd>
                                    </dl>
                                </td>
                                <?php endif ?>
                                <?php $counter += 1; ?>
                            <?php endfor ?>
                        </tr>
                    <?php endfor ?>
                <?php else: ?>
                    <?php foreach ($board->subBoards as $subBoard): ?>
                        <tr class="boardinfo">
                            <td style="vertical-align:middle;">
                                <div class="pull-left">
                                    <a href="<?= Url::toRoute(['/forum/board/view', 'id' => $subBoard['id']]) ?>">
                                        <img src="<?= Yii::getAlias('@forum_icon') . '../forum.gif' ?>">
                                    </a>
                                </div>
                                <dl style="margin-bottom:0">
                                    <dt><?= Html::a(Html::encode($subBoard['name']), ['/forum/board/view', 'id' => $subBoard['id']]) ?></dt>
                                    <dd>
                                           <a href="<?= Url::toRoute(['/forum/board/update', 'id' => $subBoard['id']]) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="<?= Url::toRoute(['/forum/board/delete', 'id' => $subBoard['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="board"><span class="glyphicon glyphicon-trash"></span></a>
                                    </dd>
                                </dl>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
        <?php if ($board->parent_id === Board::AS_CATEGORY): ?>
            <div class="add-board">
                <div class="row">
                    <?php Modal::begin([
                        'header' => '<h3>'.Yii::t('app','Add a board').'</h3>',
                        'toggleButton' => [
                            'label' => '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Add a board'),  
                            'class' => 'btn btn-lg btn-block btn-default'
                        ]
                    ]); ?>
                        <?php $form = ActiveForm::begin(); ?>

                            <?= Yii::t('app', 'Category : {name}', ['name' => $board->name]) ?>

                            <?= $form->field($newBoard, 'parent_id')->textInput(['readonly' => true, 'value' => $board->id, 'style' => 'display:none'])->label(false) ?>

                            <?= $form->field($newBoard, 'name')->textInput(['maxlength' => 32]) ?>

                            <?= $form->field($newBoard, 'description')->textInput(['maxlength' => 32]) ?>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    <?php Modal::end(); ?>
                </div>
            </div>   
        <?php endif ?>
    </div>
<?php endforeach; ?>

<div class="new-category tbox">
    <?php Modal::begin([
        'header' => '<h3>'.Yii::t('app','New Category').'</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-plus"></span>' . Yii::t('app', 'Create new category'), 
            'class' => 'btn btn-lg btn-block btn-default'
        ]
    ]); ?>
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($newBoard, 'parent_id')->textInput(['readonly' => true, 'value' => Board::AS_CATEGORY, 'style' => 'display:none'])->label(false) ?>

            <label class="control-label" for="board-name"><?= Yii::t('app', 'Category Name') ?></label>
            <?= $form->field($newBoard, 'name')->textInput(['maxlength' => 32])->label(false) ?>

            <?php $newBoard->columns = 1 ?>
            <?= $form->field($newBoard, 'columns', ['options'=>['id' => 'sub-column']])
                ->radioList(
                    [
                        1 => Yii::t('app', 'One'), 
                        2 => Yii::t('app', 'Two'), 
                        3 => Yii::t('app', 'Three'), 
                        4 => Yii::t('app', 'Four'), 
                    ]
                )
            ?>

            <div class="form-group">
                  <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>

    <?php Modal::begin([
        'header' => '<h3>'.Yii::t('app','Add a board').'</h3>',
        'toggleButton' => [
            'label' => '<span class="glyphicon glyphicon-plus"></span> '.Yii::t('app', 'Add a board'), 
            'class' => 'btn btn-lg btn-block btn-default'
        ]
    ]); ?>
        <?php $form = ActiveForm::begin(); ?>

            <blockquote><i class="glyphicon glyphicon-exclamation-sign"></i> <?= Yii::t('app', 'Note:This board does not belong to any category.') ?></blockquote>

            <?= $form->field($newBoard, 'parent_id')->textInput(['readonly' => true, 'value' => Board::AS_BOARD, 'style' => 'display:none'])->label(false) ?>

            <?= $form->field($newBoard, 'name')->textInput(['maxlength' => 32]) ?>

            <?= $form->field($newBoard, 'description')->textInput(['maxlength' => 32]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    <?php Modal::end(); ?>
</div>
