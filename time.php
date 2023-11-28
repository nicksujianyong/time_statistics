<?php 

$date = '2023-11-20';
$app_package = 'com.hh.zyos';

for ($i=0; $i < 24; $i++) {
    $name = 'hour'.$i;
    $$name = strtotime($date.$i.':00:00');
}

for ($i=0; $i < 24; $i++) { 
    $timeInterval[$i.':00'] = 'hour'.$i;
}

$res = [];
$timeInterval_num = 0;
foreach ($timeInterval as $ks => $vs) {

    $t1 = $$vs;
    $t2 = $t1 + 3600;
    if(!isset($res[$ks])){
        $res[$ks] = 0;
    }

    $app_use_log_arr = DB::table('app_use_log')->where(['app_package'=>$app_package])->where('open_time','>=',$t1)->where('open_time','<',$t2)->get(['open_time','close_time','usage_time']);

    if(count($app_use_log_arr)){

        foreach ($app_use_log_arr as $var) {

            if($var['close_time'] > $t2){

                $newvs = $t2;
                $usage_time_new = $newvs-$var['open_time'];
                $res[$ks] += $usage_time_new;
                
                $newvs_num = 1;
                while($newvs<$var['close_time']){

                    $nt = $newvs_num+$timeInterval_num;
                    if($nt == 24){
                        break;
                    }
                    if($var['close_time'] < ($newvs+3600)){
                        $usage_time_new = $var['close_time']-$newvs;
                    }else{
                        $usage_time_new = 3600;
                    }
                    if(!isset($res[$nt.':00'])){
                        $res[$nt.':00'] = 0;
                    }
                    $res[$nt.':00'] += $usage_time_new;
                    $newvs = $newvs+3600;
                    $newvs_num++;

                }

            }else{
                $res[$ks] += $var['usage_time'];
            }

        }

    }

    $timeInterval_num++;

}


$app_use_log_arr_before = DB::table('app_use_log')->where(['app_package'=>$app_package])->where('open_time','<',$hour0)->where('close_time','>',$hour0)->first(['open_time','close_time','usage_time']);

if(!empty($app_use_log_arr_before)){

    if($app_use_log_arr_before['close_time'] > $hour1){

        $newvs = $hour1;
        $res['0:00'] += 3600;
        
        $nt = 1;
        while($newvs<$app_use_log_arr_before['close_time']){

            if($nt == 24){
                break;
            }
            if($app_use_log_arr_before['close_time'] < ($newvs+3600)){
                $usage_time_new = $app_use_log_arr_before['close_time']-$newvs;
            }else{
                $usage_time_new = 3600;
            }
            if(!isset($res[$nt.':00'])){
                $res[$nt.':00'] = 0;
            }
            $res[$nt.':00'] += $usage_time_new;
            $newvs = $newvs+3600;
            $nt++;

        }

    }else{
        $usage_time_new = $app_use_log_arr_before['close_time']-$hour0;
        $res['0:00'] += $usage_time_new;
    }

}


var_dump(json_encode($res));
