<?php
/**
 * @title Zip
 * @decribe ...
 * @date 2021/1/5
 * @anthor mz
 */

namespace Cooly\Tool;


class Zip
{
    private $zip;
    private $zipPath;

    /**
     * Zip constructor.
     * @param $zipPath string 压缩文件存储路径
     */
    public function __construct($zipPath = "")
    {
        $this->init();
        $this -> zipPath = $zipPath;
    }

    /**
     * @title
     * @decribe 检查是否存在zip插件
     * @date 2021/1/5
     * @anthor mz
     */
    public function init(){
        if (!extension_loaded('zip')) {
            if (!dl('zip.so')) {
                exit("zip扩展不存在,请安装扩展后使用");
            }
        }
        $this -> zip = new \ZipArchive();
    }

    /**
     * @title importToZip
     * @decribe 添加文件到压缩包
     * @param $filePath string 待压缩文件地址
     * @param string $zipName 压缩文件名称
     * @return mixed
     * @throws \Exception
     * @date 2021/1/5
     * @anthor mz
     */
    public function zipFile($filePath,$zipName=""){
        try{
            if(!is_file($filePath)){
                throw new \Exception("压缩失败,待压缩文件不存在");
            }
            if(empty($zipName)){
                $filename = $this -> zipPath . '/' . mt_rand(1, 999999) .  md5(uniqid()) . '.zip';
            }else {
                $filename = $this -> zipPath . '/' . $zipName . '_' .mt_rand(1, 999999) . '.zip';
            }
            $flag = $this -> zip ->open($filename, \ZipArchive::CREATE);
            if($flag!==true){
                throw new \Exception("压缩失败");
            }
            $status = $this -> zip ->addFile($filePath,basename($filePath));
            $this ->zip-> close();
            return $status;
        }catch (\Exception $e){
            throw new \Exception($e -> getMessage());
        }
    }

    /**
     * @title zipFiles
     * @decribe 压缩多个文件
     * @param array $filePathArr 待压缩文件地址
     * @param string $zipName 压缩文件名
     * @return bool
     * @throws \Exception
     * @date 2021/1/5
     * @anthor mz
     */
    public function zipFiles($filePathArr = [],$zipName=""){
        try{
            $status = false;
            if(!is_array($filePathArr)){
                throw new \Exception("压缩失败,待压缩文件不存在");
            }
            if(empty($zipName)){
                $filename = $this -> zipPath . '/' . mt_rand(1, 999999) .  md5(uniqid()) . '.zip';
            }else {
                $filename = $this -> zipPath . '/' . $zipName . '_' .mt_rand(1, 999999) . '.zip';
            }
            $flag = $this -> zip ->open($filename, \ZipArchive::CREATE);
            if($flag!==true){
                throw new \Exception("压缩失败");
            }
            foreach ($filePathArr as $filePath){
                if(!is_file($filePath)){
                    throw new \Exception("压缩失败,待压缩文件不存在");
                }
                $status = $this -> zip ->addFile($filePath,basename($filePath));
            }
            $this ->zip-> close();
            return $status;
        }catch (\Exception $e){
            throw new \Exception($e -> getMessage());
        }
    }

    /**
     * @title unzip
     * @decribe 解压
     * @param $zipFullPath string 带解压文件路径
     * @param $outPath string 解压到目录地址
     * @return mixed
     * @throws \Exception
     * @date 2021/1/11
     * @anthor mz
     */
    public function unzip($zipFullPath,$outPath){
        try{
            if(!is_file($zipFullPath)){
                throw new \Exception("压缩失败,待解压缩文件不存在");
            }
            if(empty($outPath) || !is_dir($outPath)){
                $outPath = getcwd();
            }
            $flag = $this -> zip ->open($zipFullPath);
            if($flag!==true){
                throw new \Exception("解压缩失败");
            }
            $status = $this -> zip->extractTo($outPath);
            $this ->zip-> close();
            return $status;
        }catch (\Exception $e){
            throw new \Exception($e -> getMessage());
        }
    }

    /**
     * @title readZip
     * @decribe 读取压缩文件
     * @param $zipFullPath string 压缩文件文件地址
     * @return array
     * @throws \Exception
     * @date 2021/1/11
     * @anthor mz
     */
    public function readZip($zipFullPath){
        try{
            $flag = $this -> zip->open($zipFullPath);
            if($flag!==true){
                throw new \Exception("读取压缩文件失败");
            }

            $data = [];
            for($i=0;$i<$this -> zip->numFiles;$i++){
                $statInfo = $this -> zip->statIndex($i);
                array_push($data,$statInfo);
            }
            $this -> zip->close();
            return $data;
        }catch (\Exception $e){
            throw new \Exception($e -> getMessage());
        }
    }
}