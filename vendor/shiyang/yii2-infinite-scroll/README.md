yii2-infinite-scroll
================

Yii2 extension for infinite-scroll jQuery plugin, providing scrolling functionality for widgets such as `ListView`.
It renders a hyperlink that leads to subsequent page of a target and registers 
infinite-scroll jQuery plugin which uses javascript to fetch and append content for subsequent pages,
gracefully degrading to complete page reload when javascript is disabled.

Several behaviours allowing to customize scroll behavior are provided out of the box,
including twitter-style manual trigger, local scroll in overflow div, masonry integration and others.

## Resources
 * Yii2 [extension page](http://www.yiiframework.com/extension/yii2-infinite-scroll)
 * Infinite-Scroll jQuery plugin [documentation](https://github.com/paulirish/infinite-scroll)

## Installation

### Composer

Add extension to your `composer.json` and update your dependencies as usual, e.g. by running `composer update`
```js
{
    "require": {
        "shiyang/yii2-infinite-scroll": "*"
    }
}
```

##Widget Configuration

In addition to most of the properties that `LinkPager` provides, this widget also allows you to configure:
 
 * $widgetId *string* owner widget id, required
 * $itemsCssClass *string* CSS class of a tag that encapsulates items, required
 * $pluginOptions *array* infinite-scroll jQuery plugin options. For more information refer to infinite-scroll [documentation](https://github.com/paulirish/infinite-scroll)
 * $contentLoadedCallback *string|JsExpression* javascript callback to be executed on loading the content via ajax call
  
##Sample Usage

Plugin works by appending fetched items to the end of parent container, so it is required
to configure `layout` property of parent `ListView` widget, wrapping `{items}` into e.g. `div` container with some class (to be used as a selector).
It is possible to configure all selectors that widget initializes plugin with to fit your project requirements, but it general it is enough to
set `itemCssClass` (class of that wrapping tag that we created) and `widgetId` (which would ensure multiple plugins on the same page would not conflict).

So the minimal required configuration would look like this:
```php
use shiyang\infinitescroll\InfiniteScrollPager;

echo ListView::widget([
    ...
    'id' => 'my-listview-id',
    'layout' => "{summary}\n<div class=\"items\">{items}</div>\n{pager}",
    'pager' => [
        'class' => InfiniteScrollPager::className(),
        'widgetId' => 'my-listview-id',
        'itemsCssClass' => 'items',
    ],
]);
```

An example illustrating how to customize some widget / plugin options: 
```php
use shiyang\infinitescroll\InfiniteScrollPager;

echo ListView::widget([
    ...
    'id' => 'my-listview-id',
    'layout' => "{summary}\n<div class=\"items\">{items}</div>\n{pager}",
    'pager' => [
        'class' => InfiniteScrollPager::className(),
        'widgetId' => 'my-listview-id',
        'itemsCssClass' => 'items',
        'contentLoadedCallback' => 'afterAjaxListViewUpdate',
        'nextPageLabel' => 'Load more items',
        'linkOptions' => [
            'class' => 'btn btn-lg btn-block',
        ],
        'pluginOptions' => [
            'loading' => [
                'msgText' => "<em>Loading next set of items...</em>",
                'finishedMsg' => "<em>No more items to load</em>",
            ],
            'behavior' => InfiniteScrollPager::BEHAVIOR_TWITTER,
        ],
    ],
]);
```

Or

Controller action:
```
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
```
 
  View:
 
```
use shiyang\infinitescroll\InfiniteScrollPager;

<div id="content">
<?php 
foreach ($models as $model) {
    // display $model here
}
?>
</div>
 
// display pagination
echo InfiniteScrollPager::widget([
   	'pagination' => $pages,
   	'widgetId' => '#content',
]);
```

##License

Extension is released under MIT license, same as underlying jQuery plugin.
