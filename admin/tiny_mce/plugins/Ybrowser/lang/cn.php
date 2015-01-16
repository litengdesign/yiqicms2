<?php
header("content-type:text/html; charset=utf-8");
/* Common */
$DLG['select_dir'] = 	"请选择目录!";
$DLG['dir_not_found'] = "没有找到目录";
$DLG['not_dir'] = 	"不是一个有效的目录";
$DLG['invalid_dir'] = 	"无效的目录!";
$DLG['no_permission'] = "文件目录没有写入的权限!";

/* Add Dir */
$DLG['invalid_dirname'] = 	"无效的目录名!";
$DLG['dir_exists'] =		"指定的文件夹已经存在";
$DLG['dir_add_success'] =	"文件夹创建成功";
$DLG['dir_add_failure'] =	"创建文件夹失败!";

/* File listing */
$DLG['enter'] =		"选择";
$DLG['delete'] =	"删除";
$DLG['insert'] =	"插入";
$DLG['download'] =	"下载";
$DLG['preview'] =	"预览";
$DLG['rename'] =	"重命名";
$DLG['dir'] = 		"上传目录";
$DLG['up'] = 		"上传";

/* Uploads */
$DLG['select_file'] =		"请选择需要上传的文件!";
$DLG['invalid_filename'] =	"无效的文件名!";
$DLG['file_exists'] =		"文件名已经存在!";
$DLG['invalid_img'] =		"您上传的图片格式无效，请重新选择!";
$DLG['invalid_file'] =		"您上传的文件格式无效，请重新选择!";
$DLG['upload_success'] = 	"上传成功";
$DLG['upload_failure'] =	"上传错误";
$DLG['upload_filename'] = 	"您上传的文件名为：";
$DLG['insert_uploaded'] = 	"文件已经上传成功，点击这里选择。";

$DLG['select_to_upload'] = 	"选择需要上传的文件";
$DLG['select_img_format'] = 	"选择图片格式";
$DLG['file_to_upload'] = 	"选择要上传的文件";
$DLG['as_file_name'] = 		"重命名";
$DLG['uploading'] = 		"上传中";
$DLG['upload'] = 		"上传";

$DLG['format'] = 	"格式";
$DLG['width'] = 	"宽度";
$DLG['height'] = 	"高度";
$DLG['scale_type'] = 	"缩略图类型";
$DLG['bg'] = 		"背景";
$DLG['custom'] = 	"自定义";

/* Delete */
$DLG['file_not_found'] = 	"没有找到文件!";
$DLG['dir_not_found'] = 	"没有找到文件夹!";
$DLG['not_file'] = 		"删除错误，因为不是一个有效的文件";
$DLG['not_dir'] = 		"无效的目录";
$DLG['file_delete_success'] = 	"文件删除成功";
$DLG['file_delete_failure'] = 	"不能删除指定的文件!";
$DLG['dir_delete_success'] = 	"文件夹删除成功";
$DLG['dir_delete_failure'] = 	"不能移动目录";
$DLG['dir_not_empty'] = 	"文件夹不是空的，不能移动";

/* Index */
$DLG['name'] =		"文件名";
$DLG['extension'] =	"类型/扩展名";
$DLG['size'] =		"大小";
$DLG['dimentions'] =	"尺寸";
$DLG['upload_image'] =	"上传图片";
$DLG['upload_file'] =	"上传文件";
$DLG['add_dir'] =	"创建文件夹";
$DLG['path'] =		"目录";
$DLG['view_mode'] =	"查看方式";

/* format listing  */
$DLG['select_format'] = 	"选择要上传或下载的文件格式";


/* Preview */
$DLG['not_supported_format'] = 	"该文件不支持预览";

/* Rename */
$DLG['rename_success'] = 	"重命名";
$DLG['rename_failure'] =	"重命名错误!";

/* Misc */
$JAVA_DLG = 'var Lang = {
	initiating :		"初始化...",
	loading :		"加载中...",
	done :			"完成",
	uploading :		"上传中...",
	loading_failure :	"加载内容错误",
	file_delete_confirm :	"确定要删除吗？",
	folder_name_prompt :	"请输入你想创建文件夹的名字",
	rename_prompt :		"重命名，请输入一个新名字",
	not_supported : 	"暂时不支持该操作",
	opt_enter :		"进入",
	opt_delete :		"删除",
	opt_insert :		"插入",
	opt_download :		"下载",
	opt_preview :		"预览",
	opt_rename :		"重命名",
	dir :			"上传目录",
	up :			"上传",
	upload_success : 	"上传完成",
	file_uploaded : "文件上传成功，点击这里选择。"
};';

$SCALE_TYPES = array
(
	'orginal' =>	"原始大小",
	'max' =>	"自适应大小",
	'addbg' =>	"设置背景",
	'crop' =>	"裁剪",
	'stretch' =>	"拉伸",
);
?>