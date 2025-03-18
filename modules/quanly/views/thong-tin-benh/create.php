<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\ThongTinBenh */

?>
<div class="thong-tin-benh-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>
</div>
