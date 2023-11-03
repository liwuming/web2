<?php
    $basepath = dirname($_SERVER['REQUEST_URI']);

    $uploadfile = 'uploadfile';
    if(!empty($_FILES) && array_key_exists($uploadfile,$_FILES)){
        $reg = '/\.([a-z]+)$/si';
        preg_match($reg,$_FILES[$uploadfile]['name'],$result);
        if(empty($result)){

        }

        $suffix = strtolower($result[1]);
        switch($suffix){
            case 'png':
            case 'jpeg':
                $filename = get_unique().'.'.$suffix;


                $path = '/uploads/'.date('Ymd',time()).'/';
                if(!file_exists(__DIR__. $path)){
                    mkdir(__DIR__. $path,755,true);
                }
                // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                $result = move_uploaded_file($_FILES[$uploadfile]["tmp_name"], __DIR__.$path.$filename);
                if($result){
                    die(json_encode(array('code'=>200,'src'=>$basepath.'/'.$path.$filename)));
                }else{
                    die(json_encode(array('code'=>100,'msg'=>'失败')));
                }
            default:
                
                break;
        }
}
function get_unique(){
    $unixtime_md5 = substr(md5(time()),0,10);
    $random = mt_rand(100000,999999);
    return $unixtime_md5.$random;
}