<?php /* Smarty version 2.6.25, created on 2015-01-16 11:17:13
         compiled from footer.tpl */ ?>
	<div class="clear">&nbsp;</div>
	<!--footer start-->
	<div class="footer">
		<div class="fl">
		<?php $this->assign('footnavlist', $this->_tpl_vars['navdata']->TakeNavigateList("次导航",0,10)); ?>
		<?php $_from = $this->_tpl_vars['footnavlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['navinfo']):
?>
			<a href="<?php echo $this->_tpl_vars['navinfo']->url; ?>
" title="<?php echo $this->_tpl_vars['navinfo']->name; ?>
"><?php echo $this->_tpl_vars['navinfo']->name; ?>
</a>
		<?php endforeach; endif; unset($_from); ?>
		<?php echo $this->_tpl_vars['sitecopy']; ?>
 Powered by <a href="http://www.yiqicms.com/" target="_blank">YiqiCMS</a>-<a href="http://www.seowhy.com/" target="_blank">SEOWHY</a></div>
		<?php if ($this->_tpl_vars['siteicp'] != "-" && $this->_tpl_vars['siteicp'] != ""): ?>
		<div class="fr"><?php echo $this->_tpl_vars['siteicp']; ?>
</div>
		<?php endif; ?>
		<div style="display:none"><?php echo $this->_tpl_vars['sitestat']; ?>
</div>
	</div>
	<!--footer end--></div>

</body>

</html>