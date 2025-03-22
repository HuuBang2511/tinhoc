<?php

use yii\bootstrap5\Modal;
use yii\helpers\Html;
use app\widgets\crud\CrudAsset;
use app\modules\services\UtilityService;

use app\widgets\gridview\GridView;
use app\widgets\export\ExportMenu;

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
                <h3 class="block-title">Chi tiết lớp học</h3>
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
                        <?= Html::button('Thông tin lớp học', [
                            'type' => 'button',
                            'class' => 'nav-link active',
                            'data-bs-toggle' => 'tab',
                            'data-bs-target' => "#thongtinchung-view",
                        ]) ?>
                    </li>

                    <li class="nav-item" role="presentation">
                        <?= Html::button('Lịch học', [
                            'type' => 'button',
                            'class' => 'nav-link',
                            'data-bs-toggle' => 'tab',
                            'href' => "#lichhoc-view",
                        ]) ?>
                    </li>
                    <li class="nav-item" role="presentation">
                        <?= Html::button('Học viên thuộc lớp', [
                            'type' => 'button',
                            'class' => 'nav-link',
                            'data-bs-toggle' => 'tab',
                            'href' => "#hocvien-view",
                        ]) ?>
                    </li> 
                    <li class="nav-item" role="presentation">
                        <?= Html::button('Thông tin nghỉ học', [
                            'type' => 'button',
                            'class' => 'nav-link',
                            'data-bs-toggle' => 'tab',
                            'href' => "#nghihoc-view",
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
                                        <?= $model->getAttributelabel('khoahoc_id') ?></th>
                                    <td colspan="3">
                                        <?= ($model->khoahoc_id != null) ? $model->khoahoc->ten : '<i>Chưa có</i>' ?>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ma') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ma != null) ? $model->ma : '<i>Chưa có</i>' ?>
                                    </td>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('tinhtranglophoc_id') ?></th>
                                    <td width='30%'>
                                        <?= ($model->tinhtranglophoc_id != null) ? $model->tinhtranglophoc->ten : '<i>Chưa có</i>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ngaybatdau') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ngaybatdau != null) ? $model->ngaybatdau : '<i>Chưa có</i>' ?>
                                    </td>
                                    <th width='20%' class="text-center">
                                        <?= $model->getAttributelabel('ngayketthuc') ?></th>
                                    <td width='30%'>
                                        <?= ($model->ngayketthuc != null) ? $model->ngayketthuc : '<i>Chưa có</i>' ?>
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
                                    <th>Giáo viên</th>
                                    <th>Phòng học</th>
                                    <th>Giờ bắt đầu</th>
                                    <th>Giờ kết thúc</th>
                                    <th>Thứ trong tuần</th>
                                </tr>
                                <?php if ($lichhoc != null) : ?>
                                <?php foreach ($lichhoc as $i => $item) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $item->giaovien->ho_ten ?></td>
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
                <div class="tab-pane" id="hocvien-view">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/themhocvien?id=<?= $_GET['id'] ?>"
                            class="btn btn-block btn-success mb-3 float-end" role="modal-remote">Thêm học viên vào lớp</a>
                            <?php if ($hocvienLophoc != null) : ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên học viên</th>
                                    <th>CCCD</th>
                                    <th>Trình độ</th>
                                    <th>Tình trạng học phí</th>
                                    <th>Tình trạng hoàn thành</th>
                                    <th></th>
                                </tr>
                                <?php if ($hocvienLophoc != null) : ?>
                                <?php foreach ($hocvienLophoc as $i => $item) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $item->hocvien->ho_ten ?></td>
                                    <td><?= $item->hocvien->cccd ?></td>
                                    <td><?= ($item->hocvien->trinhdo_id != null) ? $item->hocvien->trinhdo->ten : '' ?></td>
                                    <td><?= ($item->tinhtranghocphi_id != null) ? $item->tinhtranghocphi->ten : '' ?></td>
                                    <td><?= ($item->tinhtranghoanthanh_id != null) ? $item->tinhtranghoanthanh->ten : '' ?></td>
                                    <td class="text-center">
                                        <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/ketqua?hocvien_id=<?= $item->hocvien_id ?>&id=<?= $_GET['id'] ?>"
                                         role="modal-remote"><i
                                        class="btn btn-block btn-success fa fa-plus"></i></a>
                                        <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/capnhathocvien?id=<?= $item->id ?>"
                                         role="modal-remote"><i
                                        class="btn btn-block btn-warning fa fa-pencil"></i></a>
                                        <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/xoahocvien?id=<?= $item->id ?>" data-toggle="tooltip" data-confirm="Bạn có chắc muốn xóa học viên khỏi lớp" ><i
                                        class="btn btn-block btn-danger fa fa-trash"></i></a>
                                    </td>
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
                
                <div class="tab-pane" id="nghihoc-view">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/diemdanh?id=<?= $_GET['id'] ?>"
                            class="btn btn-block btn-success mb-3 float-end" role="modal-remote">Thêm thông tin điểm danh</a>
                            <?php if ($diemdanh != null) : ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên học viên</th>
                                    <th>Ngày nghỉ</th>
                                    <th>Thông tin</th>
                                    <th></th>
                                </tr>
                                <?php if ($diemdanh != null) : ?>
                                <?php foreach ($diemdanh as $i => $item) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $item->hocvien->ho_ten ?></td>
                                    <td><?= $item->date ?></td>
                                    <td><?= $item->lydonghi ?></td>
                                    <td class="text-center">
                                        <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/capnhat-diemdanh?id=<?= $item->id ?>"
                                         role="modal-remote"><i
                                        class="btn btn-block btn-warning fa fa-pencil"></i></a>
                                        <a href="<?= Yii::$app->homeUrl ?>quanly/lop-hoc/xoadiemdanh?id=<?= $item->id ?>" data-toggle="tooltip" data-confirm="Bạn có chắc muốn xóa thông tin điểm danh" ><i
                                        class="btn btn-block btn-danger fa fa-trash"></i></a>
                                    </td>
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
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>
$(document).ready(function() {
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        localStorage.setItem('lastTab', $(this).attr('href'));
        localStorage.setItem('lophoc_id', '<?= $model->id ?>')
    });
    var lastTab = localStorage.getItem('lastTab');

    console.log(localStorage);

    if (localStorage.getItem('lophoc_id') == <?= $model->id ?>) {
        //console.log("same id");
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
        }
        
    }
});

</script>

