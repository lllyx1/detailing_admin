<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Resume */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <div>
                        <h2>Photos</h2>
                        <?php foreach ($model->resumePhotos as $photo): ?>
                            <img src="<?=$photo->getThumbUploadUrl('file') ?>" alt="Photo" style="width: 100px; height: auto;"/>
                        <?php endforeach; ?>
                    </div>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'title',
                            'body:ntext',
                            'age',
                            'name',
                            'phone',
                            [
                                'label' => 'City', // Название поля
                                'value' => function($model) {
                                    // Получаем первый город из связанных записей
                                    $cities = $model->cities; // Получаем связанные города
                                    return !empty($cities) ? implode(', ', array_column($cities, 'city')) : 'Не указан'; // Если есть города, выводим их, иначе 'Не указан'
                                },
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>