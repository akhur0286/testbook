<?php

namespace app\controllers;

use app\forms\AuthorForm;
use app\models\search\AuthorSearch;
use app\repositories\AuthorRepository;
use app\forms\BookForm;
use app\services\AuthorService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class AuthorController extends Controller
{
	private AuthorService $service;
	private AuthorRepository $repository;

	public function __construct(
		$id,
		$module,
		AuthorService $service,
		AuthorRepository $repository,
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
		$searchModel = new AuthorSearch();

		$dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
    }

	public function actionTop(?int $year = null)
	{
		if (!$year) {
			$year = date('Y');
		}

		$topAuthors = $this->repository->getTop($year);

		return $this->render('top', [
			'topAuthors' => $topAuthors,
			'year' => $year
		]);
	}

    public function actionCreate()
    {
        $form = new AuthorForm();

		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$this->service->create($form);
			return $this->redirect('/author/index');
        }

        return $this->render('create', [
            'formModel' => $form,
        ]);
    }

    public function actionEdit(int $id)
    {
		$model = $this->repository->get($id);

        $form = new AuthorForm($model);

		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			$this->service->edit($model, $form);
			return $this->redirect('/author/index');
        }

        return $this->render('edit', [
            'model' => $model,
            'formModel' => $form,
        ]);
    }

    public function actionView(int $id)
    {
		$model = $this->repository->get($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

	public function actionDelete(int $id)
	{
		$model = $this->repository->get($id);

		$this->repository->remove($model);

		return $this->redirect('/book/index');
	}
}
