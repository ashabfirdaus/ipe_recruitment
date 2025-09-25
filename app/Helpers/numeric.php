<?php

function resetNumberFormat($number = 0)
{
    if ($number == '' || $number == null) {
        $number = 0;
    }

    return preg_replace('/\,/', '', $number);
}

function handleComa($number)
{
    if (! $number) {
        return '0';
    }

    $split = explode('.', $number);
    if (count($split) > 1) {
        $reverse = (int) strrev($split[1]);
        $normal  = strrev((string) $reverse);
        if ($normal > 0) {
            $split[1] = $normal;
        } else {
            unset($split[1]);
        }
    }

    return implode('.', $split);
}

function formatNumber($number, $prefix = 0, $showDdecimal = false)
{
    $number  = number_format($number, 4, ',', '.');
    $explode = explode(',', $number);
    $koma    = '';
    if (count($explode) > 1) {
        $reverse = (int) strrev($explode[1]);
        $koma    = (string) $reverse > 0 ? strrev($reverse) : '';
    }

    if ($prefix > 0) {
        if (strlen($koma) < $prefix) {
            $sisa = $prefix - strlen($koma);
            if ($showDdecimal) {
                for ($i = 0; $i < $sisa; $i++) {
                    $koma .= '0';
                }
            }
        } else {
            $newNumber = normalizeNumber($explode[0]) . '.' . $koma;
            return number_format($newNumber, $prefix, ',', '.');
        }
    } else {
        $number = normalizeNumber($number);
        return number_format($number, '0', ',', '.');
    }

    if ($koma != '') {
        $koma = ',' . $koma;
    }

    return $explode[0] . $koma;
}

function normalizeNumber($number = 0)
{
    if (strpos($number, ',')) {
        $number = str_replace(',', '.', str_replace('.', '', $number));
    } else {
        $number = str_replace('.', '', $number);
    }

    return $number;
}

function handleNull($number)
{
    return $number ? $number : 0;
}

function terbilang($x)
{
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($x < 12) {
        return " " . $angka[$x];
    } elseif ($x < 20) {
        return terbilang($x - 10) . " belas";
    } elseif ($x < 100) {
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    } elseif ($x < 200) {
        return "seratus" . terbilang($x - 100);
    } elseif ($x < 1000) {
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    } elseif ($x < 2000) {
        return "seribu" . terbilang($x - 1000);
    } elseif ($x < 1000000) {
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    } elseif ($x < 1000000000) {
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    }
}
