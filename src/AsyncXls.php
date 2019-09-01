<?php
/**
 * User: User: <soarfreely.z@gmail.com>
 * Date: 19-8-31 Time: 下午3:07
 */

namespace AsyncXls;

use Exception;

class AsyncXls
{
    /**
     * write
     * @param $fileName
     * @param $headers
     * @param $data
     * @param $sheets
     * @param $options
     * @throws Exception
     * Date: 19-8-31 Time: 下午4:22
     */
    public static function write($fileName, $data, $sheets, $headers, $options = [])
    {
        Fork::setParam([$fileName, $data, $sheets, $headers, $options]);
        Fork::run();
    }
}