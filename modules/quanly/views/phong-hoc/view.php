<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use app\widgets\crud\CrudAsset;
use app\modules\services\UtilityService;

use app\modules\services\MapService;
use app\widgets\maps\layers\TileLayer;
use app\widgets\maps\types\LatLng;
use app\widgets\maps\layers\Marker;
use app\widgets\maps\LeafletMap;
use app\widgets\maps\types\Icon;
use app\widgets\maps\types\Point;
use app\widgets\maps\controls\Layers;
use app\widgets\maps\controls\Scale;
use app\widgets\maps\LeafletMapAsset;
LeafletMapAsset::register($this);
CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\DonviKinhte */
?>


<?php
$requestedAction = Yii::$app->requestedAction;
$controller = $requestedAction->controller;
$const['label'] = $controller->const['label'];

$this->title = Yii::t('app', $const['label'][$requestedAction->id] . ' ' . $controller->const['title']);
$this->params['breadcrumbs'][] = ['label' => $const['label']['index'] . ' ' . $controller->const['title'], 'url' => $controller->const['url']['index']];
$this->params['breadcrumbs'][] = $const['label']['view'] . ' ' . $controller->const['title'];

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

.days__container {
    justify-content: center;
}

.part__day {
    justify-content: center;
}

.card{
    height: 100%;
    width:  100%;
    background-color: lightblue;
}

span.card-content{
    font-size:16px;
}
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="block block-themed">
            <div class="block-header">
                <h3 class="block-title">Chi tiết phòng học</h3>
                <div class="block-options">

                </div>
            </div>
            <div class="d-lg-none py-2 px-2">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button"
                            class="btn w-100 btn-primary d-flex justify-content-between align-items-center"
                            data-toggle="class-toggle" data-target="#tabs-navigation" data-class="d-none">
                            Menu
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="tabs-navigation" class="d-none d-lg-block">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    <li class="nav-item" role="presentation">
                        <?= Html::button('Thông tin phòng học', [
                            'type' => 'button',
                            'class' => 'nav-link active',
                            'data-bs-toggle' => 'tab',
                            'data-bs-target' => "#thongtinchung-view",
                        ]) ?>
                    </li>

                    <li class="nav-item" role="presentation">
                        <?= Html::button('Thời khóa biểu', [
                            'type' => 'button',
                            'class' => 'nav-link',
                            'data-bs-toggle' => 'tab',
                            'href' => "#lichhoc-view",
                        ]) ?>
                    </li>
                </ul>
            </div>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="thongtinchung-view">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-gray border-info">
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ma') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ma != null) ? $model->ma : '<i>Chưa có</i>' ?>
                                    </td>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ten') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ten != null) ? $model->ten : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="lichhoc-view">
                    <div class="row">
                        <div class="schedule__container">
                            <div class="days__container">
                                <span class="corner"></span>
                                <div class="day">Chủ nhật</div>
                                <div class="day">Thứ 2</div>
                                <div class="day">Thứ 3</div>
                                <div class="day">Thứ 4</div>
                                <div class="day">Thứ 5</div>
                                <div class="day">Thứ 6</div>
                                <div class="day">Thứ 7</div>
                            </div>
                            <div class="part__day">
                                <span class="time">8:00 <br> - <br> 9:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][8] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][8] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">9:00 <br> - <br> 10:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][9] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][9] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">10:00 <br> - <br> 11:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][10] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][10] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">11:00 <br> - <br> 12:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][11] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][11] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">12:00 <br> - <br> 13:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][12] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][12] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">13:00 <br> - <br> 14:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][13] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][13] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">14:00 <br> - <br> 15:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][14] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][14] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">15:00 <br> - <br> 16:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][15] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][15] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">16:00 <br> - <br> 17:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][16] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][16] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">17:00 <br> - <br> 18:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][17] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][17] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">18:00 <br> - <br> 19:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][18] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][18] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">19:00 <br> - <br> 20:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][19] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][19] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">20:00 <br> - <br> 21:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][20] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][20] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">21:00 <br> - <br> 22:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][21] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][21] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="part__day">
                                <span class="time">22:00 <br> - <br> 23:00</span>
                                <div class="task">
                                    <?php if($thoikhoabieu[1][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[1][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[2][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[2][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[3][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[3][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[4][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[4][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[5][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[5][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[6][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[6][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="task">
                                    <?php if($thoikhoabieu[7][22] != null): ?>
                                    <div class="card">
                                        <span class="card-content">
                                            <?= $thoikhoabieu[7][22] ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row px-3">
                    <div class="col-lg-12 form-group">

                        <a href="javascript:history.back()" class="btn btn-light float-end"><i
                                class="fa fa-arrow-left"></i>
                            Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => Modal::SIZE_LARGE,
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>