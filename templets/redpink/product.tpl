{assign var="seotitle" value=$product->seotitle}
{assign var="seokeywords" value=$product->seokeywords}
{assign var="seodescription" value=$product->seodescription}
{include file="header.tpl"}
<!--main start-->
	<div class="main">
	{assign var="catinfo" value=$categorydata->GetCategory($product->cid)}
		<div class="navigate">当前位置: <a href="/">首页</a> <code>&gt;</code> <a href="{formaturl type="category" siteurl=$siteurl name=$catinfo->filename}">{$catinfo->name}</a> <code>&gt;</code> {$product->name}</div>
		<div class="clear">&nbsp;</div>
		<div class="mainside">
			<div class="comboxb">
				<h2>最新产品</h2>
				<div class="content">
					<ul>
						{assign var="newproductlist" value=$productdata->TakeProductList($product->cid,0,6)}
						{foreach from=$newproductlist item=productinfo}
						<li><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}">{$productinfo->name}</a></li>
						{/foreach}						
					</ul>
				</div>
			</div>
		<div class="clear">&nbsp;</div>
			<div class="comboxb">
				<h2>相关产品</h2>
				<div class="content">
					<ul>
						{assign var="realtedproductlist" value=$productdata->TakeProductList($product->cid,0,6,"viewcount desc")}
						{foreach from=$realtedproductlist item=productinfo}
						<li><a href="{formaturl type="product" siteurl=$siteurl name=$productinfo->filename}">{$productinfo->name}</a></li>
						{/foreach}						
					</ul>
				</div>
			</div>
		<div class="clear">&nbsp;</div>
		{include file="side.tpl"}
		</div>
		<div class="mainbody">
			<div class="combox" id="content">
				<h1>{$product->name}</h1>
				<div class="attr">
					<div class="line"></div>
					<div class="fr">发布时间:{$product->adddate}</div>
				</div>
				<div class="clear">&nbsp;</div>
				<div class="content">{$product->content}</div>
			</div>
		</div>
	</div>
	<!--main end-->
{include file="footer.tpl"}