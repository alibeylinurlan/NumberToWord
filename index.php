<?php

//string olaraq daxil edin..
$eded = new NumberToWord;
echo $eded->turn('562652459689,88');


class NumberToWord
{

    public function teklikler_sinifi_oxunus($eded)
    {
        $teklik = [
            1 => "bir", 2 => "iki", 3 => "üç", 4 => "dört", 5 => "beş", 6 => "altı", 7 => "yeddi", 8 => "səkkiz", 9 => "doqquz",
        ];
        $onluq = [
            1 => "on", 2 => "iyirmi", 3 => "otuz", 4 => "qırx", 5 => "əlli", 6 => "altmış", 7 => "yetmiş", 8 => "səksən", 9 => "doxsan",
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

    public function turn($full)
    {
        //$full = "789,57";
        
        $eded = explode(',', $full)[0];
        $qepik = $this->teklikler_sinifi_oxunus(explode(',', $full)[1]);
        
        $eded_reverse = strrev($eded);
        $arr_reverse = str_split($eded_reverse, 3);
        $arr_not_element_order = array_reverse($arr_reverse);
        $arr_ucluk = [];

        foreach ($arr_not_element_order as $k => $value) {
            $arr_ucluk[] = strrev($value);
        }

        $sinif_sayi = count($arr_ucluk);
        $mertebe_sayi = strlen($eded);
        if ($mertebe_sayi > 12) 
            return '---';
      
        $ucluk_sayi = 0;
        $her_teklikler_oxunus = [];
        foreach ($arr_ucluk as $key => $ucluk) 
        {
            $her_teklikler_oxunus[] = $this->teklikler_sinifi_oxunus($ucluk);
        }
        
        if ($sinif_sayi == 1) 
            $realoxunus = $her_teklikler_oxunus[0];
        if ($sinif_sayi == 2) {
            if($her_teklikler_oxunus[0] == 'bir' )
                $minlik = '';
            else 
                $minlik = $her_teklikler_oxunus[0];
            $realoxunus = $minlik.' min '.$her_teklikler_oxunus[1];
        }
        if ($sinif_sayi == 3) 
            $realoxunus = $her_teklikler_oxunus[0].' milyon '.$her_teklikler_oxunus[1].' min '.$her_teklikler_oxunus[2];
        if ($sinif_sayi == 4) 
            $realoxunus = $her_teklikler_oxunus[0].' milyard '.$her_teklikler_oxunus[1].' milyon '.$her_teklikler_oxunus[2].' min '.$her_teklikler_oxunus[3];
        
        $realoxunus = str_replace('  ', ' ', $realoxunus)." manat, ".$qepik." qəpik";
        
        return $realoxunus;
    }
}
