<?php
//API 名称
$APIname='ACG_API';
// 存储数据的文件
$filename = 'link.txt';
if(!file_exists($filename)) {
    die($filename.'数据文件不存在');
} else {
    //读取资源文件
    $giturlArr = file($filename);
}
$giturlData = [];
//将资源文件写入数组
foreach ($giturlArr as $key => $value) {
    $value = trim($value);
    if (!empty($value)) {
        $giturlData[] = trim($value);
    }
}
//获取随机数
$randKey = rand(0, count($giturlData)-1);
//取链接
$imgurl = $giturlData[$randKey];
$returnType = $_GET['return'];
switch ($returnType) {
    case 'img':
        $img = file_get_contents($imgurl, true);
        header("Content-Type: image/jpeg;");
        echo $img;
        break;
    case 'json':
        $json['API_NAME'] = $APIname;
        $json['imgurl'] = $imgurl;
        $imageInfo = getimagesize($imgurl);
        $json['width'] = $imageInfo[0];
        $json['height'] = $imageInfo[1];
        header('Content-type:text/json');
        echo json_encode($json,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        break;    
    default:
        header("Location:" . $imgurl);
        break;
}
?>