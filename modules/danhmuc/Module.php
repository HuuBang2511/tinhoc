<?php

namespace app\modules\danhmuc;

class Module extends \yii\base\Module
{
    public function init()
    {
        $this->layout = "@app/views/layouts/topmenu/main";
        parent::init();
    }
}