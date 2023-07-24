<?php

namespace app\controllers;

use app\models\search\BookSearch;
use app\repositories\BookRepository;
use app\forms\BookForm;
use app\services\BookService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class BookController extends Controller
{
	private BookService $service;
	private BookRepository $repository;

	public function __construct(
		$id,
		$module,
		BookService $service,
		BookRepository $repository,
		$config = []
	) {
		parent::__construct($id, $module, $config);

		$this->service = $service;
		$this->repository = $repository;
	}
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['edit', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['edit', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['edit', 'create'],
                ],
            ],
        ];
    }

	/**
     * @return string
     */
    public function actionIndex()
    {
		$searchModel = new BookSearch();

		$dataProvider = $searchModel->search(Yii::$app->request->get());

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
    }

    public function actionCreate()
    {
        $form = new BookForm();

		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$this->service->create($form);
			return $this->redirect('/book/index');
        }

        return $this->render('create', [
            'formModel' => $form,
        ]);
    }

    public function actionEdit(int $id)
    {
		$model = $this->repository->get($id);

        $form = new BookForm($model);

		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$this->service->edit($model, $form);
			return $this->redirect('/book/index');
        }

        return $this->render('edit', [
            'model' => $model,
            'formModel' => $form,
        ]);
    }

	public function actionDelete(int $id)
	{
		$model = $this->repository->get($id);

		$this->repository->remove($model);

		return $this->redirect('/book/index');
	}

	public function actionView(int $id)
	{
		$model = $this->repository->get($id);

		return $this->render('view', [
			'model' => $model,
		]);
	}
}
