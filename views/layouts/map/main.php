<?php

/**
 * Created by PhpStorm.
 * User: Duc
 * Date: 7/3/2021
 * Time: 9:00 PM
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$this->title = 'Quản lý nông hộ';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>favicon.ico" type="image/x-icon">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (Yii::$app->controller->id == 'map') : ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVofCmO1bDdRaP5bMhwrZ-pEAi9AEhAgQ&libraries=places&regions=country:vn"></script>
    <?php endif ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="page" class="page-header-dark sidebar-o">
        <div id="page-overlay"></div>
       
        
        <!-- <div class="filterDiv">
            <div class="m-3">
                <button type="button" class="btn btn-sm btn-alt-primary" onclick="filterDonvikinhte(1)">Doanh nghiệp</button>
                <button type="button" class="btn btn-sm btn-alt-primary" onclick="filterDonvikinhte(2)">Hộ kinh doanh</button>
                <?php if (isset($this->blocks['block-filter'])) : ?>
                    <?= $this->blocks['block-filter'] ?>
                <?php endif; ?>
            </div>
        </div> -->

        <main id="main-container">
            <div class="content-full">
                <?= $content ?>
            </div>
        </main>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>