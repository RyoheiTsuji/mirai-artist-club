<?php

namespace App\Helpers;

class Zodiac
{
    public static function getZodiacSign($date)
    {
        $month = date('n', strtotime($date));
        $day = date('j', strtotime($date));

        if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) {
            return '水瓶座'; // Aquarius
        } elseif (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) {
            return '魚座'; // Pisces
        } elseif (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) {
            return '牡羊座'; // Aries
        } elseif (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) {
            return '牡牛座'; // Taurus
        } elseif (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) {
            return '双子座'; // Gemini
        } elseif (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) {
            return '蟹座'; // Cancer
        } elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
            return '獅子座'; // Leo
        } elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
            return '乙女座'; // Virgo
        } elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
            return '天秤座'; // Libra
        } elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
            return '蠍座'; // Scorpio
        } elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
            return '射手座'; // Sagittarius
        } else {
            return '山羊座'; // Capricorn
        }
    }
}
