<?php

/**
 * @copyright Copyright (c) 2015 Shiyang
 * @author Shiyang <dr@shiyang.me>
 * @link http://shiyang.me
 * @license http://opensource.org/licenses/MIT
 */

namespace shiyang\setting\components;

use yii\base\Component;
use yii\caching\Cache;
use Yii;

/**
 * @author Aris Karageorgos <aris@phe.me>
 */
class Setting extends Component
{
    /**
     * @var Cache|string the cache object or the application component ID of the cache object.
     * Settings will be cached through this cache object, if it is available.
     *
     * After the Settings object is created, if you want to change this property,
     * you should only assign it with a cache object.
     * Set this property to null if you do not want to cache the settings.
     */
    public $cache = 'cache';

    /**
     * To be used by the cache component.
     *
     * @var string cache key
     */
    public $cacheKey = 'shiyang/settings';

    /**
     * Holds a cached copy of the data for the current request
     *
     * @var mixed
     */
    private $_data = null;

    /**
     * Initialize the component
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (is_string($this->cache)) {
            $this->cache = Yii::$app->get($this->cache, false);
        }
    }

    /**
     * Get's the value for the given code.
     * You can use dot notation to separate the section from the code:
     * $value = $settings->get('code');
     * are equivalent
     *
     * @param string $code
     */
    public function get($code)
    {
        if ($this->_data === null) {
            if ($this->cache instanceof Cache) {
                $this->cache->cachePath = Yii::getAlias('@app').'\..\common\cache';
                $data = $this->cache->get($this->cacheKey);
                if ($data === false) {
                    $data = $this->getData();
                    $this->cache->set($this->cacheKey, $data);
                }
            } else {
                $data = $this->getData();
            }
            $this->_data = $data;
        }
        return $this->_data[$code];
    }

    /**
     * Clears the settings cache on demand.
     * If you haven't configured cache this does nothing.
     *
     * @return boolean True if the cache key was deleted and false otherwise
     */
    public function clearCache()
    {
        $this->_data = null;
        if ($this->cache instanceof Cache) {
            $this->cache->cachePath = Yii::getAlias('@app').'\..\common\cache';
            return $this->cache->delete($this->cacheKey);
        }
        return true;
    }

    /**
     * Returns the data array
     *
     * @return array
     */
    public function getData()
    {
        $settings = Yii::$app->db->createCommand("SELECT * FROM {{%setting}}")->queryAll();
        return \yii\helpers\ArrayHelper::map($settings, 'code', 'value');
    }
}
