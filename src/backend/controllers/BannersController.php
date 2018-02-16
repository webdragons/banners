<?php

namespace bulldozer\banners\backend\controllers;

use bulldozer\App;
use bulldozer\banners\backend\services\BannerService;
use bulldozer\banners\common\ar\Banner;
use bulldozer\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Class BannersController
 * @package bulldozer\banners\backend\controllers
 */
class BannersController extends Controller
{
    /**
     * @var BannerService
     */
    private $bannerService;

    /**
     * BannersController constructor.
     * @param string $id
     * @param $module
     * @param BannerService $bannerService
     * @param array $config
     */
    public function __construct(string $id, $module, BannerService $bannerService, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->bannerService = $bannerService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['banners_manage'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Banner models.
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $dataProvider = App::createObject([
            'class' => ActiveDataProvider::class,
            'query' => Banner::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $model = $this->bannerService->getForm();

        if ($model->load(App::$app->request->post()) && $model->validate()) {
            $banner = $this->bannerService->save($model);
            App::$app->getSession()->setFlash('success', Yii::t('banners', 'Banner successful created'));

            if (!App::$app->request->post('here-btn')) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['update', 'id' => $banner->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate(int $id)
    {
        $banner = $this->findModel($id);

        $model = $this->bannerService->getForm($banner);
        $model->setScenario('update');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->bannerService->save($model, $banner);
            App::$app->getSession()->setFlash('success', Yii::t('banners', 'Banner successful updated'));

            if (!App::$app->request->post('here-btn')) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['update', 'id' => $banner->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'banner' => $banner,
        ]);
    }

    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->getSession()->setFlash('success', Yii::t('banners', 'Banner successful deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}