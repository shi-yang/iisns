<?php

namespace shiyang\masonry;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\base\Widget;
use shiyang\infinitescroll\InfiniteScrollPager;

 /**
 * @link http://www.shiyang.me
 * @author Shiyang <dr@shiyang.me>
 */

class Masonry extends Widget
{
    /**
    * @var array the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = [];

    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make InfiniteScrollPager work.
     */
    public $pagination;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        echo Html::beginTag('div', $this->options); //opens the container
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->infiniteScrollScript();
        echo Html::endTag('div'); //closes the container, opened on init
        $this->registerPlugin();
    }

    public function infiniteScrollScript()
    {
        $widgetId = '#' . $this->options['id'];
        echo InfiniteScrollPager::widget([
            'pagination' => $this->pagination,
            'widgetId' => $widgetId,
            'contentLoadedCallback' => "function( newElements ) {
    var newElems = $( newElements );
    $('$widgetId').imagesLoaded( function() {
        $('$widgetId').masonry('appended', newElems );
    });
  }"
        ]);
    }

    /**
    * Registers the widget and the related events
    */
    protected function registerPlugin()
    {
        $id = $this->options['id'];

        //get the displayed view and register the needed assets
        $view = $this->getView();
        MasonryAsset::register($view);
        ImagesLoadedAsset::register($view);

        $js = [];
        $js[] = "var mscontainer$id = $('#$id');";
        $js[] = "mscontainer$id.imagesLoaded(function(){mscontainer$id.masonry()});";
        
        $view->registerJs(implode("\n", $js),View::POS_END);
    }

}
