<?php
$url = ''; // 需要采集的URL
$key = ''; // PushBear的SendKey
$title_xpath = ''; // 标题的XPath节点
$url_xpath = ''; // 对应链接的XPath节点

$html = file_get_contents($url);

$dom = new DOMDocument();
// 从一个字符串加载HTML
@$dom->loadHTML($html);
// 使该HTML规范化
$dom->normalize();
// 用DOMXpath加载DOM，用于查询
$xpath = new DOMXPath($dom);

// 获取对应的xpath数据
$title_hrefs = $xpath->query($title_xpath); // 标题

$data = [];
for ($i = 0; $i < $title_hrefs->length; $i++) {
    $href = $title_hrefs->item($i);
    $title = $href->nodeValue;
    $data[$i]['title'] = $title;
}

// 获取对应的xpath数据
$url_hrefs = $xpath->query($url_xpath); // 链接
for ($i = 0; $i < $url_hrefs->length; $i++) {
    $href = $url_hrefs->item($i);
    $url = $href->nodeValue;
    $data[$i]['url'] = 'https://segmentfault.com'.$url;
}

$json = json_encode($data);

// 判断文件是否存在
if (file_exists("./sf.json")) {
    // 存在
    $old = file_get_contents('./sf.json');
    // 文件不同
    if ($old != $json) {
        // 替换掉 写新文件
        file_put_contents('./sf.json', $json);
        $oldInfo = json_decode($old, true);
        // 去重
        $data = array_unique(array_merge($data, $oldInfo));
    } else {
        // 相同就不发了
        echo date('Y-m-d H:i:s', time()). "内容相同".PHP_EOL;
      	return;
    }
} else {
    // 不存在 写文件
    file_put_contents('./sf.json', $json);
}

$str = "";
foreach ($data as $key => $item) {
    $num = $key + 1;
    $str .= "{$num}. [{$item['title']}]({$item['url']}) \n\n";
}

// 推送
if (!empty($key)) {
    echo sendByBear('***标签动态', $str);
}

function sendByBear($text, $desp = '', $key = '')
{
    $postData = http_build_query(
        array(
            'text' => $text,
            'desp' => $desp,
            'sendkey' => $key
        )
    );

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postData
        )
    );

    $context = stream_context_create($opts);

    $result = file_get_contents('https://pushbear.ftqq.com/sub', false, $context);

    return $result;
}
