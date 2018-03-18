<?php
require('./phpQuery-master/phpQuery/phpQuery.php');

$key = '百度';
//$baseUrl = 'http://www.qichacha.com';
$baseUrl = '';
if (isset($_GET['key']) && $_GET['key']) {
    $key = $_GET['key'];
}
$content = shell_exec("curl '{$baseUrl}/search?key={$key}' -H 'Accept-Encoding: gzip, deflate' -H 'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8' -H 'Upgrade-Insecure-Requests: 1' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8' -H 'Referer: {$baseUrl}/search?key={$key}' -H 'Cookie: PHPSESSID=tc4un1f414l7g0uko1e4t6cpk6; UM_distinctid=16222f78609838-0280601a355ff7-32637b05-1fa400-16222f7860a7ba; zg_did=%7B%22did%22%3A%20%2216222f786e864e-0ae43a9c7d6996-32637b05-1fa400-16222f786e9686%22%7D; Hm_lvt_3456bee468c83cc63fb5147f119f1075=1521005070; hasShow=1; acw_tc=AQAAAOhfs35KXQAA2BwOt/kZl2UWJDzg; _uab_collina=152100507456532542857944; CNZZDATA1254842228=8018972-1521002606-https%253A%252F%252Fwww.baidu.com%252F%7C1521018805; Hm_lpvt_3456bee468c83cc63fb5147f119f1075=1521021950; zg_de1d1a35bfa24ce29bbf2c7eb17e6c4f=%7B%22sid%22%3A%201521021937968%2C%22updated%22%3A%201521021984332%2C%22info%22%3A%201521005070064%2C%22superProperty%22%3A%20%22%7B%7D%22%2C%22platform%22%3A%20%22%7B%7D%22%2C%22utm%22%3A%20%22%7B%7D%22%2C%22referrerDomain%22%3A%20%22www.qichacha.com%22%7D' -H 'Connection: keep-alive' --compressed");

phpQuery::newDocumentHTML($content);

$com = pq("#searchlist td:eq(1) a:eq(0)");
$suffix = $com->attr("href");

phpQuery::newDocumentFileHTML($baseUrl . $suffix);

// 法定代表人信息
$result['法定代表人信息'] = pq("#Cominfo .bname")->html();

$box = pq("#Cominfo table.ntable:eq(1) td");
$name = '';
foreach ($box as $key => $row) {
    $str = pq($row)->html();
    if ($key % 2) {
        $result[trim($name)] = trim($str);
    } else {
        $str = preg_replace('/：/', '', $str);
        $name = $str;
    }
}
var_dump($result);
