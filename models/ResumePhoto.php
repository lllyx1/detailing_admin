<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_photo".
 *
 * @property int $id
 * @property string|null $file
 * @property int $resume_id
 * @property int|null $sort
 *
 * @property Resume $resume
 */
class ResumePhoto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_photo';
    }
    public function behaviors()
    {
        return [
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'file',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/uploads/resume_photos/{id}', // Путь для сохранения загруженных файлов
                'url' => '@web/uploads/resume_photos/{id}', // URL для доступа к загруженным файлам
                'thumbs' => [
                    'thumb' => ['width' => 400, 'quality' => 90],
                    'preview' => ['width' => 200, 'height' => 200],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'default', 'value' => null],
            [['sort'], 'default', 'value' => 0],
            [['resume_id'], 'required'],
            [['resume_id', 'sort'], 'integer'],
            ['file', 'image', 'skipOnEmpty' => true, 'maxFiles' => 4, 'extensions' => 'png, jpg, jpeg', 'on' => ['insert', 'update']], // Ограничение на загрузку файлов
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::class, 'targetAttribute' => ['resume_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'resume_id' => 'Resume ID',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[Resume]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::class, ['id' => 'resume_id']);
    }

}
