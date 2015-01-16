<?php
require_once 'admin.inc.php';
require_once '../include/article.class.php';
require_once '../include/category.class.php';

$aid = $_GET['aid'];
$aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
$posttype = "article";
$articledata  = new Article();
$article = $articledata->GetArticle($aid,true);
if($article==null)
{
    header("location:article.php");exit();
}
$postmeta = $metadata->GetMetaList($posttype,$aid);
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
    $articletitle = $_POST['articletitle'];
    $articlecategory = $_POST['articlecategory'];
    $articleseotitle = $_POST["articleseotitle"];
    $articlekeywords = $_POST['articlekeywords'];
    $articlenewsthumb = $_POST["articlenewsthumb"];
    $articledescription = $_POST['articledescription'];
    $articlecontent = $_POST['articlecontent'];
    $articletemplets = $_POST['articletemplets'];
    $articlefilename = $_POST['articlefilename'];
	$articleadddate = $_POST['articleadddate'];
    if(empty($articletitle))
    {
        $articletitle = $article->title;
    }
    if(!is_numeric($articlecategory))
	{
	    $articlecategory = $article->cid;
	}
    if(!empty($_FILES["articlenewsthumb"]["name"]))
	{
	    require_once("../include/upload.class.php");
	    $filedirectory = YIQIROOT."/uploads/image";
	    $filename = date("ymdhis");
	    $filetype = $_FILES['articlenewsthumb']['type'];
	    $upload = new Upload;
	    $upload->set_max_size(1800000); 
	    $upload->set_directory($filedirectory);
	    $upload->set_tmp_name($_FILES['articlenewsthumb']['tmp_name']);
	    $upload->set_file_size($_FILES['articlenewsthumb']['size']);
	    $upload->set_file_ext($_FILES['articlenewsthumb']['name']); 
	    $upload->set_file_type($filetype); 
	    $upload->set_file_name($filename); 	    
	    $upload->start_copy(); 	    
	    if($upload->is_ok())
	    {
	        $articlenewsthumb = YIQIPATH."uploads/image/".$filename.'.'.$upload->user_file_ext;
	    }
	    else
	    {
	        exit($upload->error());
	    }
	}else if (isset($_POST['articlenewsthumb'])&&$_POST['articlenewsthumb']!=$article->newsthumb)
	{
		$articlenewsthumb = $_POST['articlenewsthumb'];
	}
	if(empty($articleseotitle))
	{
	    $articleseotitle = $article->seotitle;
	}
	if(empty($articlekeywords))
	{
	    $articlekeywords = $article->seokeywords;
	}
    if(empty($articledescription))
	{
	    $articledescription = $article->seodescription;
	}
	if(empty($articlecontent))
	{
	    $articlecontent = $article->content;
	}
	if(empty($articletemplets))
	{
	    $articletemplets = $article->templets;
	}
	if(empty($articlenewsthumb))
	{
		$articlenewsthumb = $article->newsthumb;
	}
	if(empty($articlefilename))
	{
	    $articlefilename = date("YmdHis");
	}
	$articlefilename = str_replace(" ","-",$articlefilename);
    $existfilename = $articledata->ExistFilename($articlefilename,true);
	if($existfilename == 1)
	{
	    if($articlefilename != $article->filename)
	    {
			if(strpos($articlefilename,"http://")!==0)
				exit("指定的文件名已经存在");
	    }
	}
	$nowdate = date("Y-m-d H:i:s");
	if(empty($articleadddate))
	{
		$articleadddate = $nowdate;
	}
	$articletemplets = str_replace("{style}/","",$articletemplets);
	$sql = "UPDATE yiqi_article SET title = '$articletitle',cid='$articlecategory' ,uid='$adminuserinfo->uid',seotitle='$articleseotitle' ,seokeywords='$articlekeywords' ,seodescription='$articledescription',content='$articlecontent' ,adddate='$articleadddate', lasteditdate='$nowdate',filename='$articlefilename' ,templets='$articletemplets' ,newsthumb='$articlenewsthumb' WHERE aid = '$aid' limit 1";
	$result = $yiqi_db->query(CheckSql($sql));
	if($result == 1)
	{
		$genehtml = getset("urlrewrite")->value;
		if ( $genehtml == "html" ) {
			$article = $articledata->GetArticle($aid);
			$article->content = mixkeyword($article->content);
			$tempinfo->assign("article",$article);
			if(!$tempinfo->template_exists($article->templets)) {
				exit("没有找到文章模板,请与管理员联系!");
			}
			$source = $tempinfo->fetch($article->templets);		
			$urlparam = array( 'name' => $article->filename, 'type' => 'article', 'generatehtml' => 1 );
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
					if($metadata->ExistMetaName($posttype,$varname[$id],$aid))
					{
						$sql = "UPDATE yiqi_meta SET metaname = '".$varname[$id]."',metavalue = '".$varvalue[$id]."' where metaid = '".$varid[$id]."'";
					}
					else
					{
						$sql = "INSERT INTO yiqi_meta (metaid,metatype,objectid,metaname,metavalue) VALUES (NULL,'$posttype','$aid','".$varname[$id]."','".$varvalue[$id]."')";	
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
					$sql = "DELETE FROM yiqi_meta WHERE metaname = '$delmetainfo' and metatype = '$posttype' and objectid = '$aid'";
					$yiqi_db->query(CheckSql($sql));
				}
			}
		}
	    exit("文章修改成功！");
	}
	else
	{
	    exit("文章修改失败，请与管理员联系！");
	}	
}
?>
<?php
$adminpagetitle = "编辑文章";
include("admin.header.php");?>
<link href="../images/cupertino/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../images/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript" src="../images/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="../images/jquery-ui-timepicker-addon-0.5.min.js"></script>
<script type="text/javascript" src="../images/date.format.js"></script>
<div class="main_body">
<form id="sform" action="" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">文章标题</td><td class="input"><input type="text" class="txt" name="articletitle" value="<?php echo $article->title;?>" /></td></tr>
<tr><td class="label">所属分类</td><td class="input"><select name="articlecategory">
<?php
$categorydata = new Category;
$categorylist = $categorydata->GetCategoryList(0,"article");
foreach($categorylist as $category)
{
    if($category->cid==$article->cid)
    {
	    echo "<option value=\"".$category->cid."\" selected=\"selected\">".$category->name."</option>";
    }
    else
    {
        echo "<option value=\"".$category->cid."\">".$category->name."</option>";
    }
}
?>
</select></td></tr>
<tr><td class="label">SEO标题</td><td class="input"><input type="text" class="txt" name="articleseotitle" value="<?php echo $article->seotitle;?>" /></td></tr>
<tr><td class="label">SEO关键词</td><td class="input"><input type="text" class="txt" name="articlekeywords" value="<?php echo $article->seokeywords;?>" /></td></tr>
<tr><td class="label">缩略图</td><td class="input"><?php 
    if($product->thumb == "-")
    {
        echo '您未上传缩略图,您可以上传图片 <div id="nwinfo"><input class="upfile txt" type="file" style="width:280px;" name="articlenewsthumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div>';
    }
    else
    {
        echo '您已经上传了缩略图,如果需要修改，请重新上传图片 <div id="nwinfo"><input class="upfile txt" type="file" style="width:280px;" name="articlenewsthumb" /> 或者 <a href="javascript:void(0);" onclick="setinput();" style="color:#0000cc;">输入地址</a></div>';
		echo '图片预览:<br /><a href="'.$article->newsthumb.'" target="_blank"><img src="'.$article->newsthumb.'" style="width:100px;height:100px;" ></a>';
    }
?></td></tr>
<tr><td class="label">SEO描述</td><td class="input"><textarea class="txt" name="articledescription" style="width:200px;height:110px;"><?php echo $article->seodescription;?></textarea></td></tr>
<tr><td class="label">发布时间</td><td class="input"><input id="pubdate" type="text" class="txt" name="articleadddate" value="<?php echo $article->adddate;?>" />&nbsp;&nbsp;定时发布文章，该时间为北京时间。</td></tr>
<tr><td class="label">自定义文件名</td>
	<td class="input"><input type="text" class="txt" name="articlefilename" value="<?php echo $article->filename;?>" />&nbsp;&nbsp;设置为http://开头，将链接到指定的地址。</td></tr>
<tr><td class="label">默认模板</td>
	<td class="input">
		<select class="txt" name="articletemplets" class="txt">
		<option>{style}/<?php echo $article->templets;?></option>
		<?php 
	
            echo "<option>{style}/about.tpl</option>
        	      <option>{style}/human.tpl</option>
        	      <option>{style}/article.tpl</option>";
        
        
		?>
	</select>&nbsp;about.tpl:关于我们模板/article.tpl:新闻模板/human.tpl:人力资源
	</td>
	</tr>
<tr><td class="label">文章内容</td><td class="input">
<textarea id="contentform" rows="1" cols="1" style="width:580px;height:360px;" name="articlecontent"><?php echo $article->content;?></textarea>
<!-- Load TinyMCE -->
<script type="text/javascript" src="tiny_mce/jquery.tinymce.js"></script>
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
	});
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