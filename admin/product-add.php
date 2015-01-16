<?php
require_once 'admin.inc.php';
require_once '../include/product.class.php';
require_once '../include/category.class.php';
$posttype = 'product';
$action = $_POST['action'];
if($action=='save')
{
    $productname = $_POST['productname'];
    $productcategory = $_POST['productcategory'];
    $productseotitle = $_POST["productseotitle"];
    $productkeywords = $_POST['productkeywords'];
    $productdescription = $_POST['productdescription'];
    $productcontent = $_POST['productcontent'];
    $producttemplets = $_POST['producttemplets'];
    $productfilename = $_POST['productfilename'];
	$productadddate = $_POST['productadddate'];
    $productthumb = "-";
    $productbigimg = "-";
    if(empty($productname))
    {
        exit("产品名称不能为空");
    }
    if(!is_numeric($productcategory) || $productcategory < 1)
	{
	    exit("请选择正确的产品分类");
	}
    if(!empty($_FILES["productthumb"]["name"]))
	{
	    require_once("../include/upload.class.php");
	    $filedirectory = YIQIROOT."/uploads/image";
	    $filename = date("ymdhis");
	    $filetype = $_FILES['productthumb']['type'];
	    $upload = new Upload;
	    $upload->set_max_size(1800000); 
	    $upload->set_directory($filedirectory);
	    $upload->set_tmp_name($_FILES['productthumb']['tmp_name']);
	    $upload->set_file_size($_FILES['productthumb']['size']);
	    $upload->set_file_ext($_FILES['productthumb']['name']); 
	    $upload->set_file_type($filetype); 
	    $upload->set_file_name($filename); 	    
	    $upload->start_copy(); 	    
	    if($upload->is_ok())
	    {
	        $productthumb = YIQIPATH."uploads/image/".$filename.'.'.$upload->user_file_ext;
	    }
	    else
	    {
	        exit($upload->error());
	    }
	}else if (isset($_POST['productthumb']))
	{
		$productthumb = $_POST['productthumb'];
	}

	if(empty($productseotitle))
	{
	    $productseotitle = $productname;
	}
	if(empty($productkeywords))
	{
	    $productkeywords = "-";
	}
    if(empty($productdescription))
	{
	    $productdescription = "-";
	}
	if(empty($productcontent))
	{
	    $productcontent="-";
	}

	if(empty($productfilename))
	{
	    $productfilename = "-";
	}
    if($productfilename == "-")
	{
	    $productfilename = date("YmdHis");
	}
	$productfilename = str_replace(" ","-",$productfilename);
    $productdata = new Product;
    $existfilename = $productdata->ExistFilename($productfilename,true);
	if($existfilename == 1)
	{
		if(strpos($productfilename,"http://")!==0)
			exit("指定的文件名已经存在");
	}
	$producttemplets = str_replace("{style}/","",$producttemplets);
	$nowdate = date("Y-m-d H:i:s");
	if(empty($productadddate))
	{
		$productadddate = $nowdate;
	}
	$sql = "INSERT INTO yiqi_product (pid ,name ,cid ,thumb,seotitle ,seokeywords ,seodescription,content ,adddate ,lasteditdate,filename ,templets,status)" .
		   "VALUES (NULL, '$productname', '$productcategory', '$productthumb','$productseotitle', '$productkeywords', '$productdescription', '$productcontent', '$productadddate', '$nowdate','$productfilename', '$producttemplets', 'ok')";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result == 1)
	{
		$pid = $yiqi_db->insert_id;
		$genehtml = getset("urlrewrite")->value;
		if ( $genehtml == "html" ) {
			$product = $productdata->GetProduct($pid);
			$product->content = mixkeyword($product->content);
			$tempinfo->assign("product",$product);
			if(!$tempinfo->template_exists($product->templets)) {
				exit("没有找到文章模板,请与管理员联系!");
			}
			$source = $tempinfo->fetch($product->templets);		
			$cachedata->WriteFileCache(YIQIROOT."/".$fileurl, $source, true);
		}
		//添加附加属性
		$idarr = $_POST["chk"];
		if(count($idarr) > 0)
		{
			foreach($idarr as $id)
			{
				$varname=$_POST["extname"];
				$varvalue=$_POST["extvalue"];
				if(is_numeric($id))
				{
					$sql = "INSERT INTO yiqi_meta (metaid,metatype,objectid,metaname,metavalue) VALUES (NULL,'$posttype','$pid','".$varname[$id]."','".$varvalue[$id]."')";					
					$yiqi_db->query(CheckSql($sql));
				}
			}
		}
	    exit("产品添加成功！");
	}
	else
	{
	    exit("添加失败，请与管理员联系！");
	}	
}
?>
<?php
$adminpagetitle = "添加产品";
include("admin.header.php");?>
<link href="../images/cupertino/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../images/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript" src="../images/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="../images/jquery-ui-timepicker-addon-0.5.min.js"></script>
<script type="text/javascript" src="../images/date.format.js"></script>
<div class="main_body">
<form id="sform" action="product-add.php" method="post" enctype="multipart/form-data">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">产品名称</td><td class="input"><input type="text" class="txt" name="productname" /></td></tr>
<tr><td class="label">所属分类</td><td class="input"><select name="productcategory">
<option value="0">请选择</option><?php
$categorydata = new Category;
$categorylist = $categorydata->GetCategoryList(0,"product");
foreach($categorylist as $category)
{
	echo "<option value=\"".$category->cid."\">".$category->name."</option>";
}
?></select></td></tr>
<tr><td class="label">SEO标题</td><td class="input"><input type="text" class="txt" name="productseotitle" /></td></tr>
<tr><td class="label">SEO关键词</td><td class="input"><input type="text" class="txt" name="productkeywords" /></td></tr>
<tr><td class="label">SEO描述</td><td class="input"><textarea class="txt" name="productdescription" style="width:200px;height:110px;"></textarea></td></tr>
<tr><td class="label">缩略图</td><td class="input"><div id="ptinfo"><input class="upfile txt" type="file" style="width:280px;" name="productthumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div></td></tr>
<tr><td class="label">发布时间</td><td class="input"><input id="pubdate" type="text" class="txt" name="productadddate" value="<?php echo date("Y-m-d H:i:s"); ?>"  />&nbsp;&nbsp;定时发布产品，该时间为北京时间。</td></tr>
<tr><td class="label">自定义文件名</td><td class="input"><input type="text" class="txt" name="productfilename" />&nbsp;&nbsp;设置为http://开头，将链接到指定的地址。</td></tr>
<tr><td class="label">默认模板</td><td class="input"><input type="text" class="txt" name="producttemplets" value="{style}/product.tpl" /></td></tr>
<tr>
	<td class="label">产品介绍</td>
	<td class="input">
        <textarea id="contentform" rows="1" cols="1" style="width:580px;height:360px;" name="productcontent"></textarea>
    </td>
</tr>
<!-- Load TinyMCE -->
<script type="text/javascript" src="tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="tiny_mce/plugins/swampy_browser/sb.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$("#contentform").tinymce({
			// Location of TinyMCE script
			script_url : 'tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			language : "zh",
			width : "580",
			height : "360",
			add_unload_trigger : true,
			plugins : "Ybrowser,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "forecolor,backcolor,del,ins,|,cut,copy,paste,pastetext,pasteword,|,outdent,indent,attribs,table,|,link,unlink,anchor,image,Ybrowser,media,cleanup,|,preview,code,fullscreen",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
			relative_urls : false,
			convert_urls :true,
			remove_script_host : false
		});
       
		var formoptions = {
			beforeSubmit: function() {
				$("#submitbtn").val("正在处理...");
				$("#submitbtn").attr("disabled","disabled");
			},
			beforeSerialize: function($form, options) { 
				tinyMCE.triggerSave();                 
			},
            success: function (msg) {
                alert(msg);
				if(msg == "产品添加成功！")
				{
					$("#sform").resetForm();
					var now = new Date();
					$("#pubdate").val(now.format("yyyy-mm-dd HH:MM:ss"));
				}
				$("#submitbtn").val("提交");
				$("#submitbtn").attr("disabled","");
            }
        };
		$("#sform").ajaxForm(formoptions);
		$("#pubdate").datetimepicker({
			showSecond: true,
			timeFormat: 'hh:mm:ss',
			hour:<?php echo date('H');?>,
			minute:<?php echo date('i');?>,
			second:<?php echo date('s'); ?>,
			closeText:'完成',
			currentText:'当前时间'
		});		
		$("#extattr").hide();
		$('#extattrlink').toggle(function(){
				$("#extattr").show();
				$(this).text('隐藏附加属性');
			},function(){
				$("#extattr").hide();
				$(this).text('显示附加属性');
		});
		var extnum = 2;
		$("#addext").click(function(){
			$("#extattr").show();
			$("#extattrlink").text('隐藏附加属性');
			$("#exttable").append('<tr id="exttd'+extnum+'"><td class="label">附加属性'+extnum+'</td><td class="input"><input type="hidden" name="chk[]" value="'+extnum+'" />名称：<input type="text" class="txt" name="extname['+extnum+']" />&nbsp;&nbsp;值：<input type="text" class="txt" name="extvalue['+extnum+']" /> <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a></td></tr>');
			extnum++;
		});
	});
	function setuploadfile(){
		$("#ptinfo").html('<input class="upfile txt" type="file" style="width:280px;" name="productthumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a>');
		$(".upfile").click();
	};
	function setinput(){
		$("#ptinfo").html('<input type="text" class="txt" style="width:200px;" name="productthumb" /> 或者 <a href="javascript:void(0);" onclick="setuploadfile();" style="color:#0000cc;">上传图片</a>');
	};
</script>
<!-- /TinyMCE -->
<tr><td class="label"><a id="extattrlink" href="javascript:void(0);">显示附加属性</a></td><td class="input"><a href="javascript:void(0);" id="addext" class="fr">增加一个附加属性</a></td></tr>
</table>
<div id="extattr">
<table id="exttable" class="inputform" cellpadding="1" cellspacing="1" style="margin-top:10px;">
<tr id="exttd1"><td class="label">附加属性1</td><td class="input"><input type="hidden" name="chk[]" value="1" />名称：<input type="text" class="txt" name="extname[1]" />&nbsp;&nbsp;值：<textarea class="txt" name="extvalue[1]"></textarea></td></tr>
</table>
</div>
<div class="clear">&nbsp;</div>
<div class="inputsubmit"><input type="hidden" name="action" value="save" /><input id="submitbtn" type="submit" class="subtn" value="提交" /></div>
</form>
</div>

</div>

<div class="clear">&nbsp;</div>
<?php include("admin.footer.php");?>
</div>

</body>

</html>