<?php

namespace app\controllers;

use app\models\Medicine;
use bizley\jwt\JwtHttpBearerAuth;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class MedicineController extends ActiveController
{
    public $modelClass = Medicine::class;

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['create']);

        return $actions;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->modelClass::find()->where(['user_id' => Yii::$app->user->id]),
        ]);
    }

    public function actionCreate()
    {
        $model = new Medicine();
        $model->load(Yii::$app->request->bodyParams, '');
        $model->user_id = Yii::$app->user->id;

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201);
        }

        return $model;
    }
}
