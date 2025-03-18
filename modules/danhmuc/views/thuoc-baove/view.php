<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\danhmuc\models\DmThuocbaove */
?>
<div class="dm-thuocbaove-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ten',
            'dang_thuoc',
            'quytac_donggoi',
            'thanh_phan:ntext',
            'dac_tri:ntext',
            'ghi_chu:ntext',
        ],
    ]) ?>

</div>

<?php if($model->url_hinhanh != null):?>
    <iframe src="<?= Yii::$app->homeUrl ?><?= $model->url_hinhanh ?>" width="100%" height="550px"></iframe>
<?php endif; ?>
