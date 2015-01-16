<?php /* Smarty version 2.6.25, created on 2015-01-16 11:17:13
         compiled from side.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'formaturl', 'side.tpl', 7, false),)), $this); ?>
			<div class="combox">
				<h2>产品目录</h2>
				<div class="content">
					<ul>
						<?php if (( count ( $this->_tpl_vars['categorylist'] ) > 0 )): ?>
						<?php $_from = $this->_tpl_vars['categorylist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['categoryinfo']):
?>
						<li><a href="<?php echo formaturl(array('type' => 'category','siteurl' => $this->_tpl_vars['siteurl'],'name' => $this->_tpl_vars['categoryinfo']->filename), $this);?>
"><?php echo $this->_tpl_vars['categoryinfo']->name; ?>
</a></li>
						<?php endforeach; endif; unset($_from); ?>
						<?php else: ?>
						<li>暂无分类</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
			<div class="combox">
				<h2>联系我们</h2>
				<div class="content">
					<ul>
						<?php if ($this->_tpl_vars['companyqq'] != "" && $this->_tpl_vars['companyqq'] != "-"): ?>
						<li>QQ:<?php echo $this->_tpl_vars['companyqq']; ?>
</li>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['companyphone'] != "" && $this->_tpl_vars['companyphone'] != "-"): ?>
						<li>电话:<?php echo $this->_tpl_vars['companyphone']; ?>
</li>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['companyemail'] != "" && $this->_tpl_vars['companyemail'] != "-"): ?>
						<li>电子邮箱:<?php echo $this->_tpl_vars['companyemail']; ?>
</li>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['companyaddr'] != "" && $this->_tpl_vars['companyaddr'] != "-"): ?>
						<li>地址:<?php echo $this->_tpl_vars['companyaddr']; ?>
</li>
						<?php endif; ?>
						<li><span class="fr"><a href="<?php echo formaturl(array('type' => 'article','siteurl' => $this->_tpl_vars['siteurl'],'name' => 'contact'), $this);?>
">更多</a></span></li>
					</ul>
				</div>
			</div>