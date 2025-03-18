<?php



namespace app\assets;

use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

use yii\web\View;

class ViteAsset extends AssetBundle
{
    public $jsOptions = ['type' => 'module', 'position' => View::POS_HEAD];
    public $manifestPath = '@webroot/dist/manifest.json';

    public function init()
    {
        parent::init();
        if (YII_ENV_DEV) {
            $this->baseUrl = 'http://localhost:5173';
            $this->basePath = null;
        } else {
            $manifestData = self::getManifestData();
            $newCss = [];
            $newJs = [];
            foreach ($this->css as $css) {
                if (is_array($css)) {
                    $cssUrl = array_shift($css);
                    $newCss[] = array_merge([$manifestData[$cssUrl]['file']], $css);
                } else {
                    $newCss[] = $manifestData[$css]['file'];
                }
            }
            foreach ($this->js as $js) {
                if (is_array($js)) {
                    $jsUrl = array_shift($js);
                    $newJs[] = array_merge([$manifestData[$jsUrl]['file']], $js);
                } else {
                    $newJs[] = $manifestData[$js]['file'];
                }
            }
            $this->css = $newCss;
            $this->js = $newJs;
        }
    }

    public function registerAssetFiles($view)
    {
        if (YII_ENV_DEV) {
            $view->registerJsFile('http://localhost:5173/@vite/client', ['position' => View::POS_HEAD, 'type' => 'module']);
        }
        parent::registerAssetFiles($view);
    }

    public function url($path)
    {
        if (YII_ENV_DEV) {
        } else {
            $manifestData = self::getManifestData();
            $path = $manifestData[$path]['file'];
        }

        return \Yii::$app->assetManager->getAssetUrl($this, $path);
    }

    protected function getManifestData()
    {
        $manifestFile = \Yii::getAlias($this->manifestPath);
        return json_decode(file_get_contents($manifestFile), true);
    }
}
