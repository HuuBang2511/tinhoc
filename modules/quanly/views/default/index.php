<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\widgets\echarts\EChartAsset;
EChartAsset::register($this);
?>

<link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>/resources/core/css/timetable.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"
    integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />


<style>
#chart-none {
    font-family: Roboto !important;
}

.chartStyle {
    position: relative;
    height: 600px;
    overflow: hidden;
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
            <div class="row pb-5">
                <div class="col-lg-6">
                    <?php if(isset($statistic['khoahoc_trinhdo']) && count($statistic['khoahoc_trinhdo']) > 0): ?>
                    <div id="pieKhoahoc" class="chartStyle"></div>
                    <?php else: ?>
                    <div class="text-center" id="chart-none">
                        <b>Thống kê theo trình độ khóa học</b>
                        <h4>Không có dữ liệu !</h4>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <?php if(isset($statistic['lophoc_tinhtrang']) && count($statistic['lophoc_tinhtrang']) > 0): ?>
                    <div id="pieLophoc" class="chartStyle"></div>
                    <?php else: ?>
                    <div class="text-center" id="chart-none">
                        <b>Thống kê theo tình trạng lớp học</b>
                        <h4>Không có dữ liệu !</h4>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        <?php if(isset($statistic['khoahoc_trinhdo']) && count($statistic['khoahoc_trinhdo']) > 0): ?>
        initPieChart('pieKhoahoc', 'Thống kê theo trình độ khóa học', null, <?= json_encode($statistic['khoahoc_trinhdo'])?>,'Khóa học')
        <?php endif; ?>
        
        <?php if(isset($statistic['lophoc_tinhtrang']) && count($statistic['lophoc_tinhtrang']) > 0): ?>
        initPieChart('pieLophoc', 'Thống kê theo tình trạng lớp học', null, <?= json_encode($statistic['lophoc_tinhtrang'])?>,'Lớp học')
        <?php endif; ?>
    });

    function initPieChart(id, title, label, data, unit) {
        var chartDom = document.getElementById(id);
        var myChart = echarts.init(chartDom);
        var option;

        option = {
            title: {
                text: title,
                left: 'center',
                textStyle: {
                    fontFamily: 'Roboto'
                }
            },
            textStyle: {
                fontFamily: 'Roboto',
            },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/> <b>{b}</b>:  {c} ({d}%)',
                textStyle: {
                    fontFamily: 'Roboto'
                }
            },
            label: {
            formatter: '{b}:{c}',
            position: 'inside',
            textStyle: {
                fontFamily: 'Roboto',
                fontSize: '8px'
            }
        },
            legend: {
                orient: 'vertical',
                left: 'left',
                top: 'bottom',
            },
            series: [
                {
                    name: unit,
                    type: 'pie',
                    radius: '50%',
                    data: data,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        option && myChart.setOption(option);
    }
</script>