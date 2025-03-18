<?php

namespace app\modules\map;

/**
 * map module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\map\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->layout = "@app/views/layouts/topmenu/main";

        // custom initialization code goes here
    }
}
