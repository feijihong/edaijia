<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/17
 * Time: 10:25
 */

require __DIR__ . '/../src/Edaijia.php';
$obj = \Edaijia\Edaijia::getInstance();
if($obj instanceof \Edaijia\Edaijia){
    echo '<pre>';
    $list = $obj->getAllBusinessList(); var_dump ($list);
    //$list = $obj->getBalance(); var_dump ($list);
    //$list = $obj->queryCityList(); var_dump ($list);
    //$list = $obj->queryCity(1); var_dump ($list);
    //$list = $obj->price(113.3760762418,23.1370199833,113.3247710000,23.1278790000,'20170318120000'); var_dump ($list);
    //$list = $obj->order( 1,1,'15820232489','15820232489','金水', '金水','15820232489','广州市天河区荷光路自编190号',113.3760762418,23.1370199833, '麻花','15820232480','广州市天河区黄埔大道159-163号',113.3247710000,23.1278790000,  '20170318120000','粤A999ZZ'); var_dump ($list);
    //$list = $obj->cancel( 20170314758); var_dump ($list);
    //$list = $obj->detail( 20170314758); var_dump ($list);
    //$list = $obj->recordList( 33483); var_dump ($list);
    //$list = $obj->trace( 33483); var_dump ($list);
    //$list = $obj->driverInfo( 33483); var_dump ($list);
    //$list = $obj->verifyCode( 33483); var_dump ($list);
}