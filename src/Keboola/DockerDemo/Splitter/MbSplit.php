<?php

namespace Keboola\DockerDemo\Splitter;

class MbSplit
{

    /**
     * @param $string
     * @param int $maxLength
     * @return array
     */
    public static function split($string, $maxLength = 0)
    {
        if ($maxLength > 0) {
            $ret = array();
            $len = mb_strlen($string, "UTF-8");
            for ($i = 0; $i < $len; $i += $maxLength) {
                $ret[] = mb_substr($string, $i, $maxLength, "UTF-8");
            }

            return $ret;
        }

        return preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);
    }
}
