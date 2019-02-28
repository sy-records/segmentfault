# SegmentFault
😐今天SegmentFault开放`API`了吗?

🙄没有，只能爬一下了

## 获取某个标签下的信息

### URL

1. 标签动态 `https://segmentfault.com/t/*`
2. 技术问答 `https://segmentfault.com/t/*/questions`
3. 专栏文章 `https://segmentfault.com/t/*/blogs`

### XPath节点

`PHP`使用`XPath`采集也是还可以的

1. 标签动态

* 标题 `//h4/a/text()`
* 链接 `//h4/a/@href`

2. 技术问答

> 仔细点的话可以带一个`class`属性

* 标题 `//h2[@class="title"]/a/text()`
* 链接 `//h2[@class="title"]/a/@href`

3. 专栏文章

* 标题 `//h2/a/text()`
* 链接 `//h2/a/@href`

### 使用

我这里只采集第一页的数据用来提醒，可自行扩展

补全`tag.php`中的相关信息，`URL`和`XPath`节点

以及是否使用[PushBear](http://pushbear.ftqq.com/admin/#/api)进行一对多推送，使用需要补全`key`

### 效果截图

<img src="https://ws1.sinaimg.cn/large/0072Lfvtly1g0lxmahzklj30xa1as0zp.jpg" alt="WX20190228-102943@2x.png" title="WX20190228-102943@2x.png" height='500px' />
