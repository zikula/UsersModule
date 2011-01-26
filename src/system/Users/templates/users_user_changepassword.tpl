{gt text='Password changer' assign='templatetitle'}
{include file='users_user_menu.tpl'}

{if $login}
    <div class="z-warningmsg">
        <p>{gt text="Before logging in, the site administrator has asked that you change the password for your account."}</p>
        {if $authentication_method.modname != 'Users'}<p>{gt text="Note: This changes the password for your account with the user name of '%1$s', here on this web site. It does not affect the password for any other method of logging in, such as the method you just used."  tag1=$user_obj.uname}</p>{/if}
        <p>{gt text="If you leave this page without successfully changing your password, then you will not be logged in."}</p>
    </div>
{/if}

<div class="z-informationmsg">
    <p>{gt text='To change your password, please enter your current password, and then enter a new password (you must enter the new password twice to ensure that you have typed it correctly).'}</p>
    {if $login}<p>{gt text='Once you have successfully changed your password, the log-in process will continue.'}</p>{/if}
</div>

<form id="users_user_changepassword" class="z-form" action="{modurl modname="Users" type="user" func="updatePassword"}" method="POST">
    <div>
        <input type="hidden" id="changepassword_csrftoken" name="csrftoken" value="{insert name='csrftoken'}" />
        <input type="hidden" id="usernamehidden" name="usernamehidden" value="{if $login}{$user_obj.uname}{else}{user}{/if}" />
        <fieldset>
            <legend>{gt text="Change password"}</legend>
            <div class="z-formrow">
                <label for="oldpassword">{gt text="Current password"}</label>
                <input type="password" id="oldpassword" name="oldpassword" class="{if isset($password_errors.oldpass) && !empty($password_errors.oldpass)}z-form-error{/if}" value="" />
                {if isset($password_errors.oldpass) && !empty($password_errors.oldpass)}
                <div class="z-formnote z-errormsg">
                    {foreach from=$password_errors.oldpass item='message' name='messages'}
                    <p>{$message}</p>
                    {/foreach}
                </div>
                {/if}
            </div>
            <div class="z-formrow">
                <label for="newpassword">{gt text="New password"}</label>
                <input name="newpassword" id="newpassword" type="password" class="{if isset($password_errors.reginfo_pass) && !empty($password_errors.reginfo_pass)}z-form-error{/if}" value="" />
                {if isset($password_errors.reginfo_pass) && !empty($password_errors.reginfo_pass)}
                <div class="z-formnote z-errormsg">
                    {foreach from=$password_errors.reginfo_pass item='message' name='messages'}
                    <p>{$message}</p>
                    {/foreach}
                </div>
                {/if}
                {if $modvars.Users.use_password_strength_meter eq 1}
                    {pageaddvar name='javascript' value='prototype'}
                    {pageaddvar name='javascript' value='system/Users/javascript/Zikula.Users.PassMeter.js'}
                    <script type="text/javascript">
                        var passmeter = new Zikula.Users.PassMeter('newpassword',{
                            username:'usernamehidden',
                            minLength: '{{$modvars.Users.minpass}}',
                            messages: {
                                username: '{{gt text="Password can not match the username, choose a different password."}}',
                                minLength: '{{gt text="The minimum length for user passwords is %s characters." tag1=$modvars.Users.minpass}}'
                            },
                            verdicts: [
                                '{{gt text="Weak"}}',
                                '{{gt text="Normal"}}',
                                '{{gt text="Strong"}}',
                                '{{gt text="Very Strong"}}'
                            ]
                        });
                    </script>
                {/if}
            </div>
            <div class="z-formrow">
                <label for="newpasswordconfirm">{gt text="New password (repeat for verification)"}</label>
                <input type="password" id="newpasswordconfirm" name="newpasswordconfirm" class="{if isset($password_errors.passagain) && !empty($password_errors.passagain)}z-form-error{/if}" value="" />
                {if isset($password_errors.passagain) && !empty($password_errors.passagain)}
                <div class="z-formnote z-errormsg">
                    {foreach from=$password_errors.passagain item='message' name='messages'}
                    <p>{$message}</p>
                    {/foreach}
                </div>
                {/if}
            </div>
            <div class="z-formrow">
                <label for="passreminder">{gt text="New password reminder"}</label>
                <input type="text" id="passreminder" name="passreminder" value="" class="{if isset($password_errors.reginfo_passreminder) && !empty($password_errors.reginfo_passreminder)}z-form-error{/if}" size="25" maxlength="128" />
                {if isset($password_errors.reginfo_passreminder) && !empty($password_errors.reginfo_passreminder)}
                <div class="z-formnote z-errormsg">
                    {foreach from=$password_errors.reginfo_passreminder item='message' name='messages'}
                    <p>{$message}</p>
                    {/foreach}
                </div>
                {/if}
                <div class="z-sub z-formnote">{gt text="Enter a word or a phrase that will remind you of your password."}</div>
                <div class="z-formnote z-warningmsg">{gt text="Notice: Do not use a word or phrase that will allow others to guess your password! Do not include your password or any part of your password here!"}</div>
            </div>
        </fieldset>
        <div class="z-formbuttons z-buttons">
            {if $login}
            {button src='button_ok.png' set='icons/extrasmall' __alt='Save and continue logging in' __title='Save and continue logging in' __text='Save and continue logging in'}
            {else}
            {button src='button_ok.png' set='icons/extrasmall' __alt='Save' __title='Save' __text='Save'}
            {/if}
            <a href="{modurl modname='Users' type='user' func='main'}" title="{gt text='Cancel'}">{img modname='core' src='button_cancel.png' set='icons/extrasmall' __alt='Cancel' __title='Cancel'} {gt text='Cancel'}</a>
        </div>
    </div>
</form>
