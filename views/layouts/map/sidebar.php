<nav id="sidebar" class="boxshadow sidebar-map" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <a class="block-title text-center" href="<?= Yii::$app->homeUrl ?>">
                <img src="<?= Yii::$app->homeUrl?>images/quan11/logo.png" width="70%" alt="logo">
            </a>
            <div>
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
        </div>
        <div class="toggleDiv">
            <div class="m-3">
                <button type="button" class="btn btn-sm btn-alt-primary toggleBtn" data-toggle="layout" data-action="sidebar_toggle" onclick="resizeMap()">
                    <i class="fa fa-fw fa-bars"></i>
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
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <?php if (isset($this->blocks['block-search'])) : ?>
                                <?= $this->blocks['block-search'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: 250px; height: 1328px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 261px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
</nav>