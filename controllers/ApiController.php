<?php

namespace app\controllers;

use Yii;
use app\models\ResumeSearch;
use yii\rest\Controller;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * Search resumes with optional age range.
     *
     * @param int|null $minAge Minimum age
     * @param int|null $maxAge Maximum age
     * @return array
     */
    public function actionSearch(int $minAge = null, int $maxAge = null): array
    {
        $searchModel = new ResumeSearch();
        $params = Yii::$app->request->queryParams;

        // Загружаем параметры запроса
        $searchModel->load($params);

        // Создаем DataProvider
        $dataProvider = $searchModel->search($params);

        // Фильтруем по возрасту, если указаны минимальный и максимальный возраст
        $currentYear = date('Y');
        if ($minAge !== null) {
            $minDate = date('Y-m-d', strtotime(($currentYear - $minAge) . '-01-01'));
            $dataProvider->query->andFilterWhere(['<=', 'age', $minDate]);
        }
        if ($maxAge !== null) {
            $maxDate = date('Y-m-d', strtotime(($currentYear - $maxAge) . '-12-31'));
            $dataProvider->query->andFilterWhere(['>=', 'age', $maxDate]);
        }
        $resumes = $dataProvider->getModels();

        // Формируем ответ с использованием ArrayHelper
        $result = [];
        foreach ($resumes as $resume) {
            $resumeData = $resume->attributes; // Получаем атрибуты резюме
            $resumeData['resumePhotos'] = ArrayHelper::toArray($resume->resumePhotos, [
                'app\models\ResumePhoto' => [
                    'id',
                    'file',
                    'resume_id',
                ],
            ]);
            $result[] = $resumeData; // Добавляем резюме с фотографиями в результат
        }

        return $result; // Возвращаем результат
    }
}