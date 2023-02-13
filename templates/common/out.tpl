{php}
    $servername = "localhost";
    $username = "opendocman";
    $password = "ideavate123";
    $dbname = "OpenDocMan";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    }

{/php}

<div class="contianer" style="margin:2rem 0rem">
        <div class="row">
        <div class="span3">
            <div id="tree1"></div>
        </div>
        <div class="span9">
        <div id="filetable_wrapper">
        <form name="table" method="post" action="{$smarty.server.PHP_SELF|escape:'html'}">
            <table id="filetable" class="display" border="0" cellpadding="1" cellspacing="1">
            <thead>
                <tr id="SortView">
                    {if $showCheckBox}
                        <th class="sorting_desc_disabled sorting_asc_disabled"><input type="checkbox" id="checkall"/></th>
                    {/if}
                    <th class="sorting">ID</th>
                    <th>{$g_lang_label_view}</th>
                    <th class="sorting">{"Title"}</th>
                    <th class="sorting">{$g_lang_label_modified_date}</th>
                    <th class="sorting">{$g_lang_label_author}</th>
                    <th class="sorting">{$g_lang_label_department}</th>
                    <th class="sorting">{"Operations"}</th>
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
                    {assign var=foo value=$item.id}
                    {php}
                        $uname="";
                        $te=$_SESSION['uid'];
                        $qw="SELECT * FROM odm_user WHERE id=$te";
                        $result1 = $conn->query($qw);
                        if ($result1->num_rows > 0) {
                        while($row1 = $result1->fetch_assoc()) {
                        $uname=($row1['first_name'].','.$row1['last_name']);
                        }                
                        }                   
                        $fileid="";
                        $var = $this->get_template_vars('foo');
                        $query = "SELECT * FROM tbl_files WHERE fid=$var order by created DESC limit 1";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                        $fileid=$row['filename'];
                        }                
                        }
                        $GLOBALS['smarty']->assign('version_list', $fileid);
                        $GLOBALS['smarty']->assign('user_name', $uname);
                    {/php}
                    <td class="center" style="width: 50px;">
                    {if $item.view_link eq 'none'}
                        &nbsp;
                    {elseif $version_list eq ""}
                        <a href="{$item.view_link|escape:'html'}"><button class="btn btn-small btn-success"> {$g_lang_outpage_view} </button></a></td>
                    {else}
                        <a href="versionfile/{$version_list|escape:'html'}"><button class="btn btn-small btn-success"> {$g_lang_outpage_view} </button></a></td>
                    {/if}
                    {if $item.Title eq ''}
                        <td> <a href="{$item.details_link|escape}">{"View Details"}</a> </td>
                    {else}
                        <td><a href="{$item.details_link|escape}">{$item.Title|escape:'html'}</a></td>
                    {/if}
                    <td>{$item.modified_date|escape:'html'}</td>
                    <td>{$item.owner_name|escape:'html'}</td>
                    <td>{$item.dept_name|escape:'html'}</td>
                    {if $user_name eq $item.owner_name || ($iadmin eq 1)}
                        <td>
                            <a style="margin:0rem 0.5rem" href="{$g_base_url}/edit.php?id={$item.id}&state=3"><button class="btn btn-small btn-warning">Edit</button>  </a> 
                            <a style="margin:0rem 0.5rem" href="{$g_base_url}/delete.php?mode=tmpdel&id0={$item.id}"><button class="btn btn-small btn-danger">Delete</button></a>
                        </td>
                    {else}
                        <td>None</td>
                    {/if}
                </tr>
                {/foreach}
            </tbody>
            <tfoot id="footHideShow">
            <tr>
                {if $item.showCheckbox eq '1'}
                <th></th>
                {/if}
                    <th>ID</th>
                    <th>{$g_lang_label_view}</th>
                    <th>{"Title"}</th>
                    <th>{$g_lang_label_modified_date}</th>
                    <th>{$g_lang_label_author}</th>
                    <th>{$g_lang_label_department}</th>
                    <th>{"Operations"}</th>
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

<!-- /container -->   
     <script type="text/javascript" src="{$g_base_url}/templates/common/js/TreeJSCreate.js"></script>
    <!-- JQTREE JS -->

<script type="text/javascript" src="{$g_base_url}/templates/common/js/JqTree/tree.jquery.js"></script>
<script type="text/javascript" src="{$g_base_url}/templates/common/js/JqTree/tree.jquery.js.map"></script>