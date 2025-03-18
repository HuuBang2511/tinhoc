<?php



namespace app\assets;

class Vite
{
    public static $manifestPath = '@webroot/dist/manifest.json';
    public static $baseUrl = 'http://localhost:5173';
    public static function url($path)
    {
        if (YII_ENV_DEV) {
            return self::$baseUrl . '/' . $path;
        } else {
            $manifestData = self::getManifestData();
            return '@web/dist/' . $manifestData[$path]['file'];
        }
    }

    public static function register($view, $path, $options = [])
    {
        self::registerJsFile($view, $path, $options);
        if (!YII_ENV_DEV) {
            self::registerCssFile($view, str_replace('.js', '.css', $path));
        }
    }

    public static function registerJsFile($view, $path, $options = [])
    {
        $view->registerJsFile(self::url($path), array_merge(['type' => 'module'], $options));
    }


    public static function registerCssFile($view, $path, $options = [])
    {
        $view->registerCssFile(self::url($path), $options);
    }

    protected static function getManifestData()
    {
        $manifestFile = \Yii::getAlias(self::$manifestPath);
        return json_decode(file_get_contents($manifestFile), true);
    }
}
