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



<div class="row">
    <div class="col-lg-12">
        <div class="block block-themed">
            <div class="block-header">
                <h3 class="block-title">Chi tiết học viên</h3>
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
                        <?= Html::button('Thông tin giáo viên', [
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
                                        <?= $model->getAttributelabel('ho_ten') ?></th>
                                    <td colspan="3">
                                        <?= ($model->ho_ten != null) ? $model->ho_ten : '<i>Chưa có</i>' ?>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ma') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ma != null) ? $model->ma : '<i>Chưa có</i>' ?>
                                    </td>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ngay_sinh') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ngay_sinh != null) ? date('d/m/Y', strtotime($model->ngay_sinh)) : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('so_dien_thoai') ?></th>
                                    <td width='30%'>
                                        <?= ($model->so_dien_thoai != null) ? $model->so_dien_thoai : '<i>Chưa có</i>' ?>
                                    </td>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('gmail') ?></th>
                                    <td width='30%'>
                                        <?= ($model->gmail != null) ? $model->gmail : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('gioitinh_id') ?></th>
                                    <td width='30%'>
                                        <?= ($model->gioitinh_id != null) ? $model->gioitinh->ten : '<i>Chưa có</i>' ?>
                                    </td>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('cccd') ?></th>
                                    <td width='30%'>
                                        <?= ($model->cccd != null) ? $model->cccd : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('trinh_do') ?></th>
                                    <td colspan="3">
                                        <?= ($model->trinh_do != null) ? $model->trinh_do : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('bang_cap') ?></th>
                                    <td colspan="3">
                                        <?= ($model->bang_cap != null) ? $model->bang_cap : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="lichhoc-view">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($lichhoc != null) : ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Lớp học</th>
                                    <th>Khóa học</th>
                                    <th>Phòng học</th>
                                    <th>Giờ bắt đầu</th>
                                    <th>Giờ kết thúc</th>
                                    <th>Thứ trong tuần</th>
                                </tr>
                                <?php if ($lichhoc != null) : ?>
                                <?php foreach ($lichhoc as $i => $item) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $item->lophoc->ma ?></td>
                                    <td><?= $item->lophoc->khoahoc->ten ?></td>
                                    <td><?= $item->phonghoc->ten ?></td>
                                    <td><?= $item->giobatdau.':00' ?></td>
                                    <td><?= $item->gioketthuc.':00' ?></td>
                                    <td><?= ($item->thutrongtuan != null) ? (($item->thutrongtuan == 1) ? 'Chủ nhật' : 'Thứ '.$item->thutrongtuan) : '' ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">Không có dữ liệu</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>        
                
                <div class="row px-3">
                    <div class="col-lg-12 form-group">

                        <a href="javascript:history.back()" class="btn btn-light float-end"><i class="fa fa-arrow-left"></i>
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
