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
        $filename = rand() * 100 . '_demo.xls';
        $data = [
            // 第一个sheet内容
            [
                ['第一列','第二列'],
                ['123', '123'],
                ['456', '456']
            ],
            // 第二个sheet内容
            [
                ['第一列','第二列'],
                ['123', '123'],
            ]
        ];
        $sheets = ['demo_sheetA', 'demo_sheetB'];

        AsyncXls::write($filename, $data, $sheets, $headers = []);

        echo 'SUCCESS' . PHP_EOL;
    }

}

$test = new Test();
$test->demo();