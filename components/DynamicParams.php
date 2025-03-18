<?php

namespace app\components;

use app\modules\base\Config;
use app\modules\danhmuc\models\DmQuanhuyen;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;

class DynamicParams extends Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            $app->params = $this->getParams();
        });
    }

    public function getParams()
    {
        return Yii::$app->cache->getOrSet('config-params', function () {
            $params = require __DIR__ . '/../config/params.php';
            $maquan = Config::getMaquan();
            $folder = $this->getFolder($maquan);
            $khuvuc = $this->getKhuvuc($maquan);
            $params['siteName'] = str_replace('{khuvuc}', $khuvuc, $params['siteName']);
            $params['logoUrl'] = str_replace('{folder}', $folder, $params['logoUrl']);
            $params['loginPage']['logoUrl'] = str_replace('{folder}', $folder, $params['loginPage']['logoUrl']);
            $params['loginPage']['backgroundUrl'] = str_replace('{folder}', $folder, $params['loginPage']['backgroundUrl']);
            return $params;
        });
    }

    private function getFolder($maquan)
    {
        if ($maquan == 772) return 'quan11';
        return 'hcm';
    }

    private function getKhuvuc($maquan)
    {
        // if (isset($maquan) && ($quanhuyen = DmQuanhuyen::findOne(['ma' => $maquan])) != null)
        // {            
        //     return $quanhuyen->ten;
        // } else {
        //     return 'Thành phố Hồ Chí Minh';
        // }  
        return 'Thành phố Hồ Chí Minh';      
    }
}
