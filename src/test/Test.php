<?php
namespace AsyncXls\test;

use AsyncXls\AsyncXls;

require_once "../../vendor/autoload.php";
require_once "./../AsyncXls.php";
require_once "./../Fork.php";
require_once "./../WriteXls.php";


class Test
{
    public function demo()
    {
        $filename = rand() . '_demo.xls';
        $data = [
            // 第一个sheet内容
            [
                ['第一列','第二列'],
                ['第一个sheet第一列内容', '第一个sheet第二列内容'],
                ['第一个sheet第一列内容', '第一个sheet第二列内容'],
            ],
            // 第二个sheet内容
            [
                ['第一列','第二列'],
                ['第二个sheet第一列内容', '第二个sheet第二列内容'],
            ]
        ];
        $sheets = ['demo_sheetA', 'demo_sheetB'];

        AsyncXls::write($filename, $data, $sheets, $headers = []);

        echo 'SUCCESS' . PHP_EOL;
    }

}

$test = new Test();
$test->demo();