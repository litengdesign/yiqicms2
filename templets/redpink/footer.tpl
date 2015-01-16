<div class="clear">&nbsp;</div>
<div class="lineb">&nbsp;</div>
<!--footer start-->
<div class="footer">
<p>
{assign var="footnavlist" value=$navdata->TakeNavigateList("次导航",0,10)}
{foreach from=$footnavlist item=navinfo}
	<a href="{$navinfo->url}" title="{$navinfo->name}">{$navinfo->name}</a>
{/foreach}
</p>
<p>{$sitecopy}</p>
<p>Powered by <a href="http://www.yiqicms.com/" target="_blank">YiqiCMS</a>-<a href="http://www.seowhy.com/" target="_blank">SEOWHY</a></p>
<p>{if $siteicp != "-" && $siteicp != ""}
{$siteicp}
{/if}
</p>
<div style="display:none">{$sitestat}</div>
</div>
<!--footer end-->
</div>

</body>

</html>