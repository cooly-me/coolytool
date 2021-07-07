<?php
/**
 * @title HttpClient
 * @decribe ...
 * @date 2021/3/1
 * @anthor mz
 */

namespace Cooly\Tool;


class HttpClient
{
    use singleton;
    /**
     * @title post
     * @decribe post 请求
     * @param $url
     * @param $data
     * @param int $timeout
     * @param array $headers
     * @param int $returnheader
     * @return bool|string
     * @date 2021/3/1
     * @anthor mz
     */
    function post($url, $data, $timeout = 3, $headers = array(), $returnheader = 1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, "http://" . explode('/', $url)[2] . "/");
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        if ($headers) {
            $headerArr = array();
            foreach ($headers as $n => $v) {
                $headerArr[] = $n . ':' . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
            curl_setopt($ch, CURLOPT_HEADER, $returnheader);
        } else {
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
        if (stripos($url, 'https://') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); //SSL证书认证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); //严格认证
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

}