<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use shiyang\setting\models\Setting;
use shiyang\setting\Module;

$this->title = Module::t('setting', 'Setting');
$this->params['breadcrumbs'][] = $this->title;

$items = [];
foreach ($settingParent as $parent) {
    $item['label'] = Module::t('setting', $parent->code);

    $str = '';
    $children = Setting::find()->where(['parent_id' => $parent->id])->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])->all();
    foreach ($children as $child) {
        $str .= '<div class="form-group field-blogcatalog-parent_id"><label class="col-lg-2 control-label" for="blogcatalog-parent_id">' . Module::t('setting', $child->code) . '</label><div class="col-lg-3">';

        if ($child->type == 'text')
            $str .= Html::textInput("Setting[$child->code]", $child->value, ["class" => "form-control"]);
        elseif ($child->type == 'password')
            $str .= Html::passwordInput("Setting[$child->code]", $child->value, ["class" => "form-control"]);
        elseif ($child->type == 'select') {
            $options = [];
            $arrayOptions = explode(',', $child->store_range);
            foreach ($arrayOptions as $option)
                $options[$option] = Module::t('setting', $option);

            $str .= Html::dropDownList("Setting[$child->code]", $child->value, $options, ["class" => "form-control"]);
        }

        $str .= '</div></div>';
    }
    $item['content'] = $str;

    array_push($items, $item);
}

?>

<style>
.tab-pane {padding-top: 20px;}
</style>

<div class="setting-form">
    <?php $form = ActiveForm::begin([
        'id' => 'setting-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}{hint}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => $items,
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'headerOptions' => ['class' => 'my-class'],
        'clientOptions' => ['collapsible' => false],
    ]);
    ?>

    <div class="form-group">
        <label class="col-lg-2 control-label" for="">&nbsp;</label>
        <?= Html::submitButton(Module::t('setting', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
