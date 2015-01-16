
<?php
require_once 'admin2.inc.php';
$link = @mysql_connect($cfg_db_host, $cfg_db_user, $cfg_db_pass) or die('不能连接到数据库,请确保用户名或密码正确 ');
if(!$link) echo "不能连接到数据库 !";
$aid = $_GET['pid'];
mysql_select_db($cfg_db_name, $link); //数据库
$sql = "delete from yiqi_product where pid ='$aid'";

$rs = mysql_query($sql, $link); //连接
if(!$rs){die("<br/>链接失败");}
echo"
产品已经删除
<script>
   
    setInterval(history.go(-2),3000);

</script>"
?> 
