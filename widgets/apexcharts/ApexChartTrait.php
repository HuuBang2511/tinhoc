<?php

namespace app\widgets\apexcharts;

trait ApexChartTrait
{

    public $moduleID;

    public $type;

    public $label;

    public $series;

    public $unit = '';

    public $chartOptions = [];

    public $options = [];

    public $colors = [
        '#009f4d', '#efdf00',  '#fe5000', '#84bd00', '#e4002b',  '#00a4e4', '#da1884', '#0077c8', '#008eaa', '#ff0000', '#c1d82f', '#fbb034', '#7d3f98', '#4d4f53'
    ];
}
