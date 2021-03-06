{assign var="seotitle" value=$article->seotitle}
{assign var="seokeywords" value=$article->seokeywords}
{assign var="seodescription" value=$article->seodescription}
{include file="header.tpl"}
	<!--main start-->
	<div class="main">
		{assign var="catinfo" value=$categorydata->GetCategory($article->cid)}
		<div class="navigate">当前位置: <a href="/">首页</a> <code>&gt;</code> <a href="{formaturl type="category" siteurl=$siteurl name=$catinfo->filename}">{$catinfo->name}</a> <code>&gt;</code> {$article->title}</div>
		<div class="clear">&nbsp;</div>
		<div class="mainside">
			<div class="comboxb">
				<h2>最新文章</h2>
				<div class="content">
					<ul>
						{assign var="newarticlelist" value=$articledata->TakeArticleList($article->cid,0,6)}
						{foreach from=$newarticlelist item=articleinfo}
						<li><a href="{formaturl type="article" siteurl=$siteurl name=$articleinfo->filename}">{$articleinfo->title}</a></li>
						{/foreach}						
					</ul>
				</div>
			</div>
		<div class="clear">&nbsp;</div>
			<div class="comboxb">
				<h2>相关文章</h2>
				<div class="content">
					<ul>
						{assign var="realtedarticlelist" value=$articledata->TakeArticleList($article->cid,0,6,"viewcount desc")}
						{foreach from=$realtedarticlelist item=articleinfo}
						<li><a href="{formaturl type="article" siteurl=$siteurl name=$articleinfo->filename}">{$articleinfo->title}</a></li>
						{/foreach}						
					</ul>
				</div>
			</div>
		<div class="clear">&nbsp;</div>
		{include file="side.tpl"}
		</div>
		<div class="mainbody">
			<div class="combox" id="content">
				<h1>{$article->title}</h1>
				<div class="clear"></div>
				<div class="fr">发布时间:{$article->adddate}</div>				
				<div class="clear">&nbsp;</div>
				<div class="content">
				{$article->content}				
				<div>
				<div class="clear">&nbsp;</div>
				{assign var=prevarticle value=$articledata->GetPrevArticle($article)}
				{if $prevarticle->title != ""}
				<p>上一篇:<a href="{formaturl type="article" siteurl=$siteurl name=$prevarticle->filename}">{$prevarticle->title}</a></p>
				{/if}
				{assign var=nextarticle value=$articledata->GetNextArticle($article)}
				{if $nextarticle->title != ""}
				<p>下一篇:<a href="{formaturl type="article" siteurl=$siteurl name=$nextarticle->filename}">{$nextarticle->title}</a></p>
				{/if}
				</div>
				</div>
			</div>
		</div>
	</div>
	<!--main end-->
{include file="footer.tpl"}