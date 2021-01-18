<?php



use Getui\Config;

include_once "vendor/autoload.php";

# 配置
$config = (new Config())->
setAppId('')->
setAppKey('')->
setMasterSecret('');

# 缓存
$cache = new Doctrine\Common\Cache\RedisCache();
$redis = new \Redis();
$redis->connect('127.0.0.1',6379,5);
$cache->setRedis($redis);

# Token As String

//$token = (new \Getui\Authorization($config))->withCacheDriver($cache)->getTokenAsString();

# Authorization

$authorization = (new \Getui\Authorization($config))->withCacheDriver($cache);


(new \Getui\Push())->withConfig($config)->withAuth($authorization)->toSingle([
    '20b77995a08bb8c34d540386d0788e25'
],[
    'notification'=>[
        'title'=>'测试推送',
        'body'=>'订单号:897987829739128379',
        'click_type'=>'url',
        'url'=>'http://www.baidu.com'
    ]
]);
