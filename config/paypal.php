<?php

$isSandbox = true;


if($isSandbox ) {
   return [
            'mode' => 'sandbox' ,
            'acct1.UserName' => 'tomdavison12-facilitator_api1.GMAIL.COM',
            'acct1.Password' => '1407273512',
            'acct1.Signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AdZk1eAfDJHq-PVtBZOZs7GxaJmQ',
           'client_id' => 'ATeeU2SGK4wcET_74M3WD3tNlFsFJe-A-xO6IratL1NwmyPkMDFYkfAXOVIloaiSE0j59-KEV3xuPtBZ',
           'secret' => 'ELci-FmgrpM79B17RV73az6o87mavcs8FebhNfavwpJVCTWjXvqa2htWHHHHJ_EbHzgdK7umwr8yaCaC'
        ];
} else {

    return [
                'mode' => 'live',
                'acct1.UserName' => 'leebodyjg_api1.hotmail.com',
                'acct1.Password' => '29GZ9YPAEATF726V',
                'acct1.Signature' => 'A5zSOP2UWh-NR7FkBVD37hZR5myfAE935GAFRm83WJngbtXPIXytA5lJ'
            ];


}
