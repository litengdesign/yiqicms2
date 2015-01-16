<?php
require_once 'admin.inc.php';

$action = $_POST["action"];
if($action == "save")
{
    $companyname = $_POST["companyname"];
    $companysummary = $_POST["companysummary"];
    
    if(empty($companyname))
    {
        $companyphone = getset("companyname")->value;
    }
    if(empty($companysummary))
    {
        $companysummary = getset("companysummary")->value;
    }
    
    upset("companyname",$companyname);
    upset("companysummary",$companysummary);    
    exit("公司资料修改成功");
}
?>
<?php
$adminpagetitle = "公司资料设置";
include("admin.header.php");?>
<div class="main_body">
<form id="sform" action="company-option.php" method="post">
<table class="inputform" cellpadding="1" cellspacing="1">
<tr><td class="label">公司名称</td><td class="input"><input type="text" class="txt" name="companyname" value="<?php echo getset("companyname")->value;?>" /></td></tr>
<tr><td class="label">公司简介<span style="color:#ff0000;">（该简介是网站首页的公司简介，如果你想修改详细的公司简介资料，请到文章管理-文章列表里面修改。）</span></td><td class="input">
<textarea id="contentform" rows="1" cols="1" style="width:580px;height:360px;" name="companysummary"><?php echo getset("companysummary")->value;?></textarea>
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
			convert_urls : true,
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
				$("#submitbtn").val("提交");
				$("#submitbtn").attr("disabled","");
            }
        };
		$("#sform").ajaxForm(formoptions);
	});
</script>
<!-- /TinyMCE -->
</td></tr>
</table>
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