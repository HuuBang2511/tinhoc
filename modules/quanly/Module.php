<?php

namespace app\modules\quanly;

/**
 * map module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->layout = "@app/views/layouts/topmenu/main";

        parent::init();
    }
}
