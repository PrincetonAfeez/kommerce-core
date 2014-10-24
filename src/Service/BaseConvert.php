<?php
namespace inklabs\kommerce\Service;

class BaseConvert
{
    private static $encodeBase = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function decode($num, $base = null)
    {
        if ($base === null) {
            $base = static::$encodeBase;
        }

        $b = strlen($base);
        $limit = strlen($num);
        $res = strpos($base, $num[0]);

        for ($i=1; $i < $limit; $i++) {
            $res = $b * $res + strpos($base, $num[$i]);
        }

        return (int) $res;
    }

    public static function encode($origNum, $base = null)
    {
        if ($base === null) {
            $base = static::$encodeBase;
        }

        $b = strlen($base);
        $res = '';
        $num = $origNum;

        do {
            $r = $num % $b;
            $num = floor($num / $b);
            $res = $base[$r] . $res;
        } while ($num);

        return $res;
    }
}