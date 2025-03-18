<?php

namespace app\modules\base;

use app\services\DebugService;
use app\services\UtilityService;
use yii\base\Model;

class ExcelTemp extends Model
{
    public $fileupload;

    public function rules()
    {
        return [
            [['fileupload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir = 'temp';
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $today = (date("YmdHi"));
            //DebugService::dumpdie($today);
            $baseName = str_replace(' ', '-', strtolower(UtilityService::utf8convert(trim($this->fileupload->baseName))));
            $file_path = $dir .  '/' . $baseName . '.' . $this->fileupload->extension;
            //dd($file_path);
            $this->fileupload->saveAs($file_path);
            // }
            return true;
        } else {
            return false;
        }
    }
}
