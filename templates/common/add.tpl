
{literal}
    <style>
        .hiderows{
            display:none;
        }
        .hideTD{
        display: none;
        }
    </style>
    {/literal}
<script type="text/javascript" src="functions.js"></script>

<!-- file upload formu using ENCTYPE -->
<div class="table_wrapper">
<form id="addeditform" name="main" action="add.php" method="POST" enctype="multipart/form-data" onsubmit="return checksec();">
    <input type="hidden" id="db_prefix" value="{$db_prefix|escape:'html'}" />
<table border="0" cellspacing="5" cellpadding="5">
{assign var='i' value='0'}  
{foreach from=$t_name item=name name='loop1'}
    <input type="hidden" id="secondary{$i|escape:'html'}" name="secondary{$i|escape:'html'}" value="" /> <!-- CHM hidden and onsubmit added-->
    <input type="hidden" id="tablename{$i|escape:'html'}" name="tablename{$i|escape:'html'}" value="{$name|escape:'html'}" /> <!-- CHM hidden and onsubmit added-->
    {assign var='i' value=$i+1}
{/foreach}
    <input id="i_value" type="hidden" name="i_value" value="{$i|escape:'html'}" /> <!-- CHM hidden and onsubmit added-->
    <tr>
        <td>
            <a class="body" tabindex=1 href="help.html#Add_File_-_File_Location" onClick="return popup(this, 'Help')" style="text-decoration:none">{$g_lang_label_file_location}</a>
        </td>
        <td colspan=3>
            <input tabindex="0" name="file[]" type="file" multiple="multiple">
        </td>
    </tr>
    <tr>
        <td>
            <a class="body" href="help.html#Add_File_-_Description" onClick="return popup(this, 'Help')" style="text-decoration:none">{"Title"}</a>
        </td>
        <td colspan="3"><input tabindex="5" type="Text" name="title" size="50"></td>
    </tr>
{if $is_admin == true }
    <tr>
        <td>
            {$g_lang_editpage_assign_owner}
        </td>
        <td>
            <select name="file_owner">
            {foreach from=$avail_users item=user}
                <option value="{$user.id}" {$user.selected}> {$user.first_name|escape:'html'} {$user.last_name|escape:'html'}</option>
            {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td>
            {"Belongs to Department"}
        </td>
        <td>
               
            <select name="file_department" id="selected">
            {foreach from=$avail_depts item=dept}
                <option value="{$dept.id}" {$dept.selected}>{$dept.name|escape:'html'}</option>
            {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td><b>Belongs to Designation</b></td>
        <td>
            <select name="designation" id="selectedDesignation">
                {foreach from=$designation_list item=item name=designation_list}
                <option value={$item.id|escape}>{$item.name|escape:'html'}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    
    
{/if}    
    <tr class="hiderows">
        <td>
            <a class="body" href="help.html#Add_File_-_Category"  onClick="return popup(this, 'Help')" style="text-decoration:none">{$g_lang_category}</a>
        </td>
        <td colspan=3>
            <select tabindex=2 name="category" >
            {foreach from=$cats_array item=cat}
                <option value="{$cat.id}">{$cat.name|escape:'html'}</option>
            {/foreach}
            </select>
        </td>
    </tr>
    <!-- Set Department rights on the file -->
    <tr id="departmentSelect" class="hiderows">
        <td>
            <a class="body" href="help.html#Add_File_-_Department" onClick="return popup(this, 'Help')" style="text-decoration:none">{$g_lang_addpage_permissions}</a>
        </td>
        <td colspan=3>
            <hr />
            {include file='../../templates/common/_filePermissions.tpl'}
            <hr />
        </td>
          
    </tr>
      <tr id="departmentSelect">
          <td colspan=3>
            {include file='../../templates/common/text.tpl'}
        </td>
    </tr>     
    <tr>
        <td>
            <a class="body" href="help.html#Add_File_-_Description" onClick="return popup(this, 'Help')" style="text-decoration:none">{$g_lang_label_description}</a>
        </td>
        <td colspan="3"><input tabindex="5" type="Text" name="description" size="50"></td>
        
    </tr>
    <!-- anshuman code start -->
     <tr>
        <td>
            <a class="body" href="help.html#Add_File_-_Description" onClick="return popup(this, 'Help')" style="text-decoration:none">Keywords/Tags</a>
        </td>
        <td colspan="3">
        <input list="tags" id="key" tabindex="5" type="Text" name="keyword" size="50" onkeyup="showHint(this.value)">
        <datalist id="tags">
        <option>Keyword/tags</option>
        </datalist>
        </td>
        
    </tr>
    <!-- anshuman code end -->
    <tr class="hiderows">
        <td>
            <a class="body" href="help.html#Add_File_-_Comment" onClick="return popup(this, 'Help')" style="text-decoration:none">{$g_lang_label_comment}</a>
        </td>
        <td colspan="3"><textarea tabindex="6" name="comment" rows="4" onchange="this.value=enforceLength(this.value, 255);"></textarea></td>
        </tr>
    <!-- Add departement -->
<script>
{literal}
const qwer = document.getElementById("tags");
function showHint(data)
 {
   if (data == "")
        {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
         {
            if (this.readyState == 4 && this.status == 200)
             {
                let ReturnData = JSON.parse(this.responseText);
                let CreateOptions = " <option >Select An option</option>";
                for (const key in ReturnData)
                {
                    CreateOptions += `<option >${ReturnData[key]}</option>`;
                }
                qwer.innerHTML = CreateOptions;
            }
        }
        console.log("open");
        xmlhttp.open("GET", "gethint.php?q=" +data, true);
        xmlhttp.send();
        
    
}  
{/literal}
</script>
<script type="text/javascript" src="{$g_base_url}/templates/common/js/SelectDept_Design.js"></script>
<script type="text/javascript" src="{$g_base_url}/templates/common/js/permissionsWork.js"></script>
</div>