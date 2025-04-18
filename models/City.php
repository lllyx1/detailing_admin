<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string|null $city
 *
 * @property ResumeCity[] $resumeCities
 * @property Resume[] $resumes
 */
class City extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city'], 'default', 'value' => null],
            [['city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
        ];
    }

    /**
     * Gets query for [[ResumeCities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResumeCities()
    {
        return $this->hasMany(ResumeCity::class, ['city_id' => 'id']);
    }

    /**
     * Gets query for [[Resumes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResumes()
    {
        return $this->hasMany(Resume::class, ['id' => 'resume_id'])->viaTable('resume_city', ['city_id' => 'id']);
    }

}
