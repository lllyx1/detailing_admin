<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;



$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<style>
    .flex-col.bg-\[\#222222\]  {
        background-image: url(<?= Yii::getAlias('@web/img/eng_word_row_r.svg') ?>);
        background-position: right;
        background-repeat: no-repeat;
        background-size: 150px;
        background-position-x: calc(100% - 20px);
    }
</style>
<?php $this->beginBody() ?>

        <?= $content ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<footer id="footer" class="mt-auto py-3 bg-light" style="margin-top: 40px !important;">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Detailing city <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end">создано by <a href="https://lllyx.ru">lllyx</a></div>
        </div>
    </div>
</footer>