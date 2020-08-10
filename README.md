<h1 align="center"> Redis pkg </h1>

[![Total Downloads](https://poser.pugx.org/mitirrli/redis-package/downloads)](https://packagist.org/packages/mitirrli/redis-package)
[![Latest Stable Version](https://poser.pugx.org/mitirrli/redis-package/v/stable)](https://packagist.org/packages/mitirrli/redis-package)
[![Latest Unstable Version](https://poser.pugx.org/mitirrli/redis-package/v/unstable)](https://packagist.org/packages/mitirrli/redis-package)
<a href="https://packagist.org/packages/mitirrli/redis-package"><img src="https://poser.pugx.org/mitirrli/redis-package/license" alt="License"></a>

A simple redis packages.

## Installation
```shell
$ composer require "mitirrli/redis-package"
```

### Redis Distributed lock

#### 1 App::setRedis()
若不使用默认配置,可以注入redis对象,返回App对象本身.

```
$redis = new \Redis();
$redis->connect('redis-template.cc');

$app = App::setRedis($redis);
```

#### 2 App::Lock()
获取Lock对象,同时传入配置项(设置锁的名字,默认加锁时间为10分钟,key为必传项).
```
$Lock = $app::Lock(['key' => 'demo1']);
```
设置加锁时间为1000秒.
```
$Lock = $app::Lock(['key' => 'demo2', 'time' => 1000]);
```

#### 3 lock()
进行加锁操作,加锁结果以布尔值返回.
```
$Lock->lock()
```

#### 4 unLock()
进行解锁操作,解锁结果以布尔值返回.
```
$Lock->unLock()
```