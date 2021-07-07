<?php
/**
 * Created by PhpStorm.
 * User: maizai
 * Date: 2021/7/7
 */

namespace Cooly\Tool;

trait singleton
{
    private static $instance;

    /**
     * name: getInstance
     * describe: 单例
     * @return singleton
     * author: mz
     * date: 2021/7/7
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof static){
            self::$instance = new static();
        }
        return self::$instance;
    }
}