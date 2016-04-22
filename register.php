<?php // 1. 获取客户端利用post方式网络请求的body里的字段对应的value (这个字段// 是这里规定的, 前端必须遵守这个name2, pass2等key值)
$nameP = $_POST['name2'];
$passP = $_POST['pass2'];
$ageP = $_POST['age2'];
$telephoneP = $_POST['telephone2'];
// 2. 建立数据库连接 (127.0.0.1 数据库所在的ip地址)
// root 是数据库用户名(默认的)
// "" 密码(默认是空)
$con = mysql_connect("127.0.0.1", "root", "");
$myCon = mysql_select_db("lidongxu", $con);
// 3. 先查询, 如果存在就不要在插入了
$select = "select userName from User where userName = '$nameP'";
$seleResult = mysql_query($select);
// 4. 如果查到了, 说明已经存在这个用户了, 则返回-1给客户端代表已经注册过了
if (mysql_num_rows($seleResult)) {
// success 就是key值 对应的value 就是后面的字符串
 $a = array();
 $a['success'] = "-1";
 $a['status'] = "have";
 $arr = json_encode($a);
 echo $arr;
}
// 5. 如果没注册过, 那么
else {
// 6. 把数据都插入到mysql数据库中
 $sql = "insert into User values('$nameP', '$passP', '$ageP', '$telephoneP')";
 $result = mysql_query($sql);
 if ($result == 1) { // 7. 代表执行成功
 $a = array();
 $a['success'] = "1";
 $a['status'] = "ok";
 $arr = json_encode($a);
 echo $arr;

 }
 else { // 8. 代表插入失败


 $a = array();
 $a['success'] = "0";
 $a['status'] = "no";
 $arr = json_encode($a);
 echo $arr;

 }
}
// 9. 接收用户头像图片
// 9.1. 接收图片传到服务器上默认的临时文件路径以及名字 (uploadfile 给前台使用的
// 字段)
$url = $_FILES["uploadimageFile"]["tmp_name"];
// 9.2 获取根路径下的downloads文件夹下的路径(download2 需要手动
// 去本地创建)
$destination_folder = $_SERVER['DOCUMENT_ROOT'].'/download2/';
// 9.3拼接要作为服务器上保存的文件名字
$newfname = $destination_folder .(string)$nameP.'.jpg'; //set your file ext
// 打开连接  rb+ 读写打开一个二进制文件，允许读写数据，文件必须存在。
// 获取客户端上传到缓存文件夹下的文件
$file = fopen ($url, "rb");
if ($file) {
// a 以附加的方式打开只写文件。若文件不存在，则会建立该文件，如果文件存在，写入的数据会被加到文件尾，即文件原先的内容会被保留。
// 获取要把客户端传递过来的文件复制到新的文件夹下的名字
   $newf = fopen ($newfname, "a");
   if ($newf)


   // 检查文件是否结束，如结束，则返回非零值

   while(!feof($file)) {


   // 开始从某个文件读取1MB 然后写入到新的路径1MB
 fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );

   }
 }
 if ($file) {


 // 关闭文件链接

   fclose($file);
 }
 if ($newf) {
   fclose($newf);
 }
?>