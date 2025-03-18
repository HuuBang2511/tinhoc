<?php

use yii\helpers\Url;

$sidebar = Yii::$app->params['userModuleSidebar'];

$logoUrl = Yii::$app->params['logoUrl'];
?>
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-primary-darker">
        <div class="content-header bg-white-5 text-center">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide " href="<?= Yii::$app->homeUrl?>">
                <img src="<?= Yii::$app->homeUrl .Yii::$app->params['logoUrl']?>" alt="Logo" width="100%">
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- Toggle Sidebar Style -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- Class Toggle, functionality initialized in Helpers.dmToggleClass() -->
                <!-- <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                            <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                        </button> -->
                <!-- END Toggle Sidebar Style -->

                <!-- Dark Mode -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <!-- <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button> -->
                <!-- END Dark Mode -->

                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link" href="<?= Url::to(['/']) ?>">
                        <i class="nav-main-link-icon fa fa-rocket"></i>
                        <span class="nav-main-link-name">Trang chủ</span>
                        <!-- <span class="nav-main-link-badge badge rounded-pill bg-primary">3</span> -->
                    </a>
                </li>
                <?php foreach ($sidebar as $group) : ?>
                    <li class="nav-main-heading"><?= $group['name'] ?></li>
                    <li class="nav-main-item">
                        <?php foreach ($group['items'] as $item) : ?>
                            <?php if (isset($item['items'])) : ?>
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="<?= Url::to([$item['url']]) ?>">
                                    <i class="nav-main-link-icon fa <?= $item['icon'] ?>"></i>
                                    <span class="nav-main-link-name"><?= $item['name'] ?></span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <?php foreach ($item['items'] as $subItem) : ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="<?= Url::to([$subItem['url']]) ?>">
                                                <span class="nav-main-link-name"><?= $subItem['name'] ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach ?>

                                </ul>
                            <?php else : ?>
                                <a class="nav-main-link" aria-haspopup="true" aria-expanded="false" href="<?= Url::to([$item['url']]) ?>">
                                    <i class="nav-main-link-icon fa <?= $item['icon'] ?>"></i>
                                    <span class="nav-main-link-name"><?= $item['name'] ?></span>
                                </a>
                            <?php endif ?>
                        <?php endforeach ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>