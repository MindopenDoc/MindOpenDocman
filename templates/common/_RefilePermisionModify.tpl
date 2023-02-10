<script type="text/javascript" src="functions.js"></script>
{literal}
    <style>
        .hiderows {
            display: none;
        }

        .hideTD {
            display: none;
        }

        .PermissionTable {
            width: 70%;
        }
    </style>
{/literal}
<!-- file upload formu using ENCTYPE -->
<form id="EditPermissionform" name="EditPermissionform" class="display dataTable" action=""
    method="POST" enctype="multipart/form-data" onsubmit="return checksec(); ">
    <input type="hidden" id="db_prefix" value="{$db_prefix}" />
    <table border="0" cellspacing="5" cellpadding="5" class="PermissionTable">
        {assign var='i' value='0'}
        {foreach from=$t_name item=name name='loop1'}
            <input type="hidden" id="secondary{$i|escape}" name="secondary{$i|escape:'html'}" value="" />
            <!-- CHM hidden and onsubmit added-->
            <input type="hidden" id="tablename{$i|escape}" name="tablename{$i|escape:'html'}"
                value="{$name|escape:'html'}" /> <!-- CHM hidden and onsubmit added-->
            {assign var='i' value=$i+1}
        {/foreach}
        <input type="hidden" id="id" name="id" value="{$file_id|escape:'html'}" />
        <input id="i_value" type="hidden" name="i_value" value="{$i|escape:'html'}" />
        <!-- CHM hidden and onsubmit added-->
        <tr>
            <td>{$g_lang_label_name}</td>
            <td colspan="3"><b>{$realname|escape:'html'}</b></td>
        </tr>

        {if $is_admin == true }
            <tr class="hiderows">

                <td>
                    {$g_lang_editpage_assign_owner}
                </td>
                <td>
                    <select name="file_owner" id="FileOwner">
                        {foreach from=$avail_users|smarty:nodefaults item=user}
                            <option value="{$user.id|escape}" {if $pre_selected_owner eq $user.id}selected='selected' {/if}>
                                {$user.last_name|escape:'html'}, {$user.first_name|escape:'html'}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr class="hiderows">
                <td>
                    Designation
                </td>
                <td>

                    <select name="designation">
                        {foreach from=$designation_list|smarty:nodefaults item=design}
                            <option value="{$design.id|escape}" {if $pre_selected_designation eq $design.id}selected='selected'
                                {/if}>{$design.name|escape:'html'}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr class="hiderows">
                <td>
                    {$g_lang_editpage_assign_department}
                </td>
                <td>

                    <select name="file_department" id="file_department">
                        {foreach from=$avail_depts|smarty:nodefaults item=dept}
                            <option value="{$dept.id|escape}" {if $pre_selected_department eq $dept.id}selected='selected'
                                {/if}>{$dept.name|escape:'html'}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        {/if}
        <tr class="hiderows">
            <td>
                <a class="body" href="help.html#Add_File_-_Category" onClick="return popup(this, 'Help')"
                    style="text-decoration:none">{$g_lang_category}</a>
            </td>
            <td colspan=3>
                <select tabindex=2 name="category">
                    {foreach from=$cats_array|smarty:nodefaults item=cat}
                        <option value="{$cat.id|escape}" {if $pre_selected_category eq $cat.id}selected='selected' {/if}>
                            {$cat.name|escape:'html'}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <!-- Set Department rights on the file -->
        <tr id="departmentSelect">
            <td>
                <a class="body" href="help.html#Add_File_-_Department" onClick="return popup(this, 'Help')"
                    style="text-decoration:none">{$g_lang_addpage_permissions}</a>
            </td>
            <td colspan=3>
                <hr />
                {include file='../../templates/common/_FilePermsPageUpgrade.tpl'}
                <hr />
            </td>
        </tr>
        <tr class="hiderows">
            <td>
                <a class="body" href="help.html#Add_File_-_Description" onClick="return popup(this, 'Help')"
                    style="text-decoration:none">{$g_lang_label_description}</a>
            </td>
            <td colspan="3"><input tabindex="5" type="Text" name="description" size="50"
                    value="{$description|escape:'html'}" /></td>
        </tr>

        <tr class="hiderows">
            <td>
                <a class="body" href="help.html#Add_File_-_Comment" onClick="return popup(this, 'Help')"
                    style="text-decoration:none">{$g_lang_label_comment}</a>
            </td>
            <td colspan="3"><textarea tabindex="6" name="comment" rows="4"
                    onchange="this.value=enforceLength(this.value, 255);">{$comment|escape:'html'}</textarea></td>
        </tr>
        <tr>
            <td colspan="4" align="center"><div class="buttons"><button class="positive" type="Submit" name="submit" value="Update Document permissions">{$g_lang_button_save}</button></div></td>
        </tr>
    </table>
</form>
<script type="text/javascript" src="{$g_base_url}/templates/common/js/createPromise.js"></script>
<script type="text/javascript" src="{$g_base_url}/templates/common/js/refinePermission.js"></script>
{* <script type="text/javascript" src="{$g_base_url}/templates/common/js/testAnRequest.js"></script> *}
<input type="hidden" id="csrfp_hidden_data_token" value="csrfp_token">
<input type="hidden" id="csrfp_hidden_data_urls" value='[]'><script type="text/javascript" src="http://localhost/opendoccopy/vendor/owasp/csrf-protector-php/js/csrfprotector.js"></script>