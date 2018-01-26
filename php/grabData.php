<?php
//规定错误报告
error_reporting(E_ERROR);
//引入自动加载文件
require 'QueryList/vendor/autoload.php';
use QL\QueryList;

//执行
timingTask();


function timingTask(){
    // ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
    // set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
    add();
    getIos();
}

//采集教程\资源数据
function getData($url=''){

    $url =$url?$url:'http://10.0.0.170/cheguanjia/';
    $rules = array(
        'name' => array('a', 'text'),

        'link' => array('a', 'href'),

        'date' => array('pre', 'text', '-a,-br'),
    );

    $hj = QueryList::Query($url,$rules);
    $data=$hj->data;
//     var_dump($data);die;
    $date = current($data)['date'];
    preg_match_all('/(\d){4}年(\d){1,2}月(\d){1,2}日/', $date, $matches);
    $dateAll = $matches[0];
    $data = array_splice($data,1);
    foreach ($data as $k => $v) {
        $data[$k]['date'] = $dateAll[$k];
    }

    foreach ($data as $key => $value) {
        $value['link']='http://10.0.0.170'.$value['link'];
        $data[$key]['link']=$value['link'];
        if (substr($value['link'], -1) == '/') {
            $dir_url=$value['link'];
            $data[$key]['is_dir'] =getData($dir_url);
        }
    }
    return $data;
}

 //把采集教程\资源数据生成文件
function add(){
    $data=getData();
    foreach($data as $value){
        if('集团管理系统'==$value['name']){
            $data['jt_admin']=$value['is_dir'][0];
        }
    }
    $dataList = array('data'=>$data,'time'=>time());
    file_put_contents('../json/file.json', json_encode($dataList,JSON_UNESCAPED_SLASHES));
}


//采集IOS版数据
function getIos(){
    $app_url="http://www.pgyer.com/hxqc";
    //采集某页面的图片
    $rules = array(
        'imgurl' => array('.content img','src'),
        'name'  =>array('.caption a','text'),
        'href'  =>array('.caption a','href'),

    );

    $hj = QueryList::Query($app_url,$rules);
    $data=$hj->data;
    $num= count($data)-1;
    //二维码图片
    $qrCode='http://www.pgyer.com/'.$data[$num]['imgurl'];
    unset($data[$num]);
    $array['app']=$data;
    $array['qrCode']=$qrCode;
    //生成文件
    $appList = array('data'=>$array,'time'=>time());
    file_put_contents('../json/app.json', json_encode($appList,JSON_UNESCAPED_SLASHES));

}



function read($name = 'tmp')
{
    if(!file_exists($name.".json")){
        return 0;
    }
    $myfile = fopen($name.".json", "r") or die("Unable to open file!");
    $re = fread($myfile,filesize($name.".json"));
    $re = json_decode($re, true);
    if($re['time']<time()){
        return 0;
    }
    return $re['data'];
    fclose($myfile);
}
// print_r(read('json'));