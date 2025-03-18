<?php

/** @var yii\web\View $this */

use app\modules\base\Config;
use app\widgets\apexcharts\ApexChart;
use app\widgets\apexcharts\ApexchartsAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

ApexchartsAsset::register($this);
$this->title = 'Bảng điều khiển ';
$this->params['breadcrumbs'][] = $this->title;
$this->params['hideHero'] = true;
$donutOptions = [
    'legend' => [
        'formatter' => new JsExpression("function(seriesName, opts) {
                            return seriesName + ' (' + opts.w.config.series[opts.seriesIndex] + ')'
                            }")
    ]
];

$capHanhchinh = Config::getCapHanhchinh();
?>

<div class="row">
    <h3 class="col-12" id="header-caytrong">Cây trồng</h3>
    <div class="col-xxl-3 col-xl-4 col-md-6 " id="caytrong-sohotrongcay">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Số hộ trồng cây
                </h3>
                <div class="block-options">
                    <a class="fs-3 fw-bold mb-0" href="<?= Url::to(['caytrong/nongho']) ?>">
                        <?= $nonghoCount ?>
                    </a>

                </div>
            </div>
            <div class="block-content">
                <?= ApexChart::widget([
                    'type' => ApexChart::SIMPLE_DONUT,
                    'options' => $donutOptions,
                    'label' => ArrayHelper::getColumn($nonghoStatistic, 'ten'),
                    'series' => ArrayHelper::getColumn($nonghoStatistic, 'count')
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-4 col-md-6" id="caytrong-quytrinhsanxuat">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Quy trình sản xuất
                </h3>
                <div class="block-options">
                    <a class="fs-3 fw-bold mb-0" href="<?= Url::to(['caytrong/nongho']) ?>">
                        <?= $nonghoCount ?>
                    </a>

                </div>
            </div>
            <div class="block-content">
                <?= ApexChart::widget([
                    'type' => ApexChart::SIMPLE_DONUT,
                    'options' => $donutOptions,
                    'label' => array_keys($quytrinhSanxuatStatistic),
                    'series' => array_values($quytrinhSanxuatStatistic),
                    'colors' => ['#88c047', '#f0245e']
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-4 col-md-6 " id="caytrong-dientichsanxuat">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Diện tích sản xuất (ha)
                </h3>
            </div>
            <div class="block-content">
                <?= ApexChart::widget([
                    'type' => ApexChart::SIMPLE_COLUMN,
                    'label' => ArrayHelper::getColumn($dientichSanxuatStatistic, 'ten'),
                    'series' => [
                        [
                            'name' => 'Truyền thống',
                            'data' => ArrayHelper::getColumn($dientichSanxuatStatistic, 'truyenthong')
                        ],
                        [
                            'name' => 'VietGAP',
                            'data' => ArrayHelper::getColumn($dientichSanxuatStatistic, 'vietgap')
                        ]
                    ],
                    'colors' => ['#88c047', '#f0245e']
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-md-12 " id="caytrong-thongkehanhchinh">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Thống kê theo <?= $capHanhchinh ?>
                </h3>
            </div>
            <div class="block-content">
                <table class="table  table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= $capHanhchinh ?></th>
                            <th>Số hộ</th>
                            <th>Diện tích (ha)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($nonghoHanhchinhStatistic as $i => $row) : ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $row['ten'] ?></td>
                                <td><?= $row['soho'] ?></td>
                                <td><?= $row['dientich'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h3 class="col-12" id="header-thuysan">Thủy sản</h3>

    <div class="col-xxl-3 col-xl-4 col-md-6 " id="thuysan-cosocatra">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Cơ sở nuôi cá tra
                </h3>
                <div class="block-options">
                    <a class="fs-3 fw-bold mb-0" href="<?= Url::to(['thuysan/coso-nuoicatra']) ?>">
                        <?= $cosoCatraCount ?>
                    </a>
                </div>
            </div>
            <div class="block-content">
                <?= ApexChart::widget([
                    'type' => ApexChart::SIMPLE_DONUT,
                    'options' => $donutOptions,
                    'label' => ArrayHelper::getColumn($cosoCatraStatistic, 'ten'),
                    'series' => ArrayHelper::getColumn($cosoCatraStatistic, 'count')
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-4 col-md-6 " id="thuysan-cosocalongbe">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Cơ sở nuôi cá lồng bè
                </h3>
                <div class="block-options">
                    <a class="fs-3 fw-bold mb-0" href="<?= Url::to(['thuysan/coso-nuoicalongbe']) ?>">
                        <?= $cosoCalongbeCount ?>
                    </a>
                </div>
            </div>
            <div class="block-content">
                <?= ApexChart::widget([
                    'type' => ApexChart::SIMPLE_DONUT,
                    'options' => $donutOptions,
                    'label' => ArrayHelper::getColumn($cosoCalongbeStatistic, 'ten'),
                    'series' => ArrayHelper::getColumn($cosoCalongbeStatistic, 'count')
                ]) ?>
            </div>
        </div>
    </div>
    <div class=" col-md-6 " id="thuysan-thongkehanhchinh">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Thống kê theo <?= $capHanhchinh ?>
                </h3>
            </div>
            <div class="block-content">
                <table class="table  table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= $capHanhchinh ?></th>
                            <th>Số cơ sở <br> nuôi cá tra</th>
                            <th>Số cơ sở <br>nuôi cá lồng bè</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($thuysanHanhchinhStatistic as $i => $row) : ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $row['ten'] ?></td>
                                <td><?= $row['so_coso_catra'] ?></td>
                                <td><?= $row['so_coso_calongbe'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h3 class="col-12" id="header-channuoi">Chăn nuôi</h3>

    <div class="col-xxl-3 col-xl-4 col-md-6 " id="channuoi-nuoiheo">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Trang trại chăn nuôi heo
                </h3>
                <div class="block-options">
                    <a class="fs-3 fw-bold mb-0" href="<?= Url::to(['channuoi/coso-nuoiheo']) ?>">
                        <?= $cosoNuoiheoCount ?>
                    </a>
                </div>
            </div>
            <div class="block-content">

            </div>
        </div>
    </div>
    <div class="col-xl-8 col-md-6 " id="channuoi-thongkehanhchinh">
        <div class="block block-rounded ">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Thống kê theo <?= $capHanhchinh ?>
                </h3>
            </div>
            <div class="block-content">
                <table class="table  table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= $capHanhchinh ?></th>
                            <th>Số cơ sở <br> nuôi heo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($channuoiHanhchinhStatistic as $i => $row) : ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $row['ten'] ?></td>
                                <td><?= $row['so_coso_nuoiheo'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <h3 class="col-12" id="header-dulieudungchung">Dữ liệu dùng chung</h3>
    <div class="col-xxl-3 col-xl-4 col-md-6 " id="dulieu-thuadat">
        <div class="block block-rounded text-center d-flex flex-column flex-grow-1">
            <div class="block-content block-content-full d-flex align-items-center flex-grow-1">
                <div class="w-100">
                    <div class="fs-1 fw-bold"><?= $ranhthuaCount ?></div>
                    <div class="text-muted"> Thửa đất</div>

                </div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                <a class="fw-medium" href="<?= Url::to(['/caytrong/pg-ranhthua']) ?>">
                    Danh sách
                    <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-xl-4 col-md-6 " id="dulieu-nguoidung">
        <div class="block block-rounded text-center d-flex flex-column flex-grow-1">
            <div class="block-content block-content-full d-flex align-items-center flex-grow-1">
                <div class="w-100">
                    <div class="fs-1 fw-bold"><?= $userCount ?></div>
                    <div class="text-muted">Người dùng</div>

                </div>
            </div>
            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                <a class="fw-medium" href="<?= Url::to(['/user/auth-user']) ?>">
                    Danh sách
                    <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                </a>
            </div>
        </div>
    </div>

</div>