<?php

namespace backend\controllers;

use common\components\BaseController;

class ExploreController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPhotos()
    {
        return $this->render('index');
    }

    public function actionPosts()
    {
        return $this->render('index');
    }
}
