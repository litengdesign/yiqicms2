    {assign var="seotitle" value=$titlekeywords}
    {assign var="seokeywords" value=$metakeywords}
    {assign var="seodescription" value=$metadescription}
    {include file="header.tpl"}
    <DIV id=mainmain>
    <DIV id=main_con>
    <DIV class=web_bg>
    <DIV id=leftmain>
    <DIV id=left_1></DIV>
    <DIV id=left>
    <DIV class="mod_block">
    <H3 class=blk_t>搜索结果</H3>
    <DIV class=art_list_con>
    <UL>
    {assign var = "keywordslist" value = $productdata->SearchCategoryList($keywords)}
    {foreach from=$keywordslist item=keywordsinfo}
    <LI>
    <p>{$keywordsinfo->name}</p>
    <P class=l_title><a href="{formaturl siteurl=$siteurl type="product" name=$keywordsinfo->filename}" target="_blank"><img src="{$keywordsinfo->thumb}"/></a></P>
    <p>{$keywordsinfo->content}</p>
    <P class=n_time>{$keywordsinfo->lasteditdate}</P></LI>
    {/foreach}
    </UL>
    </DIV>
    <div class="clear"> </div>
    <DIV class=list_bot></DIV></DIV>
    </DIV>
    <DIV id=left_2></DIV></DIV>
    {include file="side.tpl"}
    <DIV class=blankbar></DIV></DIV></DIV>
    {include file="footer.tpl"}