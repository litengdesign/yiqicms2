<?php /* Smarty version 2.6.25, created on 2015-01-08 15:32:26
         compiled from allproduct.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formaturl', 'allproduct.tpl', 18, false),array('modifier', 'truncate', 'allproduct.tpl', 41, false),)), $this); ?>
<?php $this->assign('seotitle', "产品中心"); ?>
<?php $this->assign('seokeywords', $this->_tpl_vars['metakeywords']); ?>
<?php $this->assign('seodescription', $this->_tpl_vars['metadescription']); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<!--main start-->
	<div class="content_stripes_container">	
    <div class="grid-container">
    	<h1>我们的产品</h1>
    </div>
	</div>
	<div class="grid-container">
		<div class="column">
			<h2>试验箱分类</h2>
			<ul class="list-inline">
			  <?php $this->assign('categorylist', $this->_tpl_vars['categorydata']->GetCategoryList(0,'product',2)); ?>
        <?php $_from = $this->_tpl_vars['categorylist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categoryinfo']):
?>
			    <li>
			      <a href="<?php echo formaturl(array('type' => 'category','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['categoryinfo']->filename), $this);?>
index.html"><?php echo $this->_tpl_vars['categoryinfo']->name; ?>
</a> 
			    </li>
			  <?php endforeach; endif; unset($_from); ?>	 			
			</ul>
		</div> 	
	</div>
	<div class="productlist">
	  <div class="grid-container">
				<ul>
					<?php $this->assign('productlist', $this->_tpl_vars['productdata']->TakeProductList(0,0,1000)); ?>
          <?php $_from = $this->_tpl_vars['productlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['productinfo']):
?>
					<li class="grid-33 pro-item">
					  <p class="pro-img">
							<a href="<?php echo formaturl(array('type' => 'product','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['productinfo']->filename), $this);?>
" target="_blank">
							  <img src="<?php echo $this->_tpl_vars['productinfo']->thumb; ?>
" title="<?php echo $this->_tpl_vars['productinfo']->name; ?>
" alt="<?php echo $this->_tpl_vars['productinfo']->name; ?>
"/
								 >
						  </a>
						</p>
						<h2>
						  <a href="<?php echo formaturl(array('type' => 'product','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['productinfo']->filename), $this);?>
" target="_blank"><?php echo $this->_tpl_vars['productinfo']->name; ?>

						  </a>
						</h2>
						<p>
						  <?php echo ((is_array($_tmp=$this->_tpl_vars['productinfo']->seodescription)) ? $this->_run_mod_handler('truncate', true, $_tmp, 80) : smarty_modifier_truncate($_tmp, 80)); ?>

						</p>
						<p>
						  <a href="<?php echo formaturl(array('type' => 'product','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['productinfo']->filename), $this);?>
" target="_blank">阅读更多</a>
						</p>
					</li>
					<?php endforeach; endif; unset($_from); ?>
			  </ul>
			</div>
	</div>
	<!--main end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>