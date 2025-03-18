<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\ArrayHelper;

$bundle = AppAsset::register($this);

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
    <?php $this->beginBody() ?>


    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed  remember-theme">
        <!-- Side Overlay-->
        <aside id="side-overlay">
            <!-- Side Header -->
            <div class="bg-image" style="background-image: url('/media/various/bg_side_overlay_header.jpg');">
                <div class="bg-primary-op">
                    <div class="content-header">
                        <!-- User Avatar -->
                        <a class="img-link me-1" href="javascript:void(0)">
                            <?= \cebe\gravatar\Gravatar::widget([
                                'email' => ArrayHelper::getValue(Yii::$app->user, 'identity.email', ''),
                                'options' => [
                                    'alt' =>  ArrayHelper::getValue(Yii::$app->user, 'identity.fullname'),
                                    'class' => 'border rounded-circle'
                                ],
                                'size' => 48
                            ]) ?>
                        </a>
                        <!-- END User Avatar -->

                        <!-- User Info -->
                        <div class="ms-2">
                            <a class="text-white fw-semibold" href="javascript:void(0)"><?= (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->username : '' ?></a>
                            <div class="text-white-75 fs-sm">Người dùng</div>
                        </div>
                        <!-- END User Info -->

                        <!-- Close Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="ms-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times-circle"></i>
                        </a>
                        <!-- END Close Side Overlay -->
                    </div>
                </div>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <?php include('_side-content.php') ?>
            <!-- END Side Content -->
        </aside>
        <!-- END Side Overlay -->

        <!-- Sidebar -->
        <!--
        Sidebar Mini Mode - Display Helper classes
      
        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
          If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element
      
        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
      -->
        <?php include '_sidebar.php' ?>
        <!-- END Sidebar -->

        <!-- Header -->

        <?php include '_header.php' ?>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Hero -->
            <?php if (!isset($this->params['hideHero'])) : ?>
                <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h3 class="flex-grow-1 fs-5 fw-semibold my-2 my-sm-3"><?= Html::encode($this->title) ?></h3>
                            <?php if (!empty($this->params['breadcrumbs'])) : ?>
                                <?= Breadcrumbs::widget([
                                    'links' => $this->params['breadcrumbs'],
                                    'navOptions' => ['class' => 'flex-shrink-0 my-2 my-sm-0 ms-sm-3 text-uppercase'],
                                    'options' => ['class' => 'breadcrumb-alt']
                                ]) ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

            <?php endif ?>

            <!-- END Hero -->

            <!-- Page Content -->
            <div class="content">
                <?= $content ?>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

        <?php include '_footer.php' ?>
    </div>
    <!-- END Page Container -->

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>