<?php
/**
 * Created by PhpStorm.
 * User: Duc
 * Date: 9/24/2021
 * Time: 9:55 PM
 */

namespace app\modules\base;

use hcmgis\contrib\activity\models\Activity;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
class BaseController extends Controller
{
    public $layout = "@app/views/layouts/topmenu/main";
    public $title = '';

    public $label = [
        'index' => 'Danh sách',
        'search' => 'Tìm kiếm',
        'create' => 'Thêm mới',
        'update' => 'Cập nhật',
        'view' => 'Chi tiết',
        'delete' => 'Xóa',
        'statistic' => 'Thống kê',
        'location' => 'Vị trí',
    ];

    // public function beforeAction($action)
    // {
    //     if (!parent::beforeAction($action)) {
    //         return false;
    //     }

    //     // log the activity
    //     $activity = new Activity();
    //     $activity->data = VarDumper::dumpAsString(Yii::$app->request);
    //     $activity->url = Yii::$app->request->url;

    //     if (!Yii::$app->user->isGuest) {
    //         $activity->user_id = Yii::$app->user->id;
    //         $activity->username = Yii::$app->user->identity->username;
    //     }
    //     $activity->save();

    //     return true;
    // }
}