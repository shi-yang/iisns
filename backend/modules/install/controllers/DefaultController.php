<?php

namespace backend\modules\install\controllers;

use PDO;
use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\db\Connection;
use backend\modules\install\models\AdminForm;
use backend\modules\install\models\DatabaseForm;
use backend\modules\install\models\MailForm;

class DefaultController extends Controller
{
	public $layout = 'main';
	public $result = true;
    protected $steps;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
            ],
        ];
    }

    public function actionIndex($step = 0)
    {
        $this->layout = 'main';
        $database = new DatabaseForm();
        $admin = new AdminForm();

        if ($admin->load(Yii::$app->request->post()) && $admin->validate()) {
            $this->nextStep($step);
        }

        if ($database->load(Yii::$app->request->post()) && $database->validate()) {
            $database->set();
            $dsn = $database->getDsn();
            try {
                $connection = new Connection([
                    'dsn' => $dsn,
                    'username' => $database->user,
                    'password' => $database->password,
                ]);
                $connection->initConnection();
                $database->createDb($connection);
                $this->nextStep($step);
            } catch (Exception $e) {
                $database->addError(
                    '',
                    '<strong>' . Yii::t('install',
                        'When you connect to the database with the specified parameters errors occurred.'
                    ) . '</strong><br />' . $dsn . '<br />' . $e->getMessage()
                );
                throw new Exception($e->getMessage(), $e->errorInfo, (int) $e->getCode(), $e);
            }
        }

        return $this->render('index', [
            'step' => $step,
            'database' => $database,
            'admin' => $admin,
        ]);
    }

    protected function nextStep($step)
    {
        $database = new DatabaseForm();
        $admin = new AdminForm();
        $step++;
        return $this->redirect(['index', 'step' => $step], [
            'step' => $step,
            'database' => $database,
            'admin' => $admin,
        ]);
    }
    /**
     * Site "Home" page.
     */
  /*  public function actionIndex()
    {
        $this->layout = 'main';
        $model = new DatabaseForm();
        $admin = new AdminForm();
        $mail = new MailForm();
        $model->setAttributes(Yii::$app->session->get('db'));
        $admin->setAttributes(Yii::$app->session->get('admin'));
        $mail->setAttributes(Yii::$app->session->get('mail'));
        if ($mail->load(Yii::$app->request->post()) && $mail->validate()) {
            if ($this->steps['active'] == 5) {
                $this->steps[$this->steps['active']] = [
                    'valid' => true
                ];
                $this->steps['active'] = 6;
            }
            $this->saveStep();
            $mail->set();
        }
        if ($admin->load(Yii::$app->request->post()) && $admin->validate()) {
            if ($this->steps['active'] == 5) {
                $this->steps[$this->steps['active']] = [
                    'valid' => true
                ];
                $this->steps['active'] = 6;
            }
            $this->saveStep();
            $admin->set();
        }
        if ($model->load(Yii::$app->request->post(), 'DatabaseChoose') && $model->validate(['type'])) {
            if ($this->steps['active'] == 3) {
                $this->steps[$this->steps['active']] = [
                    'valid' => true
                ];
                $this->steps['active'] = 4;
            }
            $this->saveStep();
            $model->set();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->set();
            $dsn = $model->getDsn();
            try {
                $connection = new Connection([
                    'dsn' => $dsn,
                    'username' => $model->user,
                    'password' => $model->password,
                ]);
                $connection->open();
                $model->createDb($connection);
                if ($this->steps['active'] == 4) {
                    $this->steps[$this->steps['active']] = [
                        'valid' => true
                    ];
                    $this->steps['active'] = 5;
                }
                $this->saveStep();
            } catch (Exception $e) {
                $model->addError(
                    '',
                    '<strong>' . Yii::t(
                        'install',
                        'When you connect to the database with the specified parameters errors occurred.'
                    ) . '</strong><br />' . $dsn . '<br />' . $e->getMessage()
                );
            }
        }
        if (Yii::$app->request->isPost && Yii::$app->request->post('step')) {
            $step = (int)Yii::$app->request->post('step') - 1;
            $currentStep = $this->steps['active'];
            $previousStep = $step - 1;
            if ($currentStep > $step && isset($this->steps[$currentStep]) && !$this->steps[$currentStep]['valid']) {
                unset ($this->steps[$currentStep]);
            }
            if (isset($this->steps[$previousStep]) && $this->steps[$previousStep]['valid']) {
                if (isset($this->steps[$step])) {
                    $this->steps[$step]['icon'] = 'arrow-right';
                } else {
                    $this->steps[$step] = [
                        'icon' => 'arrow-right',
                        'valid' => false
                    ];
                }
                if (isset($this->steps[$currentStep]) && $currentStep != $step) {
                    $this->steps[$currentStep]['icon'] = 'check';
                }
                $this->steps['active'] = $step;
                $this->saveStep();
            } else if ($step == 0) {
                $this->refreshStep();
            }
        }
        return $this->render('index', [
            'steps' => $this->steps,
            'model' => $model,
            'admin' => $admin,
            'mail' => $mail
        ]);
    }*/

    // public function init()
    // {
    //     parent::init();
    //     $this->steps = Yii::$app->session->get('steps') ? Yii::$app->session->get('steps') : $this->refreshStep();
    // }

    // protected function saveStep()
    // {
    //     Yii::$app->session->set('steps', $this->steps);
    // }

    // protected function refreshStep()
    // {
    //     $this->steps = [0 => ['icon' => 'arrow-right', 'valid' => true], 'active' => 0];
    //     $this->saveStep();
    //     Yii::$app->session->remove('db');
    //     Yii::$app->session->remove('admin');
    //     return $this->steps;
    // }
}
