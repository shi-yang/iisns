yii2-masonry
============
Masonry Yii2 Extension width infinitescroll

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist shiyang/yii2-masonry "*"
```

or add

```
"shiyang/yii2-masonry": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :


Controller action:

~~~
function actionIndex()
{
    $query = Article::find()->where(['status' => 1]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count()]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

    return $this->render('index', [
         'models' => $models,
         'pages' => $pages,
    ]);
}
~~~

View:

~~~
\shiyang\masonry\Masonry::begin([
        'options' => [
          'id' => 'models'
        ],
        'pagination' => $pages
    ]);
	foreach ($models as $model) {
	    // display $model here
	}
\shiyang\masonry\Masonry::end();
~~~
