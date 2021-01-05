<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 10:52
 */
require  "../../vendor/autoload.php";

use Cooly\Tool\Zip;

$hello = new Zip("D:\soft\phpstudy_pro\WWW\coolytool\src\\example");
try{
//    '\out.zip'
    $filePathArr = [
        "D:\soft\phpstudy_pro\WWW\coolytool\src\\example\\2.txt",
        "D:\soft\phpstudy_pro\WWW\coolytool\src\\example\\3.txt",
    ];
    $status = $hello -> zipFiles($filePathArr);
    var_dump($status);
}catch (\Exception $e){
    var_dump($e -> getMessage());
}
