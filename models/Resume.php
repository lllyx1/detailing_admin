<?php

namespace app\models;

use Yii;
use mohorev\file\UploadBehavior;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\web\UploadedFile;
/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $body
 * @property string|null $age
 * @property string|null $name
 * @property string|null $phone
 *
 * @property City[] $cities
 * @property ResumeCity[] $resumeCities
 * @property ResumePhoto[] $resumePhotos
 */
class Resume extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]|null
     */
    public $photos; // Для загрузки фотографий
    public $city_id; // Для хранения выбранного города

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body', 'age', 'name', 'phone'], 'default', 'value' => null],
            [['body'], 'string'],
            [['age', 'city_id'], 'safe'],
            [['title', 'name', 'phone'], 'string', 'max' => 255],
            ['photos', 'image', 'skipOnEmpty' => true, 'maxFiles' => 4, 'extensions' => 'png, jpg, jpeg', 'on' => ['insert', 'update']], // Ограничение на загрузку файлов
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'body' => 'Описание',
            'age' => 'Дата рождения',
            'name' => 'Имя',
            'phone' => 'Телефон',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['id' => 'city_id'])->viaTable('resume_city', ['resume_id' => 'id']);
    }

    public static function getCityList()
    {
        return City::find()->select(['city', 'id'])->indexBy('id')->column();
    }

    /**
     * Gets query for [[ResumeCities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResumeCities()
    {
        return $this->hasMany(ResumeCity::class, ['resume_id' => 'id']);
    }

    /**
     * Gets query for [[ResumePhotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResumePhotos()
    {
        return $this->hasMany(ResumePhoto::class, ['resume_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */


    /**
     * Сохранение загруженных фотографий в таблице resume_photo
     * @throws Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->city_id) {
            $resumeCity = new ResumeCity();
            $resumeCity->resume_id = $this->id;
            $resumeCity->city_id = $this->city_id;
            $resumeCity->save();
        }
        if ($this->photos) {
            foreach ($this->photos as $sort => $photo) {
                $resumePhoto = new ResumePhoto();
                $resumePhoto->setScenario('insert');
                $resumePhoto->file = $photo; // Сохраняем имя файла
                $resumePhoto->resume_id = $this->id; // Устанавливаем ID резюме
                $resumePhoto->sort = $sort;
                $resumePhoto->save();
            }
        }
    }

}
