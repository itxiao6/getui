### 个推SDK

##### 配置
```php
$config = (new \Getui\Config())->
    setAppId('llUBYSt12xg2mPbnOh6')->
    setAppKey('wP31m7pz12DVFmkHq9F6')->
    setMasterSecret('qMyiA12qJ912auukl4Hf8');
```
##### 缓存
```php
$cache = new Doctrine\Common\Cache\RedisCache();
$redis = new \Redis();
$redis->connect('172.26.224.178',6379,5);
$cache->setRedis($redis);
```
##### Authorization
```php
$authorization = (new \Getui\Authorization($config))->withCacheDriver($cache);
```
##### 绑定别名
```php
(new \Getui\User())->withConfig($config)->withAuth($authorization)->aliasBind([
    [
        'cid'=>'ad9555f3c980cb0fe20de584ab9f0e3a',
        'alias'=>'15093570968'
    ]
]);
```
##### 通过ClientId 获取别名
```php
$alias = (new \Getui\User())->
withConfig($config)->
withAuth($authorization)->
getAliasByClientId('ad9555f3c980cb0fe20de584ab9f0e3a');
var_dump($alias);
```

##### 指定Client Id 推送
```php
(new \Getui\Push())->withConfig($config)->withAuth($authorization)->toSingleCid([
    'ad9555f3c980cb0fe20de584ab9f0e3a'
],(new \Getui\Message\NotificationMessage())->
setTitle('测1试32')->
setBody('订单已2经支3付1成功')->
setClickType('payload')->
setPayload([
    'jump_type'=>99,
    'jump_value'=>111
]));
```
##### 指定 别名 推送
```php
(new \Getui\Push())->withConfig($config)->withAuth($authorization)->toSingleAlias([
    '15093570968'
],(new \Getui\Message\NotificationMessage())->
setTitle('测试12')->
setBody('订单s已2经支3付1成功')->
setClickType('payload')->
setPayload([
    'jump_type'=>91,
    'jump_value'=>111
]));
```

##### 推送全部用户
```php
(new \Getui\Push())->withConfig($config)->withAuth($authorization)->toAll((new \Getui\Message\NotificationMessage())->
setTitle('测试2订单')->
setBody('全局2推送')->
setClickType('payload')->
setPayload([
    'jump_type'=>2,
    'jump_value'=>"id=1"
]));
```