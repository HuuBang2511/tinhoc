<?php

namespace app\widgets\echarts;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

class ECharts extends Widget
{
    public $title = '';
    public $show = false;
    public $orient = 'vertical';
    public $type;
    public $legend = true;
    public $labels;
    public $data;
    public $color;
    public $unit = '';
    public $radius = '70%';
    public $options;
    public $divOptions;
    public $isStacked = false;
    public $height = '400px';
    private $xAxis;
    private $yAxis;

    const PIE = 'pie';
    const DONUT = 'pie';
    const BAR = 'bar';
    const STACKED_BAR = 'total';
    const LINE = 'line';

    public function init()
    {
        parent::init();
        if (empty($this->type)) {
            throw new InvalidConfigException(
                "'type' attribute cannot be empty."
            );
        }
    }

    public function run()
    {
        $this->divOptions['id'] = $this->id;
        echo "\n" . Html::tag('div', '', $this->divOptions);
        $this->registerScript();
    }

    public function registerScript()
    {
        $view = $this->getView();

        $options['title'] = [
            'show' => $this->show,
            'text' => $this->title,
            'left' => 'center',
        ];

        $options['tooltip'] = [
            'trigger' => 'item',
            'textStyle' => [
                'fontFamily' => 'Roboto'
            ],
            'formatter' => '<b>{b}:</b> {c} ' . $this->unit . ' ({d}%)'
        ];

        $options['legend'] = [
            'orient' => $this->orient,
            'left' => 'left',
            'textStyle' => [
                'fontFamily' => 'Roboto'
            ],
        ];

        $options['series'] = [
            [
                'type' => $this->type,
                'radius' => $this->radius,
                'data' => $this->data,
                'label' => [
                    'show' => true,
                ],
                'labelLine' => ['show' => true],
            ]
        ];

        //đặt màu cho chart
        if(isset($this->data[0]['color'])){
            $color = ArrayHelper::getColumn($this->data,'color');
            if($color !== null){
                $options['color'] = $color;
            }
        }


        $options['emphasis'] = [
            'itemStyle' => [
                'shadowBlur' => 10,
                'shadowOffsetX' => 10,
                'shadowColor' => 'rgba(0, 0, 0, 0.5)'
            ]
        ];

        $options = json_encode($options);
        if ($this->type == 'bar') {
            $options = self::renderBarChart($this->isStacked);
        }
        $js[] = "var $this->id = echarts.init(document.getElementById('$this->id'), null, {renderer: 'canvas', useDirtyRect: false});";
        $js[] = "var option$this->id = $options";
        $js[] = "if (option$this->id && typeof option$this->id === \"object\") {
  $this->id.setOption(option$this->id);
}";
        $js[] = "window.addEventListener('resize', $this->id.resize);";

        $view->registerJs(implode("\n", $js));

    }

    private function initPieOptions()
    {
        $option = [];

        return $option;
    }

    private function renderPieChart()
    {
        $option = [];

        return $option;
    }

    private function renderBarChart($isStacked = false)
    {
        $options['title'] = [
            'show' => $this->show,
            'text' => $this->title,
            'left' => 'left',
        ];

        $options['legend'] = [
            'show' => $this->legend,
        ];

        $options['yAxis'] = [
            'type' => 'category',
            'data' => $this->labels,
            'axisLabel' => [
                'fontFamily' => 'sans-serif',
            ],
        ];

        $options['xAxis'] = [
            'type' => 'value'
        ];

        $options['grid'] = [
            'left' => '3%',
            'right' => '4%',
            'bottom' => '3%',
            'containLabel' => true
        ];

        $options['tooltip'] = [
            'trigger' => 'axis',
            'axisPointer' => [
                'type' => 'shadow'
            ],
            'textStyle' => [
                'fontFamily' => 'sans-serif'
            ],
        ];

        foreach ($this->data as $datum) {
            //dd($datum);
            $options['series'][] = [
                'name' => $datum['name'],
                'data' => $datum['data'],
                'color' => isset($datum['color']) ? $datum['color'] : '#97cc71',
                'type' => $this->type,
                'stack' => 'total',
                'label' => [
                    'show' => true,
                ]
            ];
        }

        return json_encode($options);
    }
}