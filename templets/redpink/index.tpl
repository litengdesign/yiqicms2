{assign var="seotitle" value=$titlekeywords}
{assign var="seokeywords" value=$metakeywords}
{assign var="seodescription" value=$metadescription}
{include file="header.tpl"}
	<div class="main">
<div class="mainleft">
<div class="combox">
<h2>最新产品</h2>
<div class="content">
{assign var="productlist" value=$productdata->TakeProductList(0,0,4)}
{foreach from=$productlist item=productinfo}
	<div class="thumb"><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}" target="_blank"><img src="{$productinfo->thumb}" title="{$productinfo->name}" alt="{$productinfo->name}"/></a><br/><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}" target="_blank">{$productinfo->name}</a></div>
{/foreach}
</div>
</div>
<div class="clear">&nbsp;</div>
<div class="comboxb" id="contact">
<h2>联系我们</h2>
<div class="content">
<ul>
{if $companyqq != "" && $companyqq != "-"}
<li>QQ:{$companyqq}</li>
{/if}
{if $companyphone != "" && $companyphone != "-"}
<li>电话:{$companyphone}</li>
{/if}
{if $companyemail != "" && $companyemail != "-"}
<li>电子邮箱:{$companyemail}</li>
{/if}
{if $companyaddr != "" && $companyaddr != "-"}
<li>地址:{$companyaddr}</li>
{/if}
<li><span class="fr"><a href="{formaturl type="article" siteurl=$siteurl name="contact"}">更多</a></span></li>
</ul>
</div>
</div>
<div class="comboxb" id="categories">
<h2>产品分类</h2>
<div class="content">
{if (count($categorylist) > 0)}
{foreach from=$categorylist item=categoryinfo}
<li><a href="{formaturl type="category" siteurl=$siteurl name=$categoryinfo->filename}">{$categoryinfo->name}</a></li>
{/foreach}
{else}
<li>暂无分类</li>
{/if}
</div>
</div>
</div>
<div class="mainright">
<div class="combox">
<h2>公司简介</h2>
<div class="content">
{$companysummary}
<div class="fr"><a href="{formaturl type="article" siteurl=$siteurl name="about"}">更多</a></div>
</div>
</div>
<div class="clear">&nbsp;</div>
<div class="comboxb">
<h2>公司新闻</h2>
<div class="content">
{assign var="newslist" value=$articledata->TakeArticleListByName("news",0,6)}
{foreach from=$newslist item=newsinfo}
	<div class="result_list">
	<span class="fr">{$newsinfo->adddate}</span>
		<a href="{formaturl type="article" siteurl=$siteurl name=$newsinfo->filename}" title="{$newsinfo->title}" target="_blank">{$newsinfo->title}</a>
	</div>
	<div class="line"></div>
{/foreach}
<span class="fr"><a href="{formaturl type="category" siteurl=$siteurl name="news"}">更多</a></span>
</div>
</div>

</div>
</div>
<div class="clear">&nbsp;</div>
<div class="comboxb" id="link">
	<h2>友情链接</h2>				
	<div class="content">
		{assign var="linklist" value=$linkdata->GetLinkList()}
		{foreach from=$linklist item=linkinfo}
			<a href="{$linkinfo->url}" title="{$linkinfo->title}" target="_blank">{$linkinfo->title}</a>
		{/foreach}
	</div>
</div>
{include file="footer.tpl"}