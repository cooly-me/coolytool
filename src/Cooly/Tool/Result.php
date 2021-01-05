<?php
/**
 * @title Result
 * @decribe ...
 * @date 2021/1/5
 * @anthor mz
 */

namespace Cooly\Tool;


class Result
{
    /**
     * @title 成功返回
     * @decribe ...
     * @param int $code
     * @param string $msg
     * @param mixed $data
     * @date 2020/12/28
     * @anthor mz
     */
    public static function success($code= 200,$msg="",$data = []){
        $result = [
            "status" => 0,
            "code" => $code,
            "msg" => $msg,
            "data" => $data
        ];
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }

    /**
     * @title 失败返回
     * @decribe ...
     * @param int $code
     * @param mixed $data
     * @param mixed $msg
     * @date 2020/12/28
     * @anthor mz
     */
    public static function fail($code = 400,$msg="",$data = []){
        $result = [
            "status" => 1,
            "code" => $code,
            "msg" => $msg
        ];
        if(!empty($data)){
            $result["data"] = $data;
        }
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
    }
}