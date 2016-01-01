<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\widgets\login;

use common\models\LoginForm;

/**
 * LoginWidget is a widget that provides user login functionality.
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class Login extends \yii\base\Widget
{
    /**
     * @var string the widget title. Defaults to 'Login'.
     */
    public $title = 'Login';

    /**
     * @var boolean whether the widget is visible. Defaults to true.
     */
    public $visible = true;

    public function run()
    {
        if($this->visible) {
            $user = new LoginForm;
            if ($user->load(\Yii::$app->request->post()) && $user->login()) {
                return \Yii::$app->getResponse()->refresh();
            } else {
                return $this->render('loginWidget', [
                    'user' => $user,
                    'title' => $this->title,
                ]);
            }
        }
    }
}
