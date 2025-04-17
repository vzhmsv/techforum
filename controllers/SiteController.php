<?php

namespace app\controllers;

use app\models\News;
use app\models\Obzor;
use app\models\Proposal;
use app\models\Request;
use app\models\SignupForm;
use app\models\Tovar;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $proposal = Proposal::find()->all();
        $obzor = Obzor::find()->all();

        return $this->render('index',['proposal'=>$proposal,'obzor'=>$obzor]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionProposal()
    {
        $model = new Proposal();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Отправлено');
            Yii::$app->user->identity->afterPostCreate();
            if (Yii::$app->request->isPost) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->upload()) {
                    $model->save();
                    return $this->refresh();
                }
            }
        }
        return $this->render('proposal', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $proposal = \app\models\Proposal::findOne($id);
        if (!$proposal) {
            throw new \yii\web\NotFoundHttpException('Новость не найдена.');
        }

        return $this->render('view', [
            'proposal' => $proposal,
        ]);
    }

    public function actionObzor()
    {
        $model = new Obzor();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isPost) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->upload()) {
                    $model->save();

                    // Обновляем ранг пользователя после создания обзора
                    $user = Yii::$app->user->identity;
                    $user->updateRankByObzors();

                    Yii::$app->session->setFlash('success', 'Обзор успешно добавлен!');

                    // Проверяем и выдаем достижения
                    $obzorCount = $user->getObzors()->count();
                    if ($obzorCount == 1) {
                        Yii::$app->session->setFlash('success', 'Вы получили статус "Активный участник"!');
                    } elseif ($obzorCount == 3) {
                        Yii::$app->session->setFlash('success', 'Поздравляем! Вы получили статус "Эксперт"!');
                    }

                    return $this->refresh();
                }
            }
        }
        return $this->render('obzor', [
            'model' => $model,
        ]);
    }

    public function actionObzorview($id)
    {
        $obzor = \app\models\Obzor::findOne($id);
        if (!$obzor) {
            throw new \yii\web\NotFoundHttpException('Обзор не найден.');
        }

        return $this->render('obzorview', [
            'obzor' => $obzor,
        ]);
    }
    public function actionProfile($id = null)
    {
        // Если ID не указан, показываем профиль текущего пользователя
        $user = $id ? User::findOne($id) : Yii::$app->user->identity;

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }
        $obzorCount = $user->getObzors()->count();
        return $this->render('profile', [
            'user' => $user,
        ]);
    }
}