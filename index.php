<?php
/*
 * Məntiq: bütün ədədlər 3-3 qruplasmalardan yaranır. Məsələn 456789 ədədi 456 və 789 un birləşməsidir.
 * birləşmə sayı artıqca hər artışın öz sinif adını əlavə edirik. 456 nın sinif adı 'min' -dir.
 * 789 un sinif adı yoxdur. Digər misal 75395476 ədədi 75, 395, 476 nın birləşməsidir.
 * Oxunusu yazarkən hər birini normal qaydada oxuduruq və yanına sinif adını yazırıq.
 * 75 in sinif adı 'milyon', 395 in sinifi 'min', 456 nin sinifi isə yoxdur. Nəticədə oxunus belə olacaq.
 *
 * yetmiş beş MİLYON üç yüz doxsan beş MİN dört yüz yetmiş altı
 *
 * Gördüyünüz kimi hər 3lüyü oxudub yanına öz sinifini yazırıq. Kodlar bu məntiq üzərinə qurulub
 *
 */

class NumberToWord
{
    public function turn($umumi_eded)
    {
        $eded = round($umumi_eded);

        $eded_reverse = strrev($eded);// tersine cevirir ki 3lukleri duzgun ayiraq
        $arr_reverse = str_split($eded_reverse, 3); // 3luklere ayrildi
        $arr_element_not_order = array_reverse($arr_reverse); //her 3lukde reqemler tersdi

        $arr_ucluk = [];

        foreach ($arr_element_not_order as $k => $value) { // 3lukdeki ters cevrilmis  reqemleri duzeldir
            $arr_ucluk[] = strrev($value);
        }

        if (strlen($eded) > 18)  return '---';

        $sinifler_adlar = ['', 'min', 'milyon', 'milyard', 'trilyon', 'quadrillion'];

        $arr_ucluk_reverse = array_reverse($arr_ucluk); //ters ceviririk ki sinif adlari ile ugunlasdira bilek,

        $sinifler_adlar_uygun = array_slice($sinifler_adlar, 0, count($arr_ucluk));

        $oxunus = [];

        for ($i = count($arr_ucluk)-1; $i >= 0; $i--)
        {
            $sinif_adi = $arr_ucluk_reverse[$i] == '000' ? '' : ' '.$sinifler_adlar_uygun[$i].' ';
            $oxunus[] = $this->teklikler_sinifi_oxunus($arr_ucluk_reverse[$i]).$sinif_adi;
        }

        $oxunus = str_replace('  ', ' ', trim(implode('', $oxunus)));
        return $oxunus;
    }

    public function teklikler_sinifi_oxunus($eded)//herbir 3luyu oxutmaq ucun
    {
        if ($eded === "000") //siniflik yoxdursa adini yazmasin
            return '';

        if ($eded[0] == 0)
            $eded = $this->delete_first_zero($eded);

        $teklik = [
            0 => "", 1 => "bir", 2 => "iki", 3 => "üç", 4 => "dört", 5 => "beş", 6 => "altı", 7 => "yeddi", 8 => "səkkiz", 9 => "doqquz",
        ];

        $onluq = [
            0 => "", 1 => "on", 2 => "iyirmi", 3 => "otuz", 4 => "qırx", 5 => "əlli", 6 => "altmış", 7 => "yetmiş", 8 => "səksən", 9 => "doxsan",
        ];

        $teklikler_sinifi_say = strlen($eded);
        $teklikler_sinifi_arr = str_split($eded);
        if($teklikler_sinifi_say == 1)
            $teklikler_sinifi_oxunus = $teklik[$teklikler_sinifi_arr[0]];
        if($teklikler_sinifi_say == 2)
            $teklikler_sinifi_oxunus = $onluq[$teklikler_sinifi_arr[0]].' '.$teklik[$teklikler_sinifi_arr[1]];
        if($teklikler_sinifi_say == 3)
        {
            $yuzluk = $teklik[$teklikler_sinifi_arr[0]] == 'bir' ? '' : $teklik[$teklikler_sinifi_arr[0]];
            $teklikler_sinifi_oxunus = $yuzluk.' yüz '.$onluq[$teklikler_sinifi_arr[1]].' '.$teklik[$teklikler_sinifi_arr[2]];
        }
        return $teklikler_sinifi_oxunus;
    }

    public function delete_first_zero($eded)//qepik hissede eded sifirla baslayarsa
    {
        $eded_new = substr($eded, 1);

        if ($eded_new[0] == 0) $eded_new = $this->delete_first_zero($eded_new);

        return $eded_new;
    }
}
//$toword = new NumberToWord();
//$eded_soz = $toword->turn(5555);
