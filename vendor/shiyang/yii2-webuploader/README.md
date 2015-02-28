Umeditor Widget for Yii2
========================

Renders a [Umeditor WYSIWYG text editor plugin](http://ueditor.baidu.com/) widget.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "umeditor/yii2-umeditor-widget" "*"
```
or add

```json
"umeditor/yii2-umeditor-widget" : "*"
```

to the require section of your application's `composer.json` file.

Skins & Plugins
---------------


Usage
-----

```

use umeditor\umeditor\Umeditor;


<?= $form->field($model, 'content')->widget(Umeditor::className(), [
    'options' => [
        'style' => 'width:100%;height:120px'
    ]
]) ?>
```


Further Information
-------------------
Please, check the [Umeditor plugin site](http://ueditor.baidu.com) documentation for further information about its configuration options.