yii2-umeditor
=============
[UMeditor](http://ueditor.baidu.com/website/umeditor.html) is a simple version ueditor.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist shiyang/yii2-umeditor "*"
```

or add

```
"shiyang/yii2-umeditor": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

controller:  

```php
public function actions()
{
    return [
        'upload' => [
            'class' => 'shiyang\umeditor\UMeditorAction',
        ]
    ];
}
```

view:

```php
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
    'clientOptions' => [
        'initialFrameHeight' => 100,
        'toolbar' => [
            'source | undo redo | bold |',
            'link unlink | emotion image video |',
            'justifyleft justifycenter justifyright justifyjustify |',
            'insertorderedlist insertunorderedlist |' ,
            'horizontal preview fullscreen',
        ],
    ]
])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
```

Further Information
-------------------
Please, check the [Umeditor plugin site](http://ueditor.baidu.com) or [config](https://github.com/shiyangDR/yii2-umeditor/blob/master/umeditor/umeditor.config.js) documentation for further information about its configuration options.

Demo
-------------------
See [umeditor](http://ueditor.baidu.com/website/umeditor.html)
