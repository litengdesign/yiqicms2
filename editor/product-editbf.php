<?php
require_once 'admin.inc.php';
require_once '../include/product.class.php';
require_once '../include/category.class.php';

$pid = $_GET['pid'];
$pid = (isset($pid) && is_numeric($pid)) ? $pid : 0;
$posttype = 'product';
$productdata  = new Product();
$product = $productdata->GetProduct($pid,true);
if($product==null)
{
    header("location:product.php");exit();
}
$postmeta = $metadata->GetMetaList($posttype, $pid);
$pmcount = count($postmeta);
$metavalue = array();
if($pmcount>0)
{
	foreach($postmeta as $metainfo)
	{
		$metavalue[] = $metainfo->metaname;
	}
}
$action = $_POST['action'];
if($action=='save')
{
    $productname = $_POST['productname'];
    $productcategory = $_POST['productcategory'];
    $productseotitle = $_POST["productseotitle"];
    $productkeywords = $_POST['productkeywords'];
    $productdescription = $_POST['productdescription'];
    $productcontent = $_POST['productcontent'];
    $productpara = $_POST['productpara'];
    $producttemplets = $_POST['producttemplets'];
    $productthumb = $_POST["productthumb"];
    $productbigimg = $_POST["productbigimg"];
    $productfilename = $_POST["productfilename"];
	$productadddate = $_POST["productadddate"];
    if(empty($productname))
    {
        $productname = $product->name;
    }
    if(!is_numeric($productcategory))
	{
	    $productcategory = $product->cid;
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
	}else if (isset($_POST['productthumb'])&&$_POST['productthumb']!=$product->thumb)
	{
		$productthumb = $_POST['productthumb'];
	}
	
	//产品大图
	 if(!empty($_FILES["productbigimg"]["name"]))
	{
	    require_once("../include/upload.class.php");
	    $filedirectory = YIQIROOT."/uploads/image";
	    $filename = date("ymdhis");
	    $filetype = $_FILES['productbigimg']['type'];
	    $upload = new Upload;
	    $upload->set_max_size(1800000); 
	    $upload->set_directory($filedirectory);
	    $upload->set_tmp_name($_FILES['productbigimg']['tmp_name']);
	    $upload->set_file_size($_FILES['productbigimg']['size']);
	    $upload->set_file_ext($_FILES['productbigimg']['name']); 
	    $upload->set_file_type($filetype); 
	    $upload->set_file_name($filename); 	    
	    $upload->start_copy(); 	    
	    if($upload->is_ok())
	    {
	        $productbigimg = YIQIPATH."uploads/image/".$filename.'.'.$upload->user_file_ext;
	    }
	    else
	    {
	        exit($upload->error());
	    }
	}
	else if (isset($_POST['productbigimg'])&&$_POST['productbigimg']!=$product->bigimg)
	{
		$productbigimg = $_POST['productbigimg'];
	}
	//end
	if(empty($productseotitle))
	{
	    $productseotitle = $product->seotitle;
	}
	if(empty($productkeywords))
	{
	    $productkeywords = $product->seokeywords;
	}
    if(empty($productdescription))
	{
	    $productdescription = $product->seodescription;
	}
	if(empty($productcontent))
	{
	    $productcontent = $productcontent;
	}
	if(empty($productpara))
	{
	    $productpara = $productpara;
	}
	if(empty($productthumb))
	{
		$productthumb = $product->thumb;
	}
	if(empty($productbigimg))
	{
		$productbigimg = $product->bigimg;
	}
	
	if(empty($productfilename))
	{
	    $productfilename = date("YmdHis");
	}
	$productfilename = str_replace(" ","-",$productfilename);
    $existfilename = $productdata->ExistFilename($productfilename,true);
	if($existfilename == 1 && $productfilename != $product->filename)
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
	$sql = "UPDATE yiqi_product SET name='$productname' ,cid='$productcategory' ,thumb='$productthumb',bigimg='$productbigimg',seotitle='$productseotitle',seokeywords='$productkeywords' ,seodescription='$productdescription',content='$productcontent' ,para='$productpara' ,adddate = '$productadddate' ,lasteditdate='$nowdate' ,filename='$productfilename',templets='$producttemplets' WHERE pid ='$pid' limit 1 ";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result == 1)
	{
		$genehtml = getset("urlrewrite")->value;
		if ( $genehtml == "html" ) {
			$product = $productdata->GetProduct($pid);
			$product->content = mixkeyword($product->content);
			$tempinfo->assign("product",$product);
			if(!$tempinfo->template_exists($product->templets)) {
				exit("没有找到文章模板,请与管理员联系!");
			}
			$source = $tempinfo->fetch($product->templets);		
			$urlparam = array( 'name' => $product->filename, 'type' => 'product', 'generatehtml' => 1 );
			$fileurl = formaturl($urlparam);
			$cachedata->WriteFileCache(YIQIROOT."/".$fileurl, $source, true);
		}
		//编辑附加属性
		$delmeta = $metavalue;
		$idarr = $_POST["chk"];
		if(count($idarr) > 0)
		{
			foreach($idarr as $id)
			{
				$varid=$_POST["extid"];
				$varname=$_POST["extname"];
				$varvalue=$_POST["extvalue"];
				if(is_numeric($id))
				{
					if($metadata->ExistMetaName($posttype,$varname[$id],$pid))
					{
						$sql = "UPDATE yiqi_meta SET metaname = '".$varname[$id]."',metavalue = '".$varvalue[$id]."' where metaid = '".$varid[$id]."'";
					}
					else
					{
						$sql = "INSERT INTO yiqi_meta (metaid,metatype,objectid,metaname,metavalue) VALUES (NULL,'$posttype','$pid','".$varname[$id]."','".$varvalue[$id]."')";	
					}
					$yiqi_db->query(CheckSql($sql));
					$delmeta = array_remove_value($delmeta,$varname[$id]);
				}
			}
		}
		if(count($delmeta)>0)
		{
			foreach($delmeta as $delmetainfo)
			{
				if($delmetainfo != '' && $delmetainfo != '-')
				{
					$sql = "DELETE FROM yiqi_meta WHERE metaname = '$delmetainfo' and metatype = '$posttype' and objectid = '$pid'";
					$yiqi_db->query(CheckSql($sql));
				}
			}
		}
	    exit("产品编辑成功！");
	}
	else
	{
	    exit("编辑失败，请与管理员联系！");
	}
}
?>
<?php
$adminpagetitle = "编辑产品";
include("admin.header.php");?>
<link href="../images/cupertino/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../images/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript" src="../images/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="../images/jquery-ui-timepicker-addon-0.5.min.js"></script>
<script type="text/javascript" src="../images/date.format.js"></script>
<div class="main_body">
<form id="sform" action="" method="post" enctype="multipart/form-data">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">产品名称</td><td class="input"><input type="text" class="txt" name="productname" value="<?php echo $product->name;?>"/></td></tr>
<tr><td class="label">所属分类</td><td class="input"><select name="productcategory"><?php
$categorydata = new Category;
$categorylist = $categorydata->GetCategoryList(0,"product");
foreach($categorylist as $category)
{
    if($category->cid==$product->cid)
    {
	    echo "<option value=\"".$category->cid."\" selected=\"selected\">".$category->name."</option>";
    }
    else
    {
        echo "<option value=\"".$category->cid."\">".$category->name."</option>";
    }
}
?></select></td></tr>
<tr><td class="label">SEO标题</td><td class="input"><input type="text" class="txt" name="productseotitle" value="<?php echo $product->seotitle;?>" /></td></tr>
<tr><td class="label">SEO关键词</td><td class="input"><input type="text" class="txt" name="productkeywords" value="<?php echo $product->seokeywords;?>" /></td></tr>
<tr><td class="label">SEO描述</td><td class="input"><textarea class="txt" name="productdescription" style="width:200px;height:110px;"><?php echo $product->seodescription;?></textarea></td></tr>
<tr><td class="label">缩略图</td><td class="input"><?php 
    if($product->thumb == "-")
    {
        echo '您未上传缩略图,您可以上传图片 <div id="ptinfo"><input class="upfile txt" type="file" style="width:280px;" name="productthumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div>';
    }
    else
    {
        echo '您已经上传了缩略图,如果需要修改，请重新上传图片 <div id="ptinfo"><input class="upfile txt" type="file" style="width:280px;" name="productthumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div>';
		echo '图片预览:<br /><a href="'.$product->thumb.'" target="_blank"><img src="'.$product->thumb.'" style="width:100px;height:100px;" ></a>';
    }
?></td></tr>
<tr><td class="label">大图</td><td class="input"><?php 
    if($product->bigimg == "-")
    {
        echo '您未上传缩略图,您可以上传图片 <div id="ptinfo"><input class="upfile txt" type="file" style="width:280px;" name="productbigimg" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div>';
    }
    else
    {
        echo '您已经上传了缩略图,如果需要修改，请重新上传图片 <div id="ptinfo"><input class="upfile txt" type="file" style="width:280px;" name="productbigimg" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div>';
		echo '图片预览:<br /><a href="'.$product->bigimg.'" target="_blank"><img src="'.$product->bigimg.'" style="width:100px;height:100px;" ></a>';
    }
?></td></tr>
<tr><td class="label">发布时间</td><td class="input"><input id="pubdate" type="text" class="txt" name="productadddate" value="<?php echo $product->adddate;?>" />&nbsp;&nbsp;定时发布产品，该时间为北京时间。</td></tr>
<tr><td class="label">自定义文件名</td><td class="input"><input type="text" class="txt" name="productfilename" value="<?php echo $product->filename;?>" />&nbsp;&nbsp;设置为http://开头，将链接到指定的地址。</td></tr>
<tr><td class="label">默认模板</td><td class="input"><input type="text" class="txt" name="producttemplets" value="{style}/<?php echo $product->templets;?>" /></td></tr>
<tr>
	<td class="label">产品介绍</td>
	<td class="input">
       <textarea id="contentform" rows="1" cols="1" style="width:580px;height:360px;" name="productcontent"><?php echo $product->content;?></textarea>
   </td>
</tr>
<tr>
	<td class="label">详细参数</td>
	<td class="input">
       <textarea id="paraform" rows="1" cols="1" style="width:580px;height:360px;" name="productpara"><?php echo $product->para;?></textarea>
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
        $("#paraform").tinymce({
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
				var now = new Date();
				$("#pubdate").val(now.format("yyyy-mm-dd HH:MM:ss"));
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
		$('#extattrlink').toggle(function(){
				$("#extattr").hide();
				$(this).text('显示附加属性');
			},function(){
				$("#extattr").show();
				$(this).text('隐藏附加属性');				
		});
		var extnum = <?php echo $pmcount+1;?>;
		$("#addext").click(function(){
			$("#exttable").append('<tr id="exttd'+extnum+'"><td class="label">附加属性'+extnum+'</td><td class="input"><input type="hidden" name="chk[]" value="'+extnum+'" />名称：<input type="text" class="txt" name="extname['+extnum+']" />&nbsp;&nbsp;值：<textarea class="txt" name="extvalue['+extnum+']"></textarea> <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a></td></tr>');
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
</td></tr>
<tr><td class="label"><a id="extattrlink" href="javascript:void(0);">隐藏附加属性</a></td><td class="input"><a href="javascript:void(0);" id="addext" class="fr">增加一个附加属性</a></td></tr>
</table>
<div id="extattr">
<table id="exttable" class="inputform" cellpadding="1" cellspacing="1" style="margin-top:10px;">
<?php
	$pmc = 1;
	if($pmcount>0)
	{
		foreach($postmeta as $metainfo)
		{
			echo '<tr id="exttd'.$pmc.'"><td class="label">附加属性'.$pmc.'</td><td class="input"><input type="hidden" name="chk[]" value="'.$pmc.'" /><input type="hidden" name="extid['.$pmc.']" value="'.$metainfo->metaid.'"  />名称：<input type="text" class="txt" name="extname['.$pmc.']" value="'.$metainfo->metaname.'" />&nbsp;&nbsp;值：<textarea class="txt" name="extvalue['.$pmc.']">'.$metainfo->metavalue.'</textarea> <a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a></td></tr>';
			$pmc++;
		}
	}
?>
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