<?php
/**
 * @title Uzip
 * @decribe ...
 * @date 2021/1/5
 * @anthor mz
 */

namespace Cooly\Tool;


class Jwt
{
    /**
     * @name header
     * @decribe  jwt 头
     * @var array
     * @date 2021/1/5
     * @anthor mz
     */
    private static $header = [
        "alg" => "HS256",
        "typ" => "JWT",
    ];

    /**
     * @title 获取jwt token
     * @decribe ...
     * @param array $payload
     * @return bool|string
     * @date 2020/12/28
     * @anthor mz
     */
    public static function getToken($payload)
    {

        if(is_array($payload))
        {
            $base64header=self::base64UrlEncode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
            $base64payload=self::base64UrlEncode(json_encode($payload,JSON_UNESCAPED_UNICODE));
            $token=$base64header.'.'.$base64payload.'.'.self::signature($base64header.'.'.$base64payload,env("JWT_KEY"),self::$header['alg']);
            return $token;
        }else{
            return false;
        }
    }

    /**
     * @title 验证token是否有效,默认验证exp,nbf,iat时间
     * @decribe ...
     * @param $Token
     * @return bool|mixed
     * @date 2020/12/28
     * @anthor mz
     */
    public static function verifyToken( $Token)
    {
        $tokens = explode('.', $Token);
        if (count($tokens) != 3)
            return false;
        list($base64header, $base64payload, $sign) = $tokens;
        //获取jwt算法
        $base64decodeheader = json_decode(self::base64UrlDecode($base64header), JSON_OBJECT_AS_ARRAY);
        if (empty($base64decodeheader['alg']))
            return false;
        //签名验证
        if (self::signature($base64header . '.' . $base64payload, env("JWT_KEY"), $base64decodeheader['alg']) !== $sign)
            return false;
        $payload = json_decode(self::base64UrlDecode($base64payload), JSON_OBJECT_AS_ARRAY);
        //签发时间大于当前服务器时间验证失败
        if (isset($payload['iat']) && $payload['iat'] > time())
            return false;
        //过期时间小于当前服务器时间验证失败
        if (isset($payload['exp']) && $payload['exp'] < time())
            return false;
        //该nbf时间之前不接收处理该Token
        if (isset($payload['nbf']) && $payload['nbf'] > time())
            return false;
        return $payload;
    }


    /**
     * @title Base64 加密
     * @decribe ...
     * @param $input
     * @return mixed
     * @date 2020/12/28
     * @anthor mz
     */
    private static function Base64UrlEncode($input){
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * @title base64解密
     * @decribe ...
     * @param string $input
     * @return bool|string
     * @date 2020/12/28
     * @anthor mz
     */
    private static function base64UrlDecode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * @title 签名
     * @decribe ...
     * @param string $input
     * @param string $key
     * @param string $alg
     * @return mixed
     * @date 2020/12/28
     * @anthor mz
     */
    private static function signature( $input,  $key,  $alg = 'HS256')
    {
        $alg_config=array(
            'HS256'=>'sha256'
        );
        return self::base64UrlEncode(hash_hmac($alg_config[$alg], $input, $key,true));
    }
}