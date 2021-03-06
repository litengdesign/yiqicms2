<?php
require_once 'admin.inc.php';
require_once '../include/product.class.php';
require_once '../include/category.class.php';
$cid=$_GET["cid"];
$curpage=$_GET["p"];
$cid = (isset($cid) && is_numeric($cid)) ? $cid : 0;
$curpage = (isset($curpage) && is_numeric($curpage)) ? $curpage : 1;
if($curpage<1)
{
    $curpage=1;
}
$productdata = new Product;
$total = count($productdata->GetProductList($cid,"pid desc",true));
$take = 20;
$skip = ($curpage - 1) * $take;
$totalpage = (int)($total % $take == 0 ? $total / $take : $total / $take + 1);
$productlist = $productdata->TakeProductList($cid,$skip,$take,"pid desc",true);
$action = $_POST["action"];
if($action == "isnew")
{
    $idarr = $_POST["chk"];
    if(count($idarr) > 0)
    {
        foreach($idarr as $id)
        {
            if(is_numeric($id))
            {
                $sql = "UPDATE yiqi_product set isnew='true' WHERE pid = '$id' ";

            
                $yiqi_db->query(CheckSql($sql));
            }
        }
        /*ShowMsg("已经设置为最新产品");*/
        echo "<script>alert('已经设置为新品');history.go(-1)</script>";
    }
}
if($action == "isgood")
{
    $idarr = $_POST["chk"];
    if(count($idarr) > 0)
    {
        foreach($idarr as $id)
        {
            if(is_numeric($id))
            {
                $sql = "UPDATE yiqi_product set isgood='true' WHERE pid = '$id' ";

            
                $yiqi_db->query(CheckSql($sql));
            }
        }
        echo "<script>alert('已经设置为推荐产品');history.go(-1)</script>";
    }
}
if($action == "nonew")
{
    $idarr = $_POST["chk"];
    if(count($idarr) > 0)
    {
        foreach($idarr as $id)
        {
            if(is_numeric($id))
            {
                $sql = "UPDATE yiqi_product set isnew='false' WHERE pid = '$id' ";

            
                $yiqi_db->query(CheckSql($sql));
            }
        }
        /*ShowMsg("取消新品设置成功");*/
        echo "<script>alert('取消新品设置成功');history.go(-1)</script>";
    }
}
if($action == "nogood")
{
    $idarr = $_POST["chk"];
    if(count($idarr) > 0)
    {
        foreach($idarr as $id)
        {
            if(is_numeric($id))
            {
                $sql = "UPDATE yiqi_product set isgood='false' WHERE pid = '$id' ";

            
                $yiqi_db->query(CheckSql($sql));
            }
        }
        /*ShowMsg("取消推荐设置成功");*/
        echo "<script>alert('取消推荐设置成功');history.go(-1)</script>";
    }
}
if($action == "delete")
{
    $idarr = $_POST["chk"];
    if(count($idarr) > 0)
    {
        foreach($idarr as $id)
        {
            if(is_numeric($id))
            {
                $sql = "DELETE FROM yiqi_product WHERE pid = '$id' limit 1";
                $yiqi_db->query(CheckSql($sql));
            }
        }
        /*ShowMsg("指定产品删除成功");*/
        echo "<script>alert('指定产品删除成功');history.go(-1)</script>";
    }
}
?>
<?php
$adminpagetitle = "产品列表";
include("admin.header.php");?>
<div class="main_body">
  <form action="../admin/psearch.php" method="post">
    本站搜索：
      <input type="text" name="keywords" size="30" /> 
      <input type="submit" value="搜索">
    </form>
<form action="product.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr style="background:#f6f6f6;">
    <td class="w10">选择</td><td class="w50">产品名称</td>
    <td class="w20">所属分类</td>
    <td class="w10">发布状态</td>
    <td class="w10" colspan="0" align="center">相关操作</td>
</tr>
<?php
if(count($productlist)>0)
{
    foreach($productlist as $product)
    {
        $categoryname = "";
        $categorydata = new Category;
        $categoryinfo = $categorydata->GetCategory($product->cid);
        if($categoryinfo != null)
        {
            $categoryname = $categoryinfo->name;
        }
        else
        {
            $categoryname = "未分类";
        }
        $pubstatus = '<span title="该产品已发布">已发布</span>';
        
        if($product->isnew =="true")
        {
           $isnew="<span title='新品' style='color:red'>  新品</span>";

        }
        else{
            $isnew="";
        }

        if($product->isgood =="true")
        {
           $isgood="<span title='推荐' style='color:blue'>  推荐</span>";

        }
        else 
        {
           $isgood="";

        }
        if($product->thumb !=NULL)
        {
           $thumb="<span title='图' style='color:green'>  图</span>";

        }
        else{
            $thumb="";
        }
       


        if(phpversion() > '5.1.0')
            date_default_timezone_set('Asia/Shanghai');
        if(strtotime($product->adddate) > strtotime(date("c")))
        {
            $pubstatus = "<span title=\"该产品将于：".$product->adddate."发布\">定时发布</span>";
        }
        echo "<tr>".
            "<td><input id=\"slt$product->pid\" type=\"checkbox\" name=\"chk[]\" value=\"$product->pid\" /></td>".
            "<td ><a href=\"../product.php?name=".urlencode($product->filename)."\" target=\"_blank\">$product->name$isnew $isgood  $thumb</a></td>".
            "<td align='left'><a href=\"product.php?cid=".$categoryinfo->cid."\">$categoryname</a></td>".
            "<td align='left'>$pubstatus</td>".
      
            "<td align='center'><a href=\"product-edit.php?pid=$product->pid\">修改</a></td>".
            "</tr>";
    }
} 
?>
</table>
<div class="clear">&nbsp;</div>
<div class="fl" style="text-indent:16px;"><input id="slt" type="checkbox"/>&nbsp;&nbsp;
    <select name="action">
        <option value="-">批量应用</option>
        <option value="isgood">推荐</option>
        <option value="isnew">新品</option>
        <option value="nonew">取消新品</option>
        <option value="nogood">不推荐</option>
        <option value="delete">删除</option>
    </select>&nbsp;<input type="submit" class="subtn" value="提交" onclick="if(!confirm('确认执行相应操作?')) return false;"/></div>
  

<div class="fr">
<?php 
$_SERVER["QUERY_STRING"] = preg_replace("/(&)?p=[0-9]{1,3}(&)?/","",$_SERVER["QUERY_STRING"]);
echo "共${total}个产品 当前${curpage}/${totalpage}页 ";
if($curpage > 1)
{
    if($cid==0)
    {
        echo "<a href=\"product.php?p=1\">首页</a>".
             "&nbsp;<a href=\"product.php?p=".($curpage-1)."\">上一页</a>";
    }
    else
    {
        echo "<a href=\"product.php??cid=$cid&p=1\">首页</a>".
             "&nbsp;<a href=\"product.php??cid=$cid&p=".($curpage-1)."\">上一页</a>";
    }
}
if($curpage > 0 && $curpage < $totalpage)
{
    if($cid==0)
    {
        echo "&nbsp;<a href=\"product.php?p=".($curpage+1)."\">下一页</a>".
             "&nbsp;<a href=\"product.php?p=$totalpage\">尾页</a>";
    }
    else
    {
        echo "&nbsp;<a href=\"product.php?cid=$cid&p=".($curpage+1)."\">下一页</a>".
             "&nbsp;<a href=\"product.php?cid=$cid&p=$totalpage\">尾页</a>";
    }
}
?>
</div>
</form>
<div class="clear">&nbsp;</div>
        
<div style="color:#ff0000;font-size:14px;"><strong>提示："定时发布"的产品，只有管理员可以看到，未到发布时间不能在前台显示，正式发布后，会自动显示。<br />　　　“已发布”的产品，任何人都可正常访问。<br/></strong></div>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>