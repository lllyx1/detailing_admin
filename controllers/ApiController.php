<?php

namespace app\controllers;

use Yii;
use app\models\ResumeSearch;
use yii\rest\Controller;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\City;

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
     */
    public function actionSearch(int $minAge = null, int $maxAge = null)
    {
        $searchModel = new ResumeSearch();
        $params = Yii::$app->request->queryParams;

        // Загружаем параметры запроса
        $searchModel->load($params, '');

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
            $resumeData = $resume->attributes;

            // Добавляем информацию о городе
            $resumeData['city'] = null;
            if (!empty($resume->resumeCities)) {
                $resumeData['city'] = $resume->resumeCities[0]->city_id;
            }

            $resumeData['resumePhotos'] = []; // Инициализируем массив для фотографий
            foreach ($resume->resumePhotos as $photo) {
                $resumeData['resumePhotos'][] = [
                    'id' => $photo->id,
                    'file' => $photo->file,
                    'thumbUrl' => $photo->getThumbUploadUrl('file'), // Получаем URL миниатюры
                ];
            }
            $result[] = $resumeData; // Добавляем резюме с фотографиями в результат
        }
        return $result; // Возвращаем результат
    }

    public function actionCity()
    {
        $cities = City::find()->all();
        $result = [];
        foreach ($cities as $city) {
            $result[] = [
                'id' => $city->id,
                'city' => $city->city,
            ];
        }
        return $result;
    }
}