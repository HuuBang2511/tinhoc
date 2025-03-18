<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row pb-3">
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-xwork block-fx-pop text-center h-100 mb-0" href="<?= Yii::$app->homeUrl ?>quanly/nong-ho/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số nông hộ</div>
                                    <div class="display-6 fw-bold text-light"><?= isset($count['nongho']) ? $count['nongho'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-xeco block-fx-pop text-center h-100 mb-0" href="<?= Yii::$app->homeUrl ?>quanly/diagioi-hanhchinh/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số địa giới hành chính</div>
                                    <div class="display-6 fw-bold text-light"><?= isset($count['diagioi_hanhchinh']) ? $count['diagioi_hanhchinh'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-warning block-fx-pop text-center h-100 mb-0" href="<?= Yii::$app->homeUrl ?>quanly/caytrong-canhtac/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số vùng cây trồng canh tác</div>
                                    <div class="display-6 fw-bold text-light"><?= isset($count['caytrong_canhtac']) ? $count['caytrong_canhtac'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-default-light block-fx-pop text-center h-100 mb-0" href="<?= Yii::$app->homeUrl ?>quanly/cuahang-thuocbaove/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số cửa hàng thuốc bảo vệ</div>
                                    <div class="display-6 fw-bold text-light"><?= isset($count['cuahang_thuocbaove']) ? $count['cuahang_thuocbaove'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-12 mt-3">
                    <a class="block block-rounded bg-success block-fx-pop text-center h-100 mb-0">
                        <div class="block-content block-content-full">
                            <div class="row text-light">
                                <div class="col-lg-4">
                                    <div class="text-uppercase mt-1">Tổng số diện tích vùng trồng</div>
                                    <div class="display-6 fw-bold"><?= isset($dientichVungtrong) ? $dientichVungtrong.' m&sup2' : 0 ?></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-uppercase mt-1">Tổng số diện tích nhiễm bệnh</div>
                                    <div class="display-6 fw-bold"><?= isset($dientichNhiembenh) ? $dientichNhiembenh.' m&sup2' : 0 ?></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-uppercase mt-1">Tỉ lệ nhiểm bệnh</div>
                                    <div class="display-6 fw-bold"><?= isset($tileNhiembenh) ? $tileNhiembenh.' %' : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>



