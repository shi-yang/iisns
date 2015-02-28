Yii2-login-widget
===============
This extension provides a login portlet  that provides user login functionality.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist shiyang/yii2-login-widget "*"
```

or add

```
"shiyang/yii2-login-widget": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \shiyang\login\Login::widget(); ?>
```