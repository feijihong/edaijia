<?php

namespace Edaijia;

class Edaijia
{
    //渠道号
    private $channel;
    //商户ID
    private $customerId;
    //私钥
    private $privateKey;

    private $prefixApi = 'https://baoyang.d.edaijia.cn/api/third/2/';

    private static $instance = null;

    private function __construct($config)
    {
        $this->channel = $config['channel'];
        $this->customerId = $config['customerId'];
        $this->privateKey = $config['privateKey'];
    }

    /**
     * @param null $config
     * @return Edaijia
     */
    public static function getInstance($config = null)
    {

        if (is_null($config)) {
            if (is_null(self::$instance)) {
                $config = require __DIR__ . '/config.php';
                self::$instance = new self($config);
            }
        } else {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function curlGet($url, $time = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    private function postGet($url, $data, $raw = true, $time = 3)
    {
        $data = $raw ? rawurldecode(http_build_query($data)) : http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

    /**
     * 获取签名
     * @param $param
     * @return string
     */
    private function getSign($param)
    {
        ksort($param);
        $str = '';
        foreach ($param as $key => $val) {
            $str .= $key . '=' . $val;
        }
        $strone = md5($str);
        $strtwo = md5($strone . $this->privateKey);
        return $strtwo;
    }

    /**
     * 组装接口地址
     * @param $api
     * @param $param
     * @param bool $raw
     * @return string
     */
    private function getUrl($api, $param, $raw = true)
    {
        $param['sign'] = $this->getSign($param);
        $query = $raw ? rawurldecode(http_build_query($param)) : http_build_query($param);
        return $api . '?' . $query;
    }

    /**
     * @param $ret
     * @return mixed|null
     */
    private function getResponseData($ret)
    {
        $ret = json_decode($ret, true);
        if (is_array($ret) && $ret['code'] === 0) {
            return $ret['data'];
        }
        return null;
    }

    /**
     * 获取渠道下所有的商户列表
     * @return mixed|null
     */
    public function getAllBusinessList()
    {
        $api = $this->prefixApi . 'business/listAll';
        $param = array('channel' => $this->channel);
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        return $this->getResponseData($ret);
    }

    /**
     * 获取商户的账号余额
     * @return mixed|null
     */
    public function getBalance()
    {
        $api = $this->prefixApi . 'business/balance';
        $param = array('channel' => $this->channel, 'customerId' => $this->customerId);
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);

        return $this->getResponseData($ret);
    }

    /**
     * 3.3    获取服务支持城市列表
     * @return mixed|null
     */
    public function queryCityList()
    {
        $api = $this->prefixApi . 'queryCityList';
        $param = array('channel' => $this->channel);
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);

        return $this->getResponseData($ret);
    }

    /**
     * 3.4    根据城市code获取城市信息
     * @param $code 城市编码
     * @return mixed|null
     */
    public function queryCity($code)
    {
        $api = $this->prefixApi . 'queryCity';
        $param = array('channel' => $this->channel, 'code' => $code);
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);

        return $this->getResponseData($ret);
    }

    /**
     * 3.5    获取预估价格
     * @param $startLng 出发地经度
     * @param $startLat 出发地纬度
     * @param $endLng 目的地经度
     * @param $endLat 目的地纬度
     * @param $bookingTime 预约时间
     * @return mixed|null
     */
    public function price($startLng, $startLat, $endLng, $endLat, $bookingTime)
    {
        $api = $this->prefixApi . 'price';
        $param = array(
            'channel' => $this->channel,
            'customerId' => $this->customerId,
            'startLng' => $startLng,
            'startLat' => $startLat,
            'endLng' => $endLng,
            'endLat' => $endLat,
            'bookingTime' => $bookingTime,
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);

        return $this->getResponseData($ret);
    }

    /**
     * 3.6    下单
     * @param $type
     * @param $mode
     * @param $createMobile
     * @param $mobile
     * @param $username
     * @param $pickupContactName
     * @param $pickupContactPhone
     * @param $pickupAddress
     * @param $pickupAddressLng
     * @param $pickupAddressLat
     * @param $returnContactName
     * @param $returnContactPhone
     * @param $returnAddress
     * @param $returnAddressLng
     * @param $returnAddressLat
     * @param $bookingTime
     * @param $carNo
     * @param string $carBrandName
     * @param string $carSeriesName
     * @return mixed|null
     */
    public function order(
        $type,
        $mode,
        $createMobile,
        $mobile,
        $username,
        $pickupContactName,
        $pickupContactPhone,
        $pickupAddress,
        $pickupAddressLng,
        $pickupAddressLat,
        $returnContactName,
        $returnContactPhone,
        $returnAddress,
        $returnAddressLng,
        $returnAddressLat,
        $bookingTime,
        $carNo,
        $carBrandName = '',
        $carSeriesName = ''
    ) {
        $api = $this->prefixApi . 'order/create';
        $param = array(
            'channel' => $this->channel,
            'customerId' => $this->customerId,
            'type' => $type,
            'mode' => $mode,
            'createMobile' => $createMobile,
            'mobile' => $mobile,
            'username' => $username,
            'pickupContactName' => $pickupContactName,
            'pickupContactPhone' => $pickupContactPhone,
            'pickupAddress' => $pickupAddress,
            'pickupAddressLng' => $pickupAddressLng,
            'pickupAddressLat' => $pickupAddressLat,
            'returnContactName' => $returnContactName,
            'returnContactPhone' => $returnContactPhone,
            'returnAddress' => $returnAddress,
            'returnAddressLng' => $returnAddressLng,
            'returnAddressLat' => $returnAddressLat,
            'bookingTime' => $bookingTime,
            'carNo' => $carNo,
            'carBrandName' => $carBrandName,
            'carSeriesName' => $carSeriesName,
        );
        $param['sign'] = $this->getSign($param);
        $ret = $this->postGet($api, $param);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.7    取消订单
     * @param $orderId
     * @return mixed|null
     */
    public function cancel($orderId)
    {
        $api = $this->prefixApi . 'order/cancel';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId
        );
        $param['sign'] = $this->getSign($param);
        $ret = $this->postGet($api, $param);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.8    获取订单详情
     * @param $orderId
     * @return mixed|null
     */
    public function detail($orderId)
    {
        $api = $this->prefixApi . 'order/detail';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.9    获取订单轨迹
     * @param $orderId
     * @return mixed|null
     */
    public function recordList($orderId)
    {
        $api = $this->prefixApi . 'order/recordList';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }


    /**
     * 3.10    获取司机代驾轨迹
     * @param $orderId
     * @param int $type
     * @return mixed|null
     */
    public function trace($orderId, $type = 1)
    {
        $api = $this->prefixApi . 'order/trace';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId,
            'type' => $type
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.11    获取司机信息
     * @param $orderId
     * @param int $type
     * @return mixed|null
     */
    public function driverInfo($orderId, $type = 1)
    {
        $api = $this->prefixApi . 'order/driverInfo';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId,
            'type' => $type
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.12	获取目的人收车验证码
     * @param $orderId
     * @param int $type
     * @return mixed|null
     */
    public function verifyCode($orderId, $type = 1)
    {
        $api = $this->prefixApi . 'order/verifyCode';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId,
            'type' => $type
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.13	获取历史订单列表
     * @param string $startDate
     * @param string $endDate
     * @param int $pageSize
     * @param int $currentPage
     * @param string $mobile
     * @param string $createMobile
     * @param string $customerId
     * @return mixed|null
     */
    public function queryList($startDate='', $endDate='',$pageSize=20,$currentPage=1,$mobile='',$createMobile='',$customerId='')
    {
        $api = $this->prefixApi . 'order/queryList';
        $param = array(
            'channel' => $this->channel,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
            'mobile' => $mobile,
            'createMobile' => $createMobile,
            'customerId'=>$customerId
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.14	用户评论
     * @param $orderId
     * @param $attitude
     * @param $speed
     * @param $content
     * @return mixed|null
     */
    public function comment($orderId,$attitude,$speed,$content)
    {
        $api = $this->prefixApi . 'order/comment';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId,
            'attitude' => $attitude,
            'speed' => $speed,
            'content' => $content
        );
        $param['sign'] = $this->getSign($param);
        $ret = $this->postGet($api, $param);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 3.15	获取用户评论内容
     * @param $orderId
     * @return mixed|null
     */
    public function getComment($orderId)
    {
        $api = $this->prefixApi . 'order/getComment';
        $param = array(
            'channel' => $this->channel,
            'orderId' => $orderId
        );
        $url = $this->getUrl($api, $param);
        $ret = $this->curlGet($url);
        //var_dump($ret);
        return $this->getResponseData($ret);
    }

    /**
     * 验证回调签名是否正确
     * @param $param
     * @return bool
     */
    public function checkSign($param)
    {
        ksort($param);
        $str = '';
        $sign = '';
        foreach ($param as $key => $val) {
            if($key ==='sign'){
                $sign = $val;
                continue;
            }
            $str .= $key . '=' . $val;
        }
        $strone = md5($str);
        $strtwo = md5($strone . $this->privateKey);
        return $strtwo === $sign;
    }

}