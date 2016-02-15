Automatically compile and merge files js + css
==============================================
This solution enables you to dynamically combine js and css files to optimize the html page.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist iisns/yii2-assets-compress "*"
```

or add

```
"iisns/yii2-assets-compress": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
//App config
[
    'bootstrap'    => ['assetsCompress'],
    'components'    => [
    //....
        'assetsAutoCompress' =>
        [
            'class' => '\iisns\assets\AssetsCompressComponent',
            'enabled'           => true,
            'jsCompress'        => true,
            'cssFileCompile'    => true,
            'jsFileCompile'     => true,
        ],
    //....
    ]
]

```
