{gt text='My account' assign='templatetitle'}
{include file='User/menu.tpl'}

{foreach item='accountLink' from=$accountLinks}
<div class="z-accountlink" style="width:{math equation='100/x' x=$modvars.ZikulaUsersModule.accountitemsperrow format='%.0d'}%;">
    {if $modvars.ZikulaUsersModule.accountdisplaygraphics eq 1}
        {if isset($accountLink.set) && !empty($accountLink.set)}
            {assign var="iconset" value=$accountLink.set}
    {else}
            {assign var="iconset" value=null}
    {/if}
        <a href="{$accountLink.url|safetext}">{img src=$accountLink.icon modname=$accountLink.module set=$iconset}</a>
        <br />
    {/if}
    <a href="{$accountLink.url|safetext}">{$accountLink.title|safetext}</a>
</div>
{/foreach}
<br style="clear: left" />
