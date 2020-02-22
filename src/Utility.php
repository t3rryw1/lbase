<?php

namespace Laura\Lib\Base;

class Utility
{
    public static function access($message)
    {
        $body = '{  "REMOTE_ADDR":"' . self::getServerParam('REMOTE_ADDR') .
            '", "HTTP_X_FORWARDED_FOR":"' . self::getServerParam('HTTP_X_FORWARDED_FOR') .
            '", "HTTP_CLIENT_IP":"' . self::getServerParam('HTTP_CLIENT_IP') .
            '", "REQUEST":"' . $message . '"  }';

        Log::write($body, 0, LOG_TYPE_ACCESS);

    }

    private static function getServerParam($paramName)
    {
        return (isset($_SERVER[$paramName]) ? $_SERVER[$paramName] : '');
    }

    public static function getJsonRequestData()
    {
        $rawData = file_get_contents('php://input');
        return json_decode($rawData, TRUE);
    }

    public static function getClientIp()
    {
        $head = apache_request_headers();
        $ip = (isset($head['CAIRYME_FORWARDED_IP']) ? $head['CAIRYME_FORWARDED_IP'] : '');

        if (empty($ip)) {
            $ip = (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '');
        }
        if (empty($ip)) {
            $ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '');
        }
        if (empty($ip)) {
            $ip = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }

        return $ip;
    }

    public static function generateToken($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public static function setLocaleCookie($locale)
    {
        $domain = _global('domain', 'localhost');
        setcookie('locale', $locale, time() + 31536000, '/', $domain);
    }


    public static function nullToEmptySpace($arr)
    {
        if (empty($arr)) return $arr;

        foreach ($arr as $key => $elem) {
            if (is_array($elem)) {
                $arr[$key] = self::nullToEmptySpace($elem);
            } else if (!isset($elem)) {
                $arr[$key] = "";
            }
        }

        return $arr;
    }

    public static function setResponseStatusCode($code)
    {
        switch ($code) {
            case 200:
                $text = 'OK';
                break;
            case 400:
                $text = 'Bad Request';
                break;
            case 401:
                $text = 'Unauthorized';
                break;
            case 402:
                $text = 'Payment Required';
                break;
            case 403:
                $text = 'Forbidden';
                break;
            case 404:
                $text = 'Not Found';
                break;
            case 405:
                $text = 'Method Not Allowed';
                break;
            case 406:
                $text = 'Not Acceptable';
                break;
            case 407:
                $text = 'Proxy Authentication Required';
                break;
            case 408:
                $text = 'Request Time-out';
                break;
            case 409:
                $text = 'Conflict';
                break;
            case 410:
                $text = 'Gone';
                break;
            case 411:
                $text = 'Length Required';
                break;
            case 412:
                $text = 'Precondition Failed';
                break;
            case 413:
                $text = 'Request Entity Too Large';
                break;
            case 414:
                $text = 'Request-URI Too Large';
                break;
            case 415:
                $text = 'Unsupported Media Type';
                break;
            case 503:
                $text = 'Service Unavailable';
                break;
            case 500:
            default:
                $text = 'Internal Server Error';
                break;
        }

        header('HTTP/1.0 ' . $code . ' ' . $text);
    }

}
