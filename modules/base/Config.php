<?php

namespace app\modules\base;

use app\modules\danhmuc\models\Setting;

class Config
{
    public static function getSettingPhamvi()
    {
        $settingPhamvi = \Yii::$app->cache->getOrSet(Constant::KEY_PHAMVI, function () {
            $setting = Setting::findOne(['key' => Constant::KEY_PHAMVI]);
            if ($setting == null) return null;
            return $setting->value;
        }, 30 * 24 * 3600);
        return $settingPhamvi;
    }
    public static function getMaquan()
    {
        $settingPhamvi = self::getSettingPhamvi();
        $maquan = json_decode($settingPhamvi)->maquan;
        return $maquan;
    }

    public static function getCapHanhchinh()
    {
        return self::getMaquan() == null ? 'Quận huyện' : 'Phường xã';
    }
}
