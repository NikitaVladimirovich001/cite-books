<?php

namespace app\modules\admin\controllers;

use app\models\Books;
use app\models\BooksSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Books models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Books();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            // Получаем экземпляры загруженных файлов
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                // Если изображение было загружено, сохраняем его
                if ($model->image) {
                    $model->uploadImage();
                }
                // Если файл был загружен, сохраняем его
                if ($model->file) {
                    $model->upload();
                }

                // Сохраняем книгу
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Получаем экземпляры загруженных файлов
        $model->image = UploadedFile::getInstance($model, 'image');
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($this->request->isPost) {
            // Загрузка данных из формы в модель
            if ($model->load($this->request->post())) {
                // Проверка валидности модели
                if ($model->validate()) {
                    // Если изображение было загружено, сохраняем его
                    if ($model->image) {
                        $model->uploadImage();
                    }
                    // Если файл был загружен, сохраняем его
                    if ($model->file) {
                        $model->upload();
                    }

                    // Сохраняем модель книги
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        // Отображение формы обновления существующей книги
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
