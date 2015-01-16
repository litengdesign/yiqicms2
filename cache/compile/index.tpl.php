<?php /* Smarty version 2.6.25, created on 2015-01-16 11:17:13
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formaturl', 'index.tpl', 15, false),)), $this); ?>
<?php $this->assign('seotitle', $this->_tpl_vars['titlekeywords']); ?>
<?php $this->assign('seokeywords', $this->_tpl_vars['metakeywords']); ?>
<?php $this->assign('seodescription', $this->_tpl_vars['metadescription']); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<!--main start-->
	<div class="main">
		<div class="mainside">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "side.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
		<div class="mainbody">
			<div class="combox">
				<h2>公司简介</h2>				
				<div class="content">
					<?php echo $this->_tpl_vars['companysummary']; ?>

					<div class="fr"><a href="<?php echo formaturl(array('type' => 'article','siteurl' => $this->_tpl_vars['siteurl'],'name' => 'about'), $this);?>
">更多</a></div>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="combox">
				<h2>公司动态</h2>				
				<div class="content">
					<?php $this->assign('newslist', $this->_tpl_vars['articledata']->TakeArticleListByName('news',0,6)); ?>
					<?php $_from = $this->_tpl_vars['newslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['newsinfo']):
?>
						<div class="result_list">
			    		<span class="fr"><?php echo $this->_tpl_vars['newsinfo']->adddate; ?>
</span>
							<a href="<?php echo formaturl(array('type' => 'article','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['newsinfo']->filename), $this);?>
" title="<?php echo $this->_tpl_vars['newsinfo']->title; ?>
" target="_blank"><?php echo $this->_tpl_vars['newsinfo']->title; ?>
</a>
						</div>
						<div class="line"></div>
					<?php endforeach; endif; unset($_from); ?>
					<span class="fr"><a href="<?php echo formaturl(array('type' => 'category','siteurl' => $this->_tpl_vars['siteurl'],'name' => 'news'), $this);?>
">更多</a></span>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="combox">
				<h2>最新产品</h2>				
				<div class="content">
					<?php $this->assign('productlist', $this->_tpl_vars['productdata']->TakeProductList(0,0,4)); ?>
					<?php $_from = $this->_tpl_vars['productlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['productinfo']):
?>
						<div class="thumb"><a href="<?php echo formaturl(array('type' => 'product','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['productinfo']->filename), $this);?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['productinfo']->thumb; ?>
" title="<?php echo $this->_tpl_vars['productinfo']->name; ?>
" alt="<?php echo $this->_tpl_vars['productinfo']->name; ?>
"/></a><br/><a href="<?php echo formaturl(array('type' => 'product','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['productinfo']->filename), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['productinfo']->name; ?>
</a></div>
					<?php endforeach; endif; unset($_from); ?>
				</div>
			</div>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="combox" id="link">
				<h2>友情链接</h2>				
				<div class="content">
					<?php $this->assign('linklist', $this->_tpl_vars['linkdata']->GetLinkList()); ?>
					<?php $_from = $this->_tpl_vars['linklist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['linkinfo']):
?>
						<a href="<?php echo $this->_tpl_vars['linkinfo']->url; ?>
" title="<?php echo $this->_tpl_vars['linkinfo']->title; ?>
" target="_blank"><?php echo $this->_tpl_vars['linkinfo']->title; ?>
</a>
					<?php endforeach; endif; unset($_from); ?>
				</div>
			</div>
	</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>