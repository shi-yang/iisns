<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace common\traits;

use Yii;

/**
 * Flash Trait
 * Simplifies flash messages adding.
 * Prepares messages for \common\widgets\Alert widget.
 * Former FlashBehavior.
 *
 * @author Shiyang <dr@shiyang.me>
 */
trait FlashTrait
{
    /**
     * Adds flash message of 'danger' type.
     * @param string $message the flash messages are displayed.
     */
    public function danger($message)
    {
        Yii::$app->session->addFlash('danger', $message);
    }

    /**
     * Alias for danger().
     * @param string $message the flash messages are displayed.
     */
    public function error($message)
    {
        Yii::$app->session->addFlash('danger', $message);
    }

    /**
     * Adds flash message of 'info' type.
     * @param string $message the flash messages are displayed.
     */
    public function info($message)
    {
        Yii::$app->session->addFlash('info', $message);
    }
    /**
     * Adds flash message of 'success' type.
     * @param string $message the flash messages are displayed.
     */
    public function success($message)
    {
        Yii::$app->session->addFlash('success', $message);
    }

    /**
     * Adds flash message of 'warning' type.
     * @param string $message the flash messages are displayed.
     */
    public function warning($message)
    {
        Yii::$app->session->addFlash('warning', $message);
    }
}
