

<div class="contianer" style="margin:2rem 0rem">
        <div class="row">
        <div class="span3">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <button class="btn parentChild " data-toggle="collapse" id="Department" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Department
                        </button>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input  pull-left" id="exampleCheck1" value="Information Systems" >
                            <label class="form-check-label" for="exampleCheck1">Information system</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <button class="btn parentChild collapsed" id="Category" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Category
                        </button>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pull-left" type="checkbox" id="inlineCheckbox1" value="option1">             
                            <label class="form-check-label pull-right" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <button class="btn parentChild collapsed" id="sub_category" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            sub category
                        </button>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pull-left" type="checkbox" id="inlineCheckbox1" value="option1">             
                            <label class="form-check-label pull-right" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <button class="btn parentChild collapsed" id="Author" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Author
                        </button>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pull-left" type="checkbox" id="inlineCheckbox1" value="option1">             
                            <label class="form-check-label pull-right" for="inlineCheckbox1"> &nbsp;&nbsp; Admin </label>    
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <button class="btn parentChild collapsed" id="FileCategory" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            File Category
                        </button>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pull-left" type="checkbox" id="inlineCheckbox1" value="option1">             
                            <label class="form-check-label pull-right" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingSix">
                        <button class="btn parentChild collapsed" id="Designation" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Designation
                        </button>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pull-left" type="checkbox" id="inlineCheckbox1" value="option1">             
                            <label class="form-check-label pull-right" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input pull-left" type="checkbox" id="inlineCheckbox1" value="option1">             
                            <label class="form-check-label pull-right" for="inlineCheckbox1"> &nbsp;&nbsp; category1234 </label>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="span9">
        <div id="filetable_wrapper">
        <form name="table" method="post" action="{$smarty.server.PHP_SELF|escape:'html'}">
            <table id="filetable" class="display" border="0" cellpadding="1" cellspacing="1">
            <thead>
                <tr>
                    {if $showCheckBox}
                        <th class="sorting_desc_disabled sorting_asc_disabled"><input type="checkbox" id="checkall"/></th>
                    {/if}
                    <th class="sorting">ID</th>
                    <th>{$g_lang_label_view}</th>
                    <th class="sorting">{$g_lang_label_file_name}</th>
                    <th class="sorting">{$g_lang_label_description}</th>
                    <th class="sorting">{"keyword"}</th>
                    <th class="sorting">{$g_lang_label_rights}</th>
                    <th class="sorting">{$g_lang_label_created_date}</th>
                    <th class="sorting">{$g_lang_label_modified_date}</th>
                    <th class="sorting">{$g_lang_label_author}</th>
                    <th class="sorting">{$g_lang_label_department}</th>
                    <th class="sorting">{$g_lang_label_size}</th>
                    <th class="">{$g_lang_label_status}</th>
                </tr>
            </thead>
            <tbody id="data_table">
                {foreach from=$file_list_arr item=item name=file_list}
                <tr {if $item.lock eq true}class="gradeX"{/if} >
                    {if $item.showCheckbox eq '1'}
                        {assign var=form value=1}
                        <td><input type="checkbox" class="checkbox" value="{$item.id|escape:'html'}" name="checkbox[]"/></td>
                    {/if}
                    <td class="center">{$item.id|escape}</td>
                    <td class="center" style="width: 50px;">
                        {if $item.view_link eq 'none'}
                            &nbsp;
                        {else}
                            <a href="{$item.view_link|escape:'html'}">{$g_lang_outpage_view}</a></td>
                        {/if}
                    <td><a href="{$item.details_link|escape}">{$item.filename|escape:'html'}</a></td>
                    <td >{$item.description|escape:'html'}</td>
                    <td >{$item.keyword|escape:'html'}</td>
                    <td class="center">{$item.rights[0][1]|escape:'html'} | {$item.rights[1][1]|escape:'html'} | {$item.rights[2][1]|escape:'html'}</td>
                    <td>{$item.created_date|escape:'html'}</td>
                    <td>{$item.modified_date|escape:'html'}</td>
                    <td>{$item.owner_name|escape:'html'}</td>
                    <td>{$item.dept_name|escape:'html'}</td>
                    <td >{$item.filesize|escape:'html'}</td>
                    <td class="center">
                        {if $item.lock eq false}
                            <img src="{$g_base_url}/images/file_unlocked.png" alt="unlocked" />
                {else}
                            <img src="{$g_base_url}/images/file_locked.png" alt="locked" />
                        {/if}
                    </td>
                </tr>
                {/foreach}
            </tbody>
            <tfoot>
            <tr>
                {if $item.showCheckbox eq '1'}
                <th></th>
                {/if}
                    <th>ID</th>
                    <th>{$g_lang_label_view}</th>
                    <th>{$g_lang_label_file_name}</th>
                    <th>{$g_lang_label_description}</th>
                    <th>{$g_lang_label_rights}</th>
                    <th>{$g_lang_label_created_date}</th>
                    <th>{$g_lang_label_modified_date}</th>
                    <th>{$g_lang_label_author}</th>
                    <th>{$g_lang_label_department}</th>
                    <th>{$g_lang_label_size}</th>
                    <th>{$g_lang_label_status}</th>
                </tr>
            </tfoot>
            {if $form ne '1'}
        </form>
            {/if}
        </table>
        </div>
        {if $limit_reached}
            <div class="text-warning">{$g_lang_message_max_number_of_results}</div>
        {/if}
        <br />
         </div>
    </div>
    <div class="row">
            <div class="span10">
                <table class="table table-hover" id="hiddenTable" style="display:none;">
                    <thead>
                         <tr>
                            <th scope="col">Id</th>
                            <th scope="col">View</th>
                            <th scope="col">FileName</th>
                            <th scope="col">Description</th>
                            <th scope="col">Keyword</th>
                            <th scope="col">Rights</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Modified</th>
                            <th scope="col">Author</th>
                            <th scope="col">Department</th>
                            <th scope="col">Size </th>
                        </tr>
                    </thead>
                    <tbody id="data_table" > 
                    </tbody>
                </table>
            </div>
    </div>
</div>
