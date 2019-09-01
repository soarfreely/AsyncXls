<?php
namespace AsyncXls;

use Exception;

class Fork
{
    /**
     * 参数
     *
     * @var array
     */
    public static $param = [];

    /**
     * run
     * User: <soarfreely.z@gmail.com>
     * @throws Exception
     * Date: 19-8-3 Time: 下午4:08
     */
    public static function run()
    {
        self::check();

        self::worker();

        self::processExit();
    }

    /**
     * setParam
     * User: <soarfreely.z@gmail.com>
     * @param array $param
     * Date: 19-8-3 Time: 下午4:36
     */
    public static function setParam(array $param)
    {
        !empty($param) && self::$param = $param;
    }

    /**
     * forkWorker
     * User: <soarfreely.z@gmail.com>
     * Date: 19-8-3 Time: 下午3:59
     */
    private static function worker()
    {
        $pid = pcntl_fork();
        if ($pid == 0) {
            call_user_func(['AsyncXls\WriteXls', 'write'], ...self::$param);
            exit(0);
        }
    }

    /**
     * processExit
     * User: <soarfreely.z@gmail.com>
     * Date: 19-8-3 Time: 下午3:56
     */
    private static function processExit()
    {
        $status = -1;
        pcntl_wait($status, WNOHANG);
    }

    /**
     * init
     * User: <soarfreely.z@gmail.com>
     * @throws Exception
     * Date: 19-8-3 Time: 下午5:23
     */
    private static function check()
    {
        if (!function_exists('pcntl_fork')) {
            throw new Exception('请先安装pcntl扩展');
        }
    }
}



