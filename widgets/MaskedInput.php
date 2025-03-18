<?php
/**
 * Created by PhpStorm.
 * User: Duc
 * Date: 7/10/2021
 * Time: 12:00 AM
 */

namespace app\widgets;


use yii\helpers\Json;
use yii\web\View;

class MaskedInput extends \yii\widgets\MaskedInput
{
    protected function hashPluginOptions($view)
    {
        $encOptions = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);
        $this->_hashVar = self::PLUGIN_NAME . '_' . hash('crc32', $encOptions);
        $this->options['data-plugin-' . self::PLUGIN_NAME] = $this->_hashVar;
            $view->registerJs("var {$this->_hashVar} = {$encOptions};", View::POS_END);
    }
}