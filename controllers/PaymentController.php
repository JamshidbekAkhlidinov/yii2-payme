<?php

namespace app\controllers;

use app\paymeuz\PaymeService;
use yii\web\Controller;

class PaymentController extends Controller
{

    public function init()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->enableCsrfValidation = false;
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $payMeService = new PaymeService();
        return $payMeService->getAnswer();
    }
}