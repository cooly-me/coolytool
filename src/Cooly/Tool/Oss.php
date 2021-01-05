<?php
/**
 * @title Oss
 * @decribe ...
 * @date 2021/1/5
 * @anthor mz
 */

namespace Cooly\Tool;


class Oss
{
    private static $accessKeyId = "";
    private static $accessKeySecret = "";
    // Endpoint以杭州为例，其它Region请按实际情况填写。
    private static $endpoint = "";
    private static $showpoint = "";
    // 设置存储空间名称。
    private static $bucket= "";

    /**
     * @title 上传图片
     * @decribe ...
     * @param $fileName string 图片名称
     * @param $filePath string 图片路径
     * @return string
     * @throws \Exception
     * @date 2020/12/30
     * @anthor mz
     */
    public static function uploadFile($fileName,$filePath){
        try{
            $ossClient = new OssClient(self::$accessKeyId, self::$accessKeySecret, self::$endpoint);
            $info = $ossClient->uploadFile(self::$bucket, $fileName, $filePath);
            if(count($info) > 0){
                return self::$showpoint.'/'.$fileName;
            }else{
                throw new \Exception("上传失败");
            }
        } catch(OssException $e) {
            Log::error("上传失败：".$e -> getMessage());
            return "";
        }
    }
}