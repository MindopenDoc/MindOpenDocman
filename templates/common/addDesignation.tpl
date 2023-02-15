<script type="text/javascript" src="functions.js"></script>
<table border="1" cellspacing="5" cellpadding="5">
        <tr>
            <td>S.no</td>
            <td>Designation</td>
            <td>Department</td>
        </tr>
        {foreach from=$design_perms_array  item="myitem"}
                <tr>
                    <td>{ $myitem.id }</td>
                    <td>{ $myitem.name  }</td>
                    <td>{ $myitem.dept_id  }</td>
                </tr>
        {/foreach}
</table>
<div class="container" style="margin:2rem">
    <form id="addeditform" name="main" action="addDesignation_V.php" method="POST" enctype="multipart/form-data" onsubmit="return checksec();">
        <input type="hidden" id="db_prefix" value="{$db_prefix|escape:'html'}" />
        <table border="0" cellspacing="5" cellpadding="5">
            <input id="i_value" type="hidden" name="i_value" value="{$i|escape:'html'}" /> <!-- CHM hidden and onsubmit added-->
            <tr>
                <td>
                    <label> Enter Designation </label>
                </td>
                <td colspan=3>
                    <input id="inptDesign" name="InputDesignation" type="text">
                </td>
                <td>
                    <select name="SelectDepartment">
                        {foreach from=$alldepartments  item="mydept"}
                            <option value="{$mydept.id}">
                                 {$mydept.name}  
                            </option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                    <td> </td>
                    <td id="errormsg"> </td>
                    <td> </td>
            </tr>
            <tr>
                <td colspan="3" align="center"><div class="buttons"><button class="positive" tabindex=7 type="Submit" id="submitbtn" name="submit" value="Add Designation">{$g_lang_submit}</button></div></td>
            </tr>
        </table>
    </form>
</div>

{literal}
    <script>
        $("#inptDesign").blur(function() {
            let inputDeign = $('#inptDesign').val(); 
            if(inputDeign.length<2 ){
                $('#submitbtn').prop('disabled', true);
                $('#errormsg').html("<b>The Entered Designation is not a Valid.</b>");
            }
            else if(inputDeign.length>30){
                $('#submitbtn').prop('disabled', true);
                $('#errormsg').html("<b>The Designation must be less than 30 characters.</b>");
            }
            else{
                $('#submitbtn').prop('disabled', false);
                $('#errormsg').html("");
            }
        })
    </script>
{/literal}