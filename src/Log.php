<?php

namespace Laura\Lib\Base;


define('DEFAULT_LOG_LVL', 5);

define("DEFAULT_LOG_FOLDER", '/var/log/');

define('DEFAULT_APPLICATION_LOG', DEFAULT_LOG_FOLDER . 'application.log');
define('LOG_TYPE_APPLICATION', "LOG_TYPE_APPLICATION");

define('DEFAULT_DATABASE_LOG', DEFAULT_LOG_FOLDER . 'database.log');
define('LOG_TYPE_DATABASE', "LOG_TYPE_DATABASE");

define('DEFAULT_CRON_LOG', DEFAULT_LOG_FOLDER . 'cron.log');
define('LOG_TYPE_CRON', 'LOG_TYPE_CRON');

define('DEFAULT_ACCESS_LOG', DEFAULT_LOG_FOLDER . 'access.log');
define('LOG_TYPE_ACCESS', 'LOG_TYPE_ACCESS');


class Log
{

    public static function debug($message, $type = LOG_TYPE_APPLICATION)
    {
        $log_level = _global('log_level', DEFAULT_LOG_LVL);
        if ($log_level >= 5) {
            Log::write($message, 5, $type);
        }
    }

    public static function info($message, $type = LOG_TYPE_APPLICATION)
    {
        $log_level = _global('log_level', DEFAULT_LOG_LVL);
        if ($log_level >= 4) {
            Log::write($message, 4, $type);
        }
    }

    public static function warn($message, $type = LOG_TYPE_APPLICATION)
    {
        $log_level = _global('log_level', DEFAULT_LOG_LVL);
        if ($log_level = 3) {
            Log::write($message, 3, $type);
        }
    }

    public static function error($message, $type = LOG_TYPE_APPLICATION)
    {
        $log_level = _global('log_level', DEFAULT_LOG_LVL);
        if ($log_level >= 2) {
            Log::write($message, 2, $type);
        }
    }

    public static function fatal($message, $type = LOG_TYPE_APPLICATION)
    {
        $log_level = _global('log_level', DEFAULT_LOG_LVL);
        if ($log_level >= 1) {
            Log::write($message, 1, $type);
        }
    }


    private static function write($message, $level = 5, $type = LOG_TYPE_APPLICATION)
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }

        if (!defined($type)) {
            $output_file = _global('log_file', DEFAULT_APPLICATION_LOG);
        } else {
            $logType = strtoupper(str_replace("LOG_TYPE_", "", $type));
            $fileLocation = "DEFAULT_{$logType}_LOG";
            $lowerLogType = strtolower($logType);
            $output_file = _global("{$lowerLogType}_file", constant($fileLocation));
            if (!$output_file)
                $output_file = _global('log_file', DEFAULT_APPLICATION_LOG);
        }

        switch ($level) {
            case 4:
                $sLevel = "INFO - ";
                break;
            case 3:
                $sLevel = "WARN - ";
                break;
            case 2:
                $sLevel = "ERROR - ";
                break;
            case 1:
                $sLevel = "FATAL - ";
                break;
            case 5:
                $sLevel = "DEBUG - ";
                break;
            default:
                $sLevel = '';
                break;
        }

        if (isset($output_file) && !empty($output_file)) {
            $log = fopen($output_file, 'a');
            fwrite($log, '[' . date('Y-m-d H:i:s') . '] ' . $sLevel . $message . PHP_EOL);
            fclose($log);
        } else {
            error_log($message);
        }
    }


}
