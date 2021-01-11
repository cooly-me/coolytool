<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 10:52
 */
require  "../../vendor/autoload.php";

use Cooly\Tool\Zip;

$hello = new Zip("WWW\coolytool\src\\example");
try{
    $status = $hello -> readZip("D:\soft\phpstudy_pro\WWW\coolytool\src\\example\\745285cbec06bc20219520d798727092b12079.zip");
    var_dump($status);
}catch (\Exception $e){
    var_dump($e -> getMessage());
}
