<?php
$controller = Yii::$app->controller;
$module = $controller->module;

use \app\modules\base\Constant;
use yii\helpers\Url;
use \app\modules\APPConfig;

$url = implode('/', [$module->id, $controller->id]);

$adminSidebar = APPConfig::$CONFIG['adminSidebar'];
$quanly = APPConfig::$CONFIG['quanly'];
$danhmuc = APPConfig::$CONFIG['danhmuc'];

?>

<nav id="sidebar" aria-label="Main Navigation">

    <div class="bg-primary">
        <div class="content-header bg-white-5">
            <a class="font-w600 text-white tracking-wide logo-default" href="<?= Yii::$app->homeUrl ?>">
                <img src="<?= Yii::$app->homeUrl ?>images/logo.png" width="100%"
                     alt="logo"
                     class="logo-default py-2 h-100">
            </a>
            <div>
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                        data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="js-sidebar-scroll simplebar-scrollable-y" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content"
                         style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <div class="content-side  h-100">
                                <ul class="nav-main">
                                    <?php foreach ($adminSidebar as $navchild) : ?>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link"
                                               href="<?= Yii::$app->urlManager->createUrl([$navchild['url']]) ?>">
                                                <i class="nav-main-link-icon <?= $navchild['icon'] ?>"></i>
                                                <span class="nav-main-link-name"><?= $navchild['name'] ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>

                                    <li class="nav-main-heading">Quản lý</li>
                                    <?php foreach ($quanly as $item) : ?>
                                        <?php if ($item['hasChild']): ?>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                   aria-haspopup="true" aria-expanded="true" href="#">
                                                    <i class="nav-main-link-icon <?= $item['icon'] ?>"></i>
                                                    <span class="nav-main-link-name"><?= $item['name'] ?></span>
                                                </a>
                                                <ul class="nav-main-submenu">
                                                    <?php foreach ($item['children'] as $i => $child): ?>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                               href="<?= Yii::$app->urlManager->createUrl($child['url']) ?>">
                                                               <i class="nav-main-link-icon <?= $child['icon'] ?>"></i>
                                                                <span class="nav-main-link-name"><?= $child['name'] ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link"
                                                   href="<?= Yii::$app->urlManager->createUrl([$item['url']]) ?>">
                                                   <i class="nav-main-link-icon <?= $item['icon'] ?>"></i>
                                                    <span class="nav-main-link-name"><?= $item['name'] ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <li class="nav-main-heading">Danh mục</li>
                                    <?php foreach ($danhmuc as $item) : ?>
                                        <?php if ($item['hasChild']): ?>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                   aria-haspopup="true" aria-expanded="true" href="#">
                                                    <i class="nav-main-link-icon <?= $item['icon'] ?>"></i>
                                                    <span class="nav-main-link-name"><?= $item['name'] ?></span>
                                                </a>
                                                <ul class="nav-main-submenu">
                                                    <?php foreach ($item['children'] as $i => $child): ?>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                               href="<?= Yii::$app->urlManager->createUrl($child['url']) ?>">
                                                               <i class="nav-main-link-icon <?= $child['icon'] ?>"></i>
                                                                <span class="nav-main-link-name"><?= $child['name'] ?></span>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li class="nav-main-item">
                                                <a class="nav-main-link"
                                                   href="<?= Yii::$app->urlManager->createUrl([$item['url']]) ?>">
                                                   <i class="nav-main-link-icon <?= $item['icon'] ?>"></i>
                                                    <span class="nav-main-link-name"><?= $item['name'] ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: 250px; height: 1488px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                 style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function () {
        $('li.active').parent().parent().addClass('open');
        $('li.active a').addClass('active');
    })
</script>