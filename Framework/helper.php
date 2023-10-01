<?php

class Debug
{
    public static function d($data)
    {
        if (is_null($data)) {
            $str = '<i>NULL</i>';
        } elseif ($data == '') {
            $str = '<i>Empty</i>';
        } elseif (is_array($data)) {
            if (count($data) == 0) {
                $str = '<i>Empty array.</i>';
            } else {
                $str = '<table style="border-bottom:0px solid #000;" cellpadding="0" cellspacing="0">';
                foreach ($data as $key => $value) {
                    $str .= '<tr><td style="background-color:#008B8B; color:#FFF;border:1px solid #000;">'.$key.'</td><td style="border:1px solid #000;">'.Debug::d($value).'</td></tr>';
                }
                $str .= '</table>';
            }
        } elseif (is_resource($data)) {
            while ($arr = mysql_fetch_array($data)) {
                $data_array[] = $arr;
            }
            $str = Debug::d($data_array);
        } elseif (is_object($data)) {
            $str = Debug::d(get_object_vars($data));
        } elseif (is_bool($data)) {
            $str = '<i>'.($data ? 'True' : 'False').'</i>';
        } else {
            $str = $data;
            $str = preg_replace("/\n/", "<br>\n", $str);
        }

        return $str;
    }

    public static function dnl($data)
    {
        echo Debug::d($data).'<br>'.PHP_EOL;
    }

    public static function dd($data)
    {
        echo Debug::dnl($data);
        exit;
    }

    public static function ddt($message = '')
    {
        echo '['.date('Y/m/d H:i:s').']'.$message.'<br>'.PHP_EOL;
    }
}
