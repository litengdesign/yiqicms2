<?php /* Smarty version 2.6.25, created on 2015-01-16 11:35:35
         compiled from header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo $this->_tpl_vars['seotitle']; ?>
 - <?php echo $this->_tpl_vars['sitename']; ?>
</title>
<?php if ($this->_tpl_vars['seokeywords'] != "-" && $this->_tpl_vars['seokeywords'] != ""): ?>
<meta name="keywords" content="<?php echo $this->_tpl_vars['seokeywords']; ?>
" />
<?php endif; ?>
<?php if ($this->_tpl_vars['seodescription'] != "-" && $this->_tpl_vars['seodescription'] != ""): ?>
<meta name="description" content="<?php echo $this->_tpl_vars['seodescription']; ?>
" />
<?php endif; ?>
<meta name="generator" content="<?php echo $this->_tpl_vars['yiqi_cms_version']; ?>
" />
<meta name="author" content="<?php echo $this->_tpl_vars['author']; ?>
" />
<meta name="copyright" content="<?php echo $this->_tpl_vars['copyright']; ?>
" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['siteurl']; ?>
/images/jq.js"></script>
<link href="<?php echo $this->_tpl_vars['siteurl']; ?>
/templets/<?php echo $this->_tpl_vars['templets']->directory; ?>
/images/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrap">
	<!--header start-->
	<div class="header">
		<div class="logo"><a href="<?php echo $this->_tpl_vars['siteurl']; ?>
"><img src="<?php echo $this->_tpl_vars['siteurl']; ?>
/templets/<?php echo $this->_tpl_vars['templets']->directory; ?>
/images/logo.gif"/></a></div>
		<div class="search">
		  <form action="<?php echo $this->_tpl_vars['siteurl']; ?>
/search.php" method="GET">
		    <input type="text" class="text" name="keywords" placeholder="产品搜索" />
		     <input type="Submit" name="submit" value="搜索" />
      </form>
    </div>
	</div>
	<!--menu end-->
	<div class="menu">
		<ul>
			<?php $this->assign('topnavlist', $this->_tpl_vars['navdata']->TakeNavigateList("顶部导航",0,10)); ?>
			<?php $_from = $this->_tpl_vars['topnavlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['navinfo']):
?>
				<li><a href="<?php echo $this->_tpl_vars['navinfo']->url; ?>
" title="<?php echo $this->_tpl_vars['navinfo']->name; ?>
"><?php echo $this->_tpl_vars['navinfo']->name; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<!--menu end-->
	<div class="clear">&nbsp;</div>
	<div class="slider"><img src="<?php echo $this->_tpl_vars['siteurl']; ?>
/templets/<?php echo $this->_tpl_vars['templets']->directory; ?>
/images/banner.jpg" alt="" title="" /> </div>
	<!--header end-->
	<div class="clear">&nbsp;</div>