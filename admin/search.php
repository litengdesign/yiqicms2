
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>文章列表</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../images/jq.js" ></script>
<script type="text/javascript" src="../images/yiqimenu.js" ></script>
<script type="text/javascript" src="../images/load.js" ></script>
<script type="text/javascript" src="../images/jquery.form.js"></script>
</head>

<body>
<?php
require_once 'admin2.inc.php';
?>
<div class="wrap">
<div class="header">
</div>
<div class="nav"><span class="fr"><img src="../images/user_icon.gif" alt="欢迎登陆" title="欢迎登陆" />&nbsp;欢迎登陆：admin&nbsp;&nbsp;您可以查看 <a href="http://www.yiqicms.com/category/changjianbangzhu/" target="_blank">易企CMS常见帮助</a>、进入 <a href="http://www.yiqicms.com/forum/" target="_blank">易企CMS论坛</a>&nbsp;或者&nbsp;<a href="logout.php">退出登录</a></span>当前位置：后台管理 》 文章列表</div>
<div class="clear">&nbsp;</div>
<div class="main">

<div id="main_nav">
<dl> 
<dt><a href="../" target="_blank">网站首页</a>&nbsp;&nbsp;<a href="index.php">后台首页</a>&nbsp;&nbsp;<a href="cleancache.php">清除缓存</a></dt>

<dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">文章管理</a></dt><dd><div class="submenu"><ul><li><a href="article-add.php">添加文章</a></li><li><a href="article.php">文章列表</a></li><li><a href="category.php?type=article">文章分类</a></li><li><a href="category-add.php?type=article">添加分类</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">产品管理</a></dt><dd><div class="submenu"><ul><li><a href="product.php">产品列表</a></li><li><a href="product-add.php">添加产品</a></li><li><a href="category.php?type=product">产品分类</a></li><li><a href="category-add.php?type=product">添加分类</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">留言管理</a></dt><dd><div class="submenu"><ul><li><a href="comments.php">留言列表</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">友情链接</a></dt><dd><div class="submenu"><ul><li><a href="link.php">链接列表</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">用户管理</a></dt><dd><div class="submenu"><ul><li><a href="users.php">用户列表</a></li><li><a href="user-add.php">添加用户</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">模板管理</a></dt><dd><div class="submenu"><ul><li><a href="templets.php">模板列表</a></li><li><a href="navigate.php">导航管理</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">网站设置</a></dt><dd><div class="submenu"><ul><li><a href="option.php">基本设置</a></li><li><a href="option-seo.php">SEO设置</a></li><li><a href="option-url.php">URL重写</a></li><li><a href="settings.php">变量管理</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">公司资料</a></dt><dd><div class="submenu"><ul><li><a href="company-option.php">公司简介</a></li><li><a href="company-contact.php">联系方式</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">数据管理</a></dt><dd><div class="submenu"><ul><li><a href="dbbackup.php">数据备份</a></li><li><a href="dbrestore.php">数据恢复</a></li></ul></div></dd><dt class="submenuheader" style="cursor:pointer;"><img src="../images/plus.gif" alt="查看子分类" title="查看子分类"/>&nbsp;&nbsp;<a href="#">关键词管理</a></dt><dd><div class="submenu"><ul><li><a href="keywords.php">关键词列表</a></li><li><a href="keyword-add.php">添加关键词</a></li></ul></div></dd></dl>
<script type="text/javascript" src="../images/ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader",contentclass: "submenu",
	revealtype: "click",
	mouseoverdelay: 200,
	collapseprev: true, 
	defaultexpanded: [],
	onemustopen: false, 
	animatedefault: false,
	persiststate: true, 
	toggleclass: ["", ""],
	togglehtml: ["suffix", "", ""], 
	animatespeed: "fast", 
	oninit:function(headers, expandedindices){ 
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ 
		//do nothing
	}
});
</script>

</div>

<div class="main_body">

  	<form action="../admin/search.php" method="post">
    本站搜索：<input type="text" name="keywords" size="30" > <input type="submit" value="搜索">
    </form>
<?php
$link = @mysql_connect($cfg_db_host, $cfg_db_user, $cfg_db_pass) or die('不能连接到数据库,请确保用户名或密码正确 ');
if(!$link) echo "不能连接到数据库!";
$c=$_POST['keywords'];
$aid = $_GET['aid'];
echo $c;
mysql_select_db($cfg_db_name, $link); //数据库
$q = "SELECT * FROM yiqi_article where title like '%$_POST[keywords]%'"; //SQL询
$rs = mysql_query($q, $link); //连接
if(!$rs){die("<br/>链接失败");}
echo "<table class='inputform' cellpadding='1' cellspacing='1'>";
echo "<tr style='background:#f6f6f6;'><td class='w10'>选择</td><td class='w50'>文章标题</td><td>所属分类</td><td class='w10'>发布状态</td><td class='w20'>相关操作</td></tr>";

while($row = mysql_fetch_row($rs)) echo "<tr><td><input id='slt3' type='checkbox' name='chk[]' value='3' /></td><td><a href='../article.php?name=$row[7]' target='_blank'>$row[1]</a></td><td>$row[2]</td><td>$row[13]</td><td  class='w20'><a href='article-edit.php?aid=$article$row[0]'>修改</a>&nbsp;&nbsp;&nbsp;<a href='delete.php?aid=$article$row[0]' onclick='fun1();'>删除</a></td></tr>"; //示
echo "</table>";
mysql_free_result($rs); //
?> 
<form action="search.php" method="post">

<div class="clear">&nbsp;</div>
<div class="fl" style="text-indent:16px;">
	<input id="slt" type="checkbox"/>&nbsp;&nbsp;
	<select name="action">
	    <option value="-">批量应用</option>
	    <option value="delete">删除</option>
	</select>&nbsp;
	<input type="submit" class="subtn" value="提交" onclick="if(!confirm('确认执行相应操作?')) return false;"/></div>
<div class="fr">
共3条文章 当前1/1页 </div>
</form>
<div class="clear">&nbsp;</div>
</form>

<div style="color:#ff0000;font-size:14px;"><strong>提示："定时发布"的文章，只有管理员可以看到，未到发布时间不能在前台显示，正式发布后，会自动显示。<br />　　　“已发布”的文章，任何人都可正常访问。<br/></strong></div>
</div>

</div>

<div class="clear">&nbsp;</div>
<div class="footer">版权所有 <a href="http://www.yiqicms.com/" style="color:#ffffff;" target="_blank">易企科技</a></div></div>

</body>

</html>