e车管家取送车业务接口文档
1	修订记录
版本号	修订人	修订内容	修订时间
1.2	权文超	1.	修改按条件获取订单列表接口，增加司机工号和司机名称字段
2.	增加订单状态主动推送接口	2015-11-02
1.3	权文超	1.	增加获取服务支持城市列表接口
2.	增加根据城市code获取城市信息接口	2015-11-03
1.4	权文超	1.	修改获取订单详情以及获取历史订单列表接口	2015-11-09
1.5	权文超	1.	修改订单状态删除司机接车状态	2015-12-01
1.6	权文超	1.	删除多余接口:用户确认司机、还车获取验证码
2.	下单接口中删除userName和customerId
3.	删除接口中的多余参数orderType	2015-12-29
1.7	权文超	1.	增加还车获取验证码接口
2.	下单接口中增加车辆信息	2016-05-13
2.0Beta	权文超	1.	使用新的访问地址
2.	所有接口支持自定义定价	2016-10-11
2	合作方接入指南
2.1	e车管家提供的内容
值	说明	备注
channel	渠道号	测试环境和线上环境一样
customerId	商户id	测试环境和线上环境不一样
privateKey	私钥	测试环境和线上环境不一样
2.2	合作方提供的内容
值	说明	备注
主动通知地址	接收e车管家订单状态更新	测试环境和线上环境不一样
2.3	合作方测试渠道列表
合作方名称	渠道号	商户id	测试环境私钥
测试渠道	10	CH0110000223	a
2.4	取送车流程

2.5	接口签名规范
2.5.1	签名过程
1.	将所有传入参数(不包括sign字段)按照键值字典序由小到大排列
2.	按照key1=value1key2=values2方式拼接，没有分割符
3.	对拼接结果取一次md5，再将md5(小写)结果尾部拼接渠道的私钥内容
4.	将拼接结果再做一次md5获得签名
5.	签名以参数名sign传入
2.5.2	签名示例
传入参数：b=v2&a=v1&c=v3
排序后字符串：a=v1b=v2c=v3
md5后字符串：8ef1bd921d358a6db0f84ff1924bfb5c
md5拼上私钥后字符串：8ef1bd921d358a6db0f84ff1924bfb5ca
最终加密后字符串：0a915eca055e0c829f65ffd2b065cd84
最终传入参数：b=v2&a=v1&c=v3&sign=0a915eca055e0c829f65ffd2b065cd84
2.5.3	返回结果格式
所有返回结果都是JSON字符串，包括以下通用的域：
值	说明	备注
code	返回码	0-成功 非0-错误编码
message	返回码描述
data	数据域	不同接口返回不同的数据域
3	接口
3.1	获取渠道下所有的商户列表
3.1.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/business/listAll
3.1.2	HTTP请求方式
GET
3.1.3	传入参数
参数	说明	类型	是否必须	备注
channel	渠道号	Int	是
3.1.4	返回值
值	说明	备注
customerId	商户id
customerName	商户名称

{
    "code": 0,
    "message": "success",
    "data": [
        {
            "customerName": "第三方测试平台",
            "customerId": "CH0110000223"
        }
    ]
}
3.1.5	返回码描述
返回码	返回码描述	备注

3.2	获取商户的账号余额
3.2.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/business/balance
3.2.2	HTTP请求方式
GET
3.2.3	传入参数
参数	说明	类型	是否必须	备注
channel	渠道号	Int	是
customerId	商户id	String	是
3.2.4	返回值
值	说明	备注
data	余额

{
    "code": 0,
    "message": "success",
    "data": 99995595.99
}
3.2.5	返回码描述
返回码	返回码描述	备注
4005	没有权限获取该商户余额
3.3	获取服务支持城市列表
3.3.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/queryCityList
3.3.2	HTTP请求方式
GET
3.3.3	传入参数
参数	说明	类型	是否必须	备注
channel	渠道号	Int	是
3.3.4	返回值
值	说明	备注
code	城市编码
name	城市名称
isSupport	是否支持取送车	0-不支持 1-支持

{
    "code": 0,
    "message": "success",
    "data": [
        {
            "code": "1",
            "name": "北京",
            "isSupport": 1
        }
    ]
}
3.3.5	返回码描述
返回码	返回码描述	备注

3.4	根据城市code获取城市信息
3.4.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/queryCity
3.4.2	HTTP请求方式
GET
3.4.3	传入参数
参数	说明	类型	是否必须	备注
channel	渠道号	Int	是
code	城市编码	String	是
3.4.4	返回值
值	说明	备注
code	城市编码
name	城市名称
isSupport	是否支持取送车	0-不支持 1-支持

{
    "code": 0,
    "message": "success",
    "data": {
        "code": "1",
        "name": "北京",
        "isSupport": 1
    }
}
3.4.5	返回码描述
返回码	返回码描述	备注
3004	城市不存在
3.5	获取预估价格
3.5.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/price
3.5.2	HTTP请求方式
GET
3.5.3	传入参数
参数	说明	类型	是否必须	备注
channel	渠道号	Int	是
startLng	出发地经度	Double	是
startLat	出发地纬度	Double	是
endLng	目的地经度	Double	是
endLat	目的地纬度	Double	是
bookingTime	预约时间	String(yyyyMMddHHmmss)	是
customerId	商户id	String	是
3.5.4	返回值
值	说明	备注
distance	预估距离	单位公里
totalFee	预估价格	单位元
startFee	起步费用	单位元
overFee	超出费用	单位元

{
    "code": 0,
    "message": "success",
    "data": {
        "distance": 0.02,
        "totalFee": 50,
        "startFee": 50,
        "overFee": 0
    }
}
3.5.5	返回码描述
返回码	返回码描述	备注
4004	没有权限获取该商户价格
1003	预约时间不合法
3.6	下单
3.6.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/create
3.6.2	HTTP请求方式
POST
3.6.3	传入参数
参数	含义	类型	是否必须	备注
channel	渠道号	Int	是
customerId	商户id	String	是	最多20个字符
type	订单类型	Int	是	1-取送车
mode	订单成单模式	Int	是	1-司机抢单（订单所在城市预约开启时生效，否则为客服派单）
0-客服派单
createMobile	下单人手机号	String	是	手机号
mobile	车主手机号	String	是	手机号
username	车主姓名	String	是
pickupContactName	取车地址联系人姓名	String	是	最多20个字符
pickupContactPhone	取车地址联系人手机号	String	是	手机号
pickupAddress	取车地址	String	是	最多100个字符
pickupAddressLng	取车地址经度	Double	是
pickupAddressLat	取车地址纬度	Double	是
returnContactName	还车地址联系人姓名	String	是	最多20个字符
returnContactPhone	还车地址联系人手机号	String	是	手机号
returnAddress	还车地址	String	是	最多100个字符
returnAddressLng	还车地址经度	Double	是
returnAddressLat	还车地址纬度	Double	是
bookingTime	预约时间	String
(yyyyMMddHHmmss)	是	必须比当前时间晚至少半个小时
carNo	车牌号	String	是
carBrandName	车辆品牌名称	String	否	最多50个字符
carSeriesName	车辆车系名称	String	否	最多50个字符
3.6.4	返回值
值	说明	备注
data	订单号

{
    "code": 0,
    "message": "success",
    "data": 335
}
3.6.5	返回码描述
返回码	返回码描述	备注
1000		渠道号不能为空
	商户id不能为空
	商户id不能超过20个字符
	订单类型不能为空
	订单成单模式不能为空
	下单人手机号不能为空
	下单人手机号不合法
	车主手机号不能为空
	车主手机号不合法
	车主姓名不能为空
	车主姓名不能超过20个字符
	取车地址联系人姓名不能为空
	取车地址联系人姓名不能超过20个字符
	取车地址联系人手机号不能为空
	取车地址联系人手机号不合法
	取车地址不能为空
	取车地址不能超过100个字符
	取车地址经度不能为空
	取车地址纬度不能为空
	还车地址联系人姓名不能为空
	还车地址联系人姓名不能超过20个字符
	还车地址联系人手机号不能为空
	还车地址联系人手机号不合法
	还车地址不能为空
	还车地址不能超过100个字符
	还车地址经度不能为空
	还车地址纬度不能为空
	预约时间不能为空
	车牌号不能为空
	车牌号不合法
	车辆品牌名称不能超过50个字符
	车辆车系名称不能超过50个字符
1002	订单类型不合法
3003	商户不存在
4002	没有权限创建该商户的订单
1003	预约时间不合法
1005	必须提前半个小时预约
1004	取车地址经度纬度不合法
1009	订单成单模式不合法
3.7	取消
3.7.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/cancel
3.7.2	HTTP请求方式
POST
3.7.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单id	Int	是
channel	渠道号	Int	是
3.7.4	返回值
值	说明	备注
data	是否成功	true-成功 false-失败

{
    "code": 0,
    "message": "success",
    "data": true
}
3.7.5	返回码描述
返回码	返回码描述	备注
3001	订单不存在
4001	没有权限操作该订单
3.8	获取订单详情
3.8.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/detail
3.8.2	HTTP请求方式
GET
3.8.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单id	Int	是
channel	渠道号	Int	是
3.8.4	返回值
值	说明	备注
orderInfo	订单详情
orderId	订单号
customerId	商户id
username	车主姓名
type	订单类型	1-取送车
mobile	车主手机号
createMobile	下单人手机号
carNo	车牌号
carBrandName	车辆品牌名称
carSeriesName	车辆车系名称
status	订单状态	参考status状态枚举列表
createTime	创建时间	毫秒数
drivingInfoList	代驾详情
daijiaOrderId	代驾单id
daijiaPrice	代驾费用	单位厘
type	代驾类型	1-取车
driverNo	司机工号
driverPhone	司机手机号
bookingTime	预约时间	毫秒数
pickupContactName	取车地址联系人姓名
pickupContactPhone	取车地址联系人手机号
pickupAddress	取车地址
pickupAddressLng	取车地址经度
pickupAddressLat	取车地址纬度
returnContactName	还车地址联系人姓名
returnContactPhone	还车地址联系人手机号
returnAddress	还车地址
returnAddressLng	还车地址经度
returnAddressLat	还车地址纬度
feeDetail	费用明细
delayTotalFee	延误费用	单位元
delayTime	延误时间	单位分
distance	预估距离	单位公里
totalFee	预估价格	单位元
startFee	起步费用	单位元
overFee	超出费用	单位元

status状态枚举列表：
值	说明	备注
0	已下单
2	资金已冻结
5	订单取消	用户取消、司机取消、坐席取消或者客服取消
6	等待司机接单
7	司机已接单
8	司机已就位
11	司机开车中
12	司机到达目的地
50	已收车
55	订单已完成

{
    "code": 0,
    "message": "success",
    "data": {
        "orderInfo": {
            "orderId": 33483,
            "customerId": "CH0110000223",
            "username": "X8SfKZlh",
            "type": 1,
            "mobile": "12345678902",
            "createMobile": "12345678901",
            "carNo": "京A88888",
            "carBrandName": "宝马",
            "carSeriesName": "X5",
            "status": 7,
            "createTime": 1482320341000
        },
        "drivingInfoList": [
            {
                "daijiaOrderId": 33535,
                "daijiaPrice": 50000,
                "type": 1,
                "driverNo": "BJ72685",
                "driverPhone": "13301025907",
                "bookingTime": 1482406739000,
                "pickupContactName": "车主李先生",
                "pickupContactPhone": "12345678903",
                "pickupAddress": "望京soho",
                "pickupAddressLng": 116.487166,
                "pickupAddressLat": 40.002237,
                "returnContactName": "顾问李女士",
                "returnContactPhone": "12345678904",
                "returnAddress": "叶青大厦",
                "returnAddressLng": 116.474697,
                "returnAddressLat": 40.017861,
                "feeDetail": {
                    "delayTotalFee": 0,
                    "delayTime": 0,
                    "distance": 2.94,
                    "totalFee": 50,
                    "startFee": 50,
                    "overFee": 0
                }
            }
        ]
    }
}
3.8.5	返回码描述
返回码	返回码描述	备注
3001	订单不存在
4001	没有权限操作该订单
3002	代驾单不存在
3.9	获取订单轨迹
3.9.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/recordList
3.9.2	HTTP请求方式
GET
3.9.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单id	Int	是
channel	渠道号	Int	是
3.9.4	返回值
值	说明	备注
Id	轨迹id
orderId	订单号
status	订单状态	参考订单详情
createTime	创建时间	毫秒数

{
    "code": 0,
    "message": "success",
    "data": [
        {
            "id": 93583,
            "orderId": 28898,
            "status": 5,
            "createTime": 1474628739000
        }
    ]
}
3.9.5	返回码描述
返回码	返回码描述	备注
3001	订单不存在
4001	没有权限操作该订单
3.10	获取司机代驾轨迹
3.10.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/trace
3.10.2	HTTP请求方式
GET
3.10.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单id	Int	是
channel	渠道号	Int	是
type	代驾类型	Int	否	1-取车
3.10.4	返回值
值	说明	备注
acceptTime	接单时间	毫秒数
arriveTime	就位时间	毫秒数
driveTime	开车时间	毫秒数
finishTime	完成时间	毫秒数
lastTime	最后路径点时间	毫秒数
arrive	接单到就位间的坐标点集合
await	就位到开车间的坐标点集合
drive	开车到完成间的坐标点集合
orderStatesInfo
arrivePos	就位位置
acceptPos	接单位置
drivePos	开车位置
finishPos	完成位置
currentPos	当前位置

{
    "code": 0,
    "message": "success",
    "data": {
        "acceptTime": 1474702402,
        "driveTime": 1474702554,
        "arriveTime": 1474702471,
        "finishTime": 1474702562,
        "lastTime": 1474702535,
        "arrive": [
            {
                "lng": 116.476274,
                "lat": 40.018602
            }
        ],
        "await": [
            {
                "lng": 116.476271,
                "lat": 40.018619
            }
        ],
        "drive": [
            {
                "lng": 116.476271,
                "lat": 40.018619
            }
        ],
        "orderStatesInfo": {
            "arrivePos": {
                "lng": 116.476274,
                "lat": 40.018602
            },
            "acceptPos": {
                "lng": 116.476274,
                "lat": 40.018602
            },
            "drivePos": {
                "lng": 116.476271,
                "lat": 40.018619
            },
            "finishPos": {
                "lng": 116.476271,
                "lat": 40.018619
            },
            "currentPos": {
                "lng": 116.476271,
                "lat": 40.018619
            }
        }
    }
}
3.10.5	返回码描述
返回码	返回码描述	备注
1001	代驾类型不合法
3001	订单不存在
4001	没有权限操作该订单
3002	代驾单不存在
5001	未派单
3.11	获取司机信息
3.11.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/driverInfo
3.11.2	HTTP请求方式
GET
3.11.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单id	Int	是
channel	渠道号	Int	是
type	代驾类型	Int	否	1-取车
3.11.4	返回值
值	说明	备注
driverId	司机工号
driverPhone	司机手机号
name	司机姓名
newLevel	司机星级
pictureSmall	司机图像（小）
pictureMiddle	司机图像（中）
pictureLarge	司机图像（大）
year	司机驾龄
idCard	司机身份证号码

{
    "code": 0,
    "message": "成功",
    "data": {
        "driverId": "BJ72685",
        "driverPhone": "12343555",
        "name": "测试",
        "newLevel": 0,
        "pictureSmall": "http://pic.edaijia.cn/0/default_driver.jpg_small",
		"pictureMiddle": "http://pic.edaijia.cn/0/default_driver.jpg_normal",
		"pictureLarge": "http://pic.edaijia.cn/0/default_driver.jpg_normal",
        "year": 10,
        "idCard": "3704811988******20"
    }
}
3.11.5	返回码描述
返回码	返回码描述	备注
1001	代驾类型不合法
3001	订单不存在
4001	没有权限操作该订单
3.12	获取目的人收车验证码
3.12.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/verifyCode
3.12.2	HTTP请求方式
GET
3.12.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单id	Int	是
channel	渠道号	Int	是
type	代驾类型	Int	否	1-取车
3.12.4	返回值
值	说明	备注
data	验证码

{
    "code": 0,
    "message": "success",
    "data": "934273"
}
3.12.5	返回码描述
返回码	返回码描述	备注
1001	代驾类型不合法
3001	订单不存在
4001	没有权限操作该订单
3002	代驾单不存在
3.13	获取历史订单列表
3.13.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/queryList
3.13.2	HTTP请求方式
GET
3.13.3	传入参数
参数	含义	类型	是否必须	备注
startDate	开始时间	String(yyyyMMddHHmmss)	否
endDate	结束时间	String(yyyyMMddHHmmss)	否
channel	渠道号	Int	是
pageSize	每页条目	Int	否	默认20
currentPage	当前页码	Int	否	默认1
mobile	车主手机号	String	否
createMobile	下单人手机号	String	否
customerId	商户id	String	否
3.13.4	返回值
值	说明	备注
items	参考订单详情

total	总记录数
pageIndex	当前页码	默认1，起始1
pageSize	每页记录条数
totalPageCount	总页数
more	是否有下一页	true-有 false-无

{
    "code": 0,
    "message": "success",
    "data": {
        "items": [
            {
                "orderId": 28897,
                "customerId": "CH0110000223",
                "username": "权文超",
                "type": 1,
                "mobile": "18600478832",
                "createMobile": "1860047883",
                "carNo": "京A12345",
                "carBrandName": "宝马",
                "carSeriesName": "1系",
                "status": 5,
                "createTime": 1474628510000
            }
        ],
        "total": 132,
        "pageIndex": 1,
        "pageSize": 20,
        "totalPageCount": 7,
        "more": true
    }
}
3.13.5	返回码描述
返回码	返回码描述	备注

3.14	用户评论
3.14.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/comment
3.14.2	HTTP请求方式
POST
3.14.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单号	Int	是
channel	渠道号	Int	是
attitude	服务态度评分	Int	是	取值：10,20,30,40,50
speed	接送车速度评分	Int	是	取值：10,20,30,40,50
content	评论内容	String	是	不能超过200字
3.14.4	返回值
值	说明	备注
data	是否成功	true-成功 false-失败

{
    "code": 0,
    "message": "success",
"data": true
}
3.14.5	返回码描述
返回码	返回码描述	备注
3001	订单不存在
4001	没有权限操作该订单
1007	服务态度评分不合法
1008	接送车速度评分不合法
1010	评论内容不能超过200个字符
3.15	获取用户评论内容
3.15.1	接口地址
https://baoyang.d.edaijia.cn/api/third/2/order/getComment
3.15.2	HTTP请求方式
GET
3.15.3	传入参数
参数	含义	类型	是否必须	备注
orderId	订单号	Int	是
channel	渠道号	Int	是
3.15.4	返回值
值	说明	备注
attitude	服务态度评分	取值：10,20,30,40,50
speed	接送车速度评分	取值：10,20,30,40,50
content	评论内容

{
    "code": 0,
    "message": "success",
    "data": {
        "attitude": 20,
        "speed": 20,
        "content": "这是评论"
    }
}
3.15.5	返回码描述
返回码	返回码描述	备注
3001	订单不存在
4001	没有权限操作该订单
4	主动通知
4.1	接入介绍
1.	合作方提供接收通知的URL
2.	e车管家服务器订单状态发生变化会调用合作方接口，合作方接口如果返回失败信息，服务器会重试，第一次通知时间间隔为10s，以后每次时间间隔为上次的两倍，通知最多8次
4.2	调用接口
4.2.1	Post方式提交给合作方URL参数列表
参数	含义	类型	是否必须	备注
channel	渠道号	Int	是
orderId	订单号	Int	是
status	订单状态	Int	是	状态值参考订单详情
driverNo	司机工号	String	是	司机抢单后或者客服派单后不为空
sign	签名	String	是
4.2.2	合作方接口返回结果描述
合作方返回的http response报头必须为Context-Type=application/json;charset=UTF-8，接口支持幂等
值	说明	备注
code	返回码	0-成功 非0-错误编码
message	返回码描述
data	订单号

{
    "code": 0,
    "message": "success",
    "data": 1410
}
