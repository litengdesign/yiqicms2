<?php
require_once 'admin.inc.php';
require_once '../include/category.class.php';
$pid = $_GET["pid"];
$categorytype = $_GET['type'];
$pid = (isset($pid) && is_numeric($pid)) ? $pid : 0;

$categorydata = new Category;
$catinfo = $categorydata->GetCategory($pid);
if(!empty($catinfo->type))
{
    $categorytype = $catinfo->type;
}

if(empty($categorytype) || $categorytype=='')
{
    $categorytype="article";
}
$action = $_POST["action"];
if($action == "save")
{
    $categoryname = $_POST["categoryname"];
    $parentcategory = $_POST["parentcategory"];
    $categorydescription = $_POST["categorydescription"];
    $categoryseotitle = $_POST["categoryseotitle"];
    $categoryseokeywords = $_POST["categoryseokeywords"];
    $categoryseodescription = $_POST["categoryseodescription"];
    $categorycatethumb = "-";
    $categoryfilename = $_POST["categoryfilename"];
	$categorytemplets = $_POST["categorytemplets"];
    $categorytakenumber = $_POST["categorytakenumber"];
	
	if(!is_numeric($categorytakenumber))
	{
		$categorytakenumber = 24;
	}
    if(empty($categoryname))
    {
        exit("请填写正确的分类名称");
    }
    if(!is_numeric($parentcategory))
    {
		$parentcategory = 0;
    }
    if(empty($categorydescription))
    {
        $categorydescription = "-";
    }
    if(empty($categoryseotitle))
    {
        $categoryseotitle = $categoryname;
    }
    if(empty($categoryseokeywords))
    {
        $categoryseokeywords = $categoryname;
    }
    if(empty($categoryseodescription))
    {
        $categoryseodescription = $categorydescription;
    }
    //上传产品大图
    if(!empty($_FILES["categorycatethumb"]["name"]))
    {
        require_once("../include/upload.class.php");
        $filedirectory = YIQIROOT."/uploads/image";
        $filename = date("ymdhis");
        $filetype = $_FILES['categorycatethumb']['type'];
        $upload = new Upload;
        $upload->set_max_size(1800000); 
        $upload->set_directory($filedirectory);
        $upload->set_tmp_name($_FILES['categorycatethumb']['tmp_name']);
        $upload->set_file_size($_FILES['categorycatethumb']['size']);
        $upload->set_file_ext($_FILES['categorycatethumb']['name']); 
        $upload->set_file_type($filetype); 
        $upload->set_file_name($filename);      
        $upload->start_copy();      
        if($upload->is_ok())
        {
            $categorycatethumb = YIQIPATH."uploads/image/".$filename.'.'.$upload->user_file_ext;
        }
        else
        {
            exit($upload->error());
        }
    }else if (isset($_POST['categorycatethumb']))
    {
        $productthumb = $_POST['categorycatethumb'];
    }
    if(empty($categoryfilename))
    {
        $categoryfilename = "-";
    }
    if($categoryfilename == "-")
	{
	    $categoryfilename = date("YmdHis");
	}
	$categoryfilename = str_replace(" ","-",$categoryfilename);
    $existfilename = $categorydata->ExistFilename($categoryfilename);
	if($existfilename == 1)
	{
		if(strpos($categoryfilename,"http://")!==0)
			exit("指定的文件名已经存在");
	}
    $categorytemplets = str_replace("{style}/","",$categorytemplets);
    $sql = "INSERT INTO yiqi_category (cid,name,type,pid,seotitle,seokeywords,seodescription,catethumb,description,filename,templets,takenumber,status)".
    		" VALUES (null,'$categoryname','$categorytype','$parentcategory','$categoryseotitle','$categoryseokeywords','$categoryseodescription','$categorycatethumb','$categorydescription','$categoryfilename','$categorytemplets','$categorytakenumber','ok')";
    $result = $yiqi_db->query(CheckSql($sql));
    if($result==1)
    {
		$cid = $yiqi_db->insert_id;
		$genehtml = getset("urlrewrite")->value;
		if ( $genehtml == "html" ) {
			$category = $categorydata->GetCategory($cid);
			$tempinfo->assign("category",$category);
			if(!$tempinfo->template_exists($category->templets)) {
				exit("没有找到文章模板,请与管理员联系!");
			}
			$source = $tempinfo->fetch($category->templets);		
			$urlparam = array( 'name' => $categoryfilename, 'type' => 'category', 'generatehtml' => 1 );
			$fileurl = formaturl($urlparam);
			$cachedata->WriteFileCache(YIQIROOT."/".$fileurl.'index.html', $source, true);
		}
        exit("分类添加成功！");
    }
    else
    {
        exit("分类添加失败,请与管理员联系！");
    }
}
?>
<?php
$adminpagetitle = "添加分类";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">分类名称</td><td class="input"><input type="text" class="txt" name="categoryname" /></td></tr>
<tr><td class="label">上级分类</td><td class="input"><select name="parentcategory">
<option value="0">设为顶级分类</option>
<?php
$categorylist = $categorydata->GetCategoryList(0,$categorytype);
foreach($categorylist as $category)
{
    if($catinfo->cid == $category->cid)
    {
	    echo "<option value=\"".$category->cid."\" selected=\"selected\">".$category->name."</option>";
    }
    else
    {
        echo "<option value=\"".$category->cid."\">".$category->name."</option>";
    }
}
?></select></td></tr>
<tr><td class="label">分类类型</td><td class="input"><select name="categorytype">
<?php 
if($categorytype=="article")
{
    echo "<option value=\"article\">文章</option>";
}
else
{
    echo "<option value=\"product\">产品</option>";
}
?>
</select></td></tr>
<tr><td class="label">SEO标题</td><td class="input"><input type="text" class="txt" name="categoryseotitle" /></td></tr>
<tr><td class="label">SEO关键词</td><td class="input"><input type="text" class="txt" name="categoryseokeywords" /></td></tr>
<tr><td class="label">SEO描述</td><td class="input"><textarea class="txt" name="categoryseodescription" style="width:200px;height:110px;"></textarea></td></tr>
<tr>
    <td class="label">分类图片</td><td class="input">
      <div id="ptinfo">
        <input class="upfile txt" type="file" style="width:280px;" name="categorycatethumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a>
      </div>
    </td>
</tr>
<tr><td class="label">分类介绍</td><td class="input"><textarea class="txt" name="categorydescription" style="width:200px;height:110px;"></textarea></td></tr>
<tr><td class="label">自定义文件名</td><td class="input"><input type="text" class="txt" name="categoryfilename" />&nbsp;&nbsp;设置为http://开头，将链接到指定的地址。</td></tr>
<tr><td class="label">显示数量</td><td class="input"><input type="text" class="txt" name="categorytakenumber" value="24" /></td></tr>
<tr><td class="label">默认模板</td><td class="input"><input type="text" class="txt" name="categorytemplets" value="{style}/category.tpl" /></td></tr>
</table>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
</form>
</div>

</div>
<script type="text/javascript">
$(function(){
	var formoptions = {
		beforeSubmit: function() {
			$("#submitbtn").val("正在处理...");
			$("#submitbtn").attr("disabled","disabled");
		},
		success: function (msg) {
			 alert(msg);
			 if(msg == "分类添加成功！")
				$("#sform").resetForm();
			$("#submitbtn").val("提交");
			$("#submitbtn").attr("disabled","");
		}
	};
	$("#sform").ajaxForm(formoptions);
    function setuploadfile(){
        $("#ptinfo").html('<input class="upfile txt" type="file" style="width:280px;" name="categorycatethumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a>');
        $(".upfile").click();
    };
    function setinput(){
        $("#ptinfo").html('<input type="text" class="txt" style="width:200px;" name="categorycatethumb" /> 或者 <a href="javascript:void(0);" onclick="setuploadfile();" style="color:#0000cc;">上传图片</a>');
    };
});
</script>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>