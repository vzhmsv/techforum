<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Topic;
use app\models\Message;
use yii\data\ActiveDataProvider;

class ForumController extends Controller
{
    // Список тем
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Topic::find()->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Создание темы
    public function actionCreateTopic()
    {
        $model = new Topic();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id; // ID текущего пользователя
            $model->created_at = date('Y-m-d H:i:s'); // Текущее время
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Тема успешно создана!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create-topic', [
            'model' => $model,
        ]);
    }

    // Просмотр темы и сообщений
    public function actionView($id)
    {
        $topic = Topic::findOne($id);
        if (!$topic) {
            throw new \yii\web\NotFoundHttpException('Тема не найдена.');
        }

        $messages = $topic->messages;

        $messageModel = new Message();

        if ($messageModel->load(Yii::$app->request->post())) {
            $messageModel->topic_id = $id;
            $messageModel->user_id = Yii::$app->user->id;
            $messageModel->created_at = date('Y-m-d H:i:s');
            if ($messageModel->save()) {
                Yii::$app->session->setFlash('success', 'Сообщение успешно добавлено!');
                return $this->refresh();
            }
        }

        return $this->render('view', [
            'topic' => $topic,
            'messages' => $messages,
            'messageModel' => $messageModel,
        ]);
    }
}