<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


?>

<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>/resources/core/css/timetable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"
    integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />


<style>
    .task {
        background-color: white;
        height: 70px;
        width: 190px !important;
        margin: 2px;
        cursor: unset;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
    }

    .task__container .task__name {
        padding: 10px;
        margin: 0 10px;
        border-radius: 5px;
        cursor: unset;
    }

    .day {
        width: 190px !important;
        border: solid 1px white;
        color: #9bafd9;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2px;
    }

    .days__container{
        justify-content:center;
    }

    .part__day{
        justify-content:center;
    }
</style>

<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="row pb-3">
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-xwork block-fx-pop text-center h-100 mb-0"
                        href="<?= Yii::$app->homeUrl ?>quanly/khoa-hoc/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số khóa học</div>
                                    <div class="display-6 fw-bold text-light">
                                        <?= isset($count['khoahoc']) ? $count['khoahoc'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-xeco block-fx-pop text-center h-100 mb-0"
                        href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số lớp học</div>
                                    <div class="display-6 fw-bold text-light">
                                        <?= isset($count['lophoc']) ? $count['lophoc'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-warning block-fx-pop text-center h-100 mb-0"
                        href="<?= Yii::$app->homeUrl ?>quanly/phong-hoc/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số phòng học</div>
                                    <div class="display-6 fw-bold text-light">
                                        <?= isset($count['phonghoc']) ? $count['phonghoc'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-6 mt-3">
                    <a class="block block-rounded bg-default-light block-fx-pop text-center h-100 mb-0"
                        href="<?= Yii::$app->homeUrl ?>quanly/giao-vien/index">
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-uppercase mt-1 text-light">Tổng số giáo viên</div>
                                    <div class="display-6 fw-bold text-light">
                                        <?= isset($count['giaovien']) ? $count['giaovien'] : 0 ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>

    <div class="block block-themed">
        <div class="block-header">
            <h3 class="block-title"></h3>
        </div>
        <div class="block-content">
            <div class="row">
                


            </div>
        </div>
    </div>
</div>

<script src="main.js"></script>