<?php
require_once 'include/common.inc.php';
require_once 'include/article.class.php';
require_once 'include/product.class.php';
require_once 'include/category.class.php';
$keywords = $_GET["keywords"];
$tempinfo->assign("take",$take);
$tempinfo->assign("total",$total);
$tempinfo->assign("totalpage",$totalpage);
$tempinfo->assign("curpage",$curpage);
$tempinfo->assign("keywords",$keywords);
if(!$tempinfo->template_exists("search.tpl"))
{
    exit("没有找到合适的模板,请与管理员联系!");
}
$tempinfo->display("search.tpl");
?> 