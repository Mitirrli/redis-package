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

> ## Redis Distributed lock
> 业务逻辑加锁，防止同时操作同一数据

#### App::setRedis()
若不使用默认配置，可以注入redis对象，返回App对象本身。

```
$redis = new \Redis();
$redis->connect('redis-template.cc');

$app = App::setRedis($redis);
```

#### App::Lock()
获取Lock对象，同时传入配置项(设置锁的名字，默认加锁时间为10分钟，key为必传项)
```
$Lock = $app::Lock(['key' => 'demo1']);
```
设置加锁时间为1000秒。
```
$Lock = $app::Lock(['key' => 'demo2', 'time' => 1000]);
```

#### lock()
进行加锁操作，加锁结果以布尔值返回。
```
$Lock->lock()
```

#### unLock()
进行解锁操作，解锁结果以布尔值返回。
```
$Lock->unLock()
```

> ## Redis Fixed Array
> 固定大小的数组，元素塞满后，会pop之前的元素，可用于轮播数据等。

#### App::FixedArray()
获取FixedArray对象，同时传入配置项(设置key的名字，key为必传项)
```
$FixedArray = $app::FixedArray(['key' => 'demo1']);
```
设置元素数目20个。
```
$FixedArray = $app::FixedArray(['key' => 'demo2', 'len' => 20]);
```

#### toList()
往数组中加入数据，最后返回数组元素的数目。
```
$FixedArray->toList('test data');
```

#### lLen()
获取数组元素的数目。
```
$FixedArray->lLen();
```

#### getItemByIndex()
根据数组索引获取数据，下标从0开始，如果没有对应值会抛出异常。
```
$FixedArray->getItemByIndex(0);
```