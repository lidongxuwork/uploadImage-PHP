<?php
// 1. 获取GET网络请求网址里的key值对应的value
// 声明变量name1 和pass1 接收
$name1 = $_GET['name'];
$pass1 = $_GET['pass'];
// 2. 建立数据库连接
// 参数1: 数据库所在的服务器的地址(本机127.0.0.1或者localhost)
// 参数2: MySql数据库的账户(默认root)
// 参数3: MySql数据库的密码(默认无)
$con = mysql_connect("127.0.0.1", "root", "");
// 参数1: 自己建立的数据库的名字
$myCon = mysql_select_db("lidongxu", $con);
// 3. 执行查询 (利用用户名和密码进行匹配查找, 如果找到了随意返回userName(用户名))
$sql = "select * from User where userName = '$name1' And password = '$pass1'";
// 4. 接收结果
$result = mysql_query($sql);
// 4.2 如果查询结果为空的话
if(mysql_num_rows($result) == 0) {
        $a = array();
        $a['success'] = "0";
        $a['name'] = "null";
        $a['status'] = "no";
        $arr = json_encode($a);
        echo $arr;
}
else {
// 5. 取出本条记录
$row = mysql_fetch_row($result);
        $a = array();
        $a['success'] = "1";
        $a['name'] = $row[0];
        $a['age'] = $row[2];
        $a['telephone'] = $row[3];
        $a['status'] = "ok";
        $arr = json_encode($a);
        echo $arr;
}
 ?>