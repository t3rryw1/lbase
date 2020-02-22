<?php

use Laura\Lib\Base\Log;

if (!function_exists("_global")) {
    function _global($val, $default = null)
    {
        return isset($GLOBALS[$val]) ? $GLOBALS[$val] : $default;
    }
}

if (!function_exists("_g")) {
    function _g($val, $default = null)
    {
        return _global($val, $default);
    }
}


if (!function_exists("__d")) {
    function __d(...$message)
    {
        $bt = debug_backtrace();

        $caller = array_shift($bt);

        $file = $caller['file'];
        $line = $caller['line'];

        $file = substr(strrchr($file, "/"), 1);

        $messageArray = [];
        for ($i = 0; $i < func_num_args(); $i++) {
            array_push($messageArray, __to_string($message[$i]));
        }

        Log::debug("[$file:$line] " . implode(", ", $messageArray));

    }
}
if (!function_exists("__t")) {
    function __t(...$message)
    {
        $bt = array_reverse(debug_backtrace());

        $callers = array_map(function ($caller) {
            $file = $caller['file'];
            $line = $caller['line'];

            $file = substr(strrchr($file, "/"), 1);
            return "$file:$line";
        }, $bt);

        $callerString = implode(" -> ", $callers);

        $messageArray = [];
        for ($i = 0; $i < func_num_args(); $i++) {
            array_push($messageArray, __to_string($message[$i]));
        }

        Log::debug("[$callerString] " . implode(", ", $messageArray));

    }
}
if (!function_exists("__debug")) {
    function __debug($message, $type = LOG_TYPE_APPLICATION)
    {
        Log::debug($message, $type);
    }
}


if (!function_exists("__info")) {
    function __info($message, $type = LOG_TYPE_APPLICATION)
    {
        Log::info($message, $type);
    }
}

if (!function_exists("__warn")) {
    function __warn($message, $type = LOG_TYPE_APPLICATION)
    {
        Log::warn($message, $type);
    }
}

if (!function_exists("__error")) {
    function __error($message, $type = LOG_TYPE_APPLICATION)
    {
        Log::error($message, $type);
    }
}

if (!function_exists("__fatal")) {
    function __fatal($message, $type = LOG_TYPE_APPLICATION)
    {
        Log::fatal($message, $type);
    }
}

if (!function_exists("__dump")) {
    function __dump(... $value)
    {
        $args = func_get_args();
        call_user_func_array("var_dump", $args);
        exit();
    }
}

if (!function_exists("__display")) {
    function __display(... $value)
    {
        $args = func_get_args();
        call_user_func_array("var_dump", $args);
    }
}


if (!function_exists('__to_array')) {
    function __to_array($data)
    {
        if (!is_array($data) && !is_object($data)) {
            return $data;
        }
        return json_decode(json_encode($data), true);
    }
}

if (!function_exists('__to_string')) {
    function __to_string($data)
    {
        if (!is_array($data) && !is_object($data)) {
            return (string)$data;
        }
        return json_encode($data);
    }
}

if (!function_exists('objectify')) {
    function objectify($val, ...$param)
    {
        if (is_object($val)) {
            return $val;
        }
        if (is_string($val) && class_exists($val))
            return new $val(...$param);
        return null;
    }
}

if (!function_exists("_decamelize")) {
    function _decamelize($input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }
}

if (!function_exists("_camelize")) {
    function _camelize($str, $capitalise_first_char = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        return preg_replace_callback('/_([a-z])/', function ($c) {
            return strtoupper($c[1]);
        }, $str);
    }

}
