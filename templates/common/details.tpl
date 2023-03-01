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
 <div class="container">
 <table border="0" width=100% cellspacing="4" cellpadding="1" class="custom_table">
     <form name="data">
         <input type="hidden" name="to" value="{$file_detail.to_value|escape:'html'}" />
         <input type="hidden" name="subject" value="{$file_detail.subject_value|escape:'html'}" />
         <input type="hidden" name="comments" value="{$file_detail.comments_value|escape:'html'}" />
     </FORM>
     <tr>
         <td align="right">
             {if $file_detail.file_unlocked }
                 <img src="images/file_unlocked.png" alt="" border="0" align="absmiddle">
             {else}
                 <img src="images/file_locked.png" alt="" border="0" align="absmiddle">
             {/if}
         </td>
         {if $lastversion==""}
             <td align="left">
                 <span style="font-size: larger; ">{$file_detail.realname|escape:'html'}</span>
             </td>
         {else}
             <td align="left">
                 <span style="font-size: larger; ">{$lastversion}</span>
             </td>
         {/if}
     </tr>
     <tr>
         <th valign=top align=right>{"File Title"}:</th>
         <td>{$file_detail.Title|escape:'html'}</td>
     </tr>
     <tr>
         <th valign=top align=right>{$g_lang_category}:</th>
         <td>{$file_detail.category|escape:'html'}</td>
     </tr>

     {$file_detail.udf_details_display}

     <tr>
         <th valign=top align=right>{$g_lang_label_size}:</th>
         <td>{$file_detail.filesize|escape:'html'}</td>
     </tr>
     <tr>
         <th valign=top align=right>{$g_lang_label_created_date}:</th>
         <td> {$file_detail.created|escape:'html'}</td>
     </tr>
     
     <tr>
         <th valign=top align=right>File Assign Designation:</th>
         <td> {$file_detail.designation|escape:'html'}</td>
     </tr>
     <tr>
         <th valign=top align=right>{$g_lang_owner}:</th>
         <td>
             <a
                 href="mailto:{$file_detail.owner_email|escape:'html'}?Subject=Regarding%20your%20document:{$file_detail.realname|escape:'html'}&Body=Hello%20{$file_detail.owner_fullname|escape:'html'}">
                 {$file_detail.owner|escape:'html'}</a>
         </td>
     </tr>
     <tr>
         <th valign=top align=right>{$g_lang_label_description}:</th>
         <td> {$file_detail.description|escape:'html'}</td>
     </tr>
     <tr>
         <th valign=top align=right>{$g_lang_label_comment}:</th>
         <td> {$file_detail.comment|escape:'html'}</td>
     </tr>
     <tr>
         <th valign=top align=right>{$g_lang_revision}:</th>
         <td>
             <div id="details_revision">{$file_detail.revision|escape:'html'}</div>
         </td>
     </tr>
     {if $file_detail.file_under_review}
         <tr>
             <th valign=top align=right>{$g_lang_label_reviewer}:</th>
             <td> {$file_detail.reviewer|escape:'html'} (<a
                     href='javascript:showMessage()'>{$g_lang_message_reviewers_comments_re_rejection}</a>)</td>
         </tr>
     {/if}

     {if $file_detail.status gt 0}
         <tr>
             <th valign=top align=right>{$g_lang_detailspage_file_checked_out_to}:</th>
             <td><a
                     href="mailto:{$checkout_person_email|escape:'html'}?Subject=Regarding%20your%20checked-out%20document:{$file_detail.realname|escape:'html'}&Body=Hello%20{$checkout_person_full_name.$fullname[0]|escape:'html'}">
                     {$checkout_person_full_name[1]|escape:'html'}, {$checkout_person_full_name[0]|escape:'html'}</a></td>
         </tr>
     {/if}
     <!--anshuman code start -->
     


 {if $version_list}
     <tr>
         <td colspan="2">
             <table border="1" width=100% style="margin:2rem 0rem" cellspacing="4" cellpadding="1">
                 <tr>
                      
                    <th style="text-align: center;">{"Version"}</th>
                     <th style="text-align: center;">{"File name"}</th>
                     <th style="text-align: center;">{"Date Uploaded"}</th>
                     <th style="text-align: center;">{"Uploaded By"}</th>
                     <th style="text-align: center;">{"Control Options"}</th>
                 </tr>
                 {php}$prid = (int) $_GET['id'];{/php}
         </td>
     </tr>
     {foreach from=$version_list item=foo}
         <tr>

             
             <td style="text-align: center;">{$foo.version_number}</td>
             <td style="text-align: center;">{$foo.filename}</td>
             <td style="text-align: center;">{$foo.created|date_format:"%D"}</td>
             {assign var=qwe value=$foo.user_id}
             {assign var=filename2 value=$foo.filename}
             {php}
             $user_id1= $this->get_template_vars('qwe');
             $fname= $this->get_template_vars('filename2');
             $sql2="SELECT * FROM odm_user WHERE id=$user_id1";
             $result1 = $conn->query($sql2);
             if ($result1->num_rows > 0) {
             while($row1 = $result1->fetch_assoc()) {
             $uname=$row1['username'];
             }
             }
             $GLOBALS['smarty']->assign('user_name1', $uname);
             $arr1=(explode(".",$fname));
             if (end($arr1)=="pdf"){
             $GLOBALS['smarty']->assign('pdf1',"tr1");
             echo $fname;
             }
             else{
             $GLOBALS['smarty']->assign('pdf1',"");

             }
             {/php}
             <td style="text-align: center;">{$user_name1}</td>
             <td style="text-align: center;">
                 {if $pdf1 eq "tr1"}
                     <button class="positive"><a href="versionfile/{$foo.filename}" target="_blank">{"view"}</a></button>
                 </td>
             {else}
                 <button class="positive"><a href="versionfile/{$foo.filename}" download>{"Download"}</a></button></td>
             {/if}
         </tr>
     {/foreach}
     </table>
 {/if}
 <tr>
         <td colspan="2">
             <table border="1" width=100%  style="margin:2rem 0rem" cellspacing="4" cellpadding="1">
                 <tr>

                     <th style="text-align: center;">{"File name"}</th>
                     <th style="text-align: center;">{"Date Uploaded"}</th>
                     <th style="text-align: center;">{"Uploaded By"}</th>
                     <th style="text-align: center;">{"Control Options"}</th>
                 </tr>
                 {php}$prid = (int) $_GET['id'];{/php}
       
                <tr>
                <td style="text-align: center;"> <a
                        href="{$baseurl}/view_file.php?submit=view&id={php}echo$prid{/php}&mimetype=text%2Fplain"
                        target="_blank">{$file_detail.realname}</a></td>
                <td style="text-align: center;">{$file_detail.created|date_format:"%D"}</td>
                <td style="text-align: center;">{$file_detail.owner}</td>
                <td style="text-align: center;"> <a class="btn negative" href="{$history_link|escape}" target="_blank">{"view logs"}</a></td>
                </tr>
            </table>
        </td>
    </tr>
 <!--anshuman code end -->

 <!-- available actions -->
 <tr>
     <td colspan="2" align="center">
         <table border="0" cellspacing="5" cellpadding="5">
             <tr>
                 <!-- inner table begins -->
                 <!-- view option available at all time, place it outside the block -->
                 {if $view_link ne ''}
                     <td align="center">
                         <div class="buttons">
                             <a href="{$view_link|escape}" class="positive"><img src="images/view.png"
                                     alt="view" />{$g_lang_detailspage_view}</a>
                         </div>
                     </td>
                 {/if}
                 {if $check_out_link ne ''}
                     <td align="center">
                         <div class="buttons">
                             <a href="{$check_out_link|escape}" class="regular"><img src="images/check-out.png"
                                     alt="check out" />{$g_lang_detailspage_check_out}</a>
                         </div>
                     </td>
                 {/if}
                 {if $edit_link ne ''}
                     <td align="center">
                         <div class="buttons">
                             <a href="{$edit_link|escape}" class="regular"><img src="images/edit.png"
                                     alt="edit" />{$g_lang_detailspage_edit}</a>
                         </div>
                     </td>
                     <td align="center">
                         <div class="buttons">
                             <a href="javascript:my_delete()" class="negative"><img src="images/delete.png"
                                     alt="delete" />{$g_lang_detailspage_delete}</a>
                         </div>
                     </td>
                 {/if}
                 <td align="center">
                     <div class="buttons">
                         <a href="{$history_link|escape}" class="regular"><img src="images/history.png"
                                 alt="history" />{$g_lang_detailspage_history}</a>
                     </div>
                 </td>
                 {if $edit_link ne '' or $File_version_add_pemission eq 3}
                     <td align="center">
                         <div class="buttons">
                             <a href="{$g_base_url}/newversion.php?pid={$file_id}" class="regular"><button
                                     class="btn btn-small btn-success"> Add new version</button></a>
                         </div>
                     </td>
                 {/if}
                 {if $File_Owner_bool or $isadmin eq 'yes' }
                                             <td colspan="2" align="right"><a href="{$File_permission_alter|escape}"><button
                                    class="negative"> Edit permission</button></a> </td>
                   
                {/if}

             </tr>
             <!-- inner table ends -->
         </table>
     </td>
 </tr>
 </table>
 {if $depth_data_comments }
     <table border="1" width=100% cellspacing="4" cellpadding="1" style="margin:2rem 0rem">
         <tr>
             <td style="text-align: center;"> Comments </td>
             <td style="text-align: center;"> Comment by </td>
             <td style="text-align: center;"> Comment on </td>
             {if $isadmin eq 'yes'}
                 <td style="text-align: center;"> Delete Comment </td>
             {/if}
         </tr>
         {foreach from=$depth_data_comments|smarty:nodefaults item=depdatCom}
             <tr>
                 <td style="text-align: center;">{$depdatCom.name|escape}</td>
                 <td style="text-align: center;">{$depdatCom.created_by|escape}</td>
                 <td style="text-align: center;">{$depdatCom.created_date|escape}</td>
                 {if $isadmin eq 'yes'}
                     <td style="text-align: center;" valign="center">
                         <form action="addComment_V.php" name="deleteComment" method="POST">
                             <input type="hidden" value="{$file_id}" name="File_id" />
                             <input type="hidden" value="{$file_state}" name="File_state" />
                             <input type="hidden" value="{$depdatCom.id}" name="Comment_id" />
                             <input type="submit" value="Delete" name="Comment" />
                         </form>
                     </td>
                 {/if}
             </tr>
         {/foreach}
     </table>
 {else}
     <h4>No Comments yet... </h4>
 {/if}
 </div>
 </div>
 <div class="container" >
     <form id="addComment" action="addComment_V.php" name="addComment" method="POST" onsubmit="return checksec();">
         <table width=100% cellspacing="4" cellpadding="1">
             <tr>
                 <input type="hidden" value="{$file_id}" name="File_id" />
                 <input type="hidden" value="{$file_state}" name="File_state" />
             </tr>
             <tr>
                 <td style="text-align: center;"> Comment </td>
                 <td> <textarea type="text" name="comment" rows="5"
                         style="width:97%;padding:0.5rem; margin:1rem 1rem"> </textarea> </td>
             </tr>
             <tr>
                 <td colspan="2"> <input class="positive" style="float:right;" type="submit" value="Add Comment" name="Comment" /></td>
             </tr>
         </table>
     </form>
 </div>


 {literal}
     <script type="text/javascript">
         var message_window;
         var mesg_window_frm;

         function my_delete() {
             if(window.confirm("{/literal}{$g_lang_detailspage_are_sure}{literal}")) {	
             window.location = "{/literal}{$my_delete_link}{literal}";
         }
         }

         function sendFields() {
             mesg_window_frm = message_window.document.author_note_form;
             if (mesg_window_frm) {
                 mesg_window_frm.to.value = document.data.to.value;
                 mesg_window_frm.subject.value = document.data.subject.value;
                 mesg_window_frm.comments.value = document.data.comments.value;
             }
         }

         function showMessage() {
             message_window = window.open('{/literal}{$comments_link|escape}{literal}' , 'comment_wins', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=450,height=200');
             message_window.focus();
             setTimeout("sendFields();", 500);
         }
     </script>
{/literal}