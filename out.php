<?php
/*
 * Copyright (C) 2000-2021. Stephen Lawrence
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// (C) 2002, 2003, 2004 Stephen Lawrence Jr., Khoa Nguyen
// Display a list/ of all available documents that user has permission to view (with file status)

use Aura\Html\Escaper as e;

session_start();

$GLOBALS['state'] = 1;
require_once 'odm-load.php';

if (!isset($_SESSION['uid'])) {
    redirect_visitor();
}

$last_message = isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '';

draw_header(msg('label_file_listing'), $last_message);
sort_browser();

$user_obj = new User($_SESSION['uid'], $pdo);
// echo ($_SESSION['uid']);
if ($user_obj->isAdmin()) {
    $reviewIdCount = sizeof($user_obj->getAllRevieweeIds());
} elseif ($user_obj->isReviewer()) {
    $reviewIdCount = sizeof($user_obj->getRevieweeIds());
} else {
    $reviewIdCount = 0;
}
$GLOBALS['smarty']->assign('iadmin',$user_obj->isAdmin());
if ($reviewIdCount > 0) {
    echo '
    
    <div class="container">
    <a href="toBePublished.php?state=1"> <button class="btn-custom"><img src="images/exclamation.gif" /> '.msg('message_documents_waiting').
   ': ' . e::h($reviewIdCount)  . '</button></a> </a><br />';
   echo' </div> ';
}

$rejected_files_obj = $user_obj->getRejectedFileIds();

if (isset($rejected_files_obj[0]) && $rejected_files_obj[0] != null) {
    echo '<img src="images/exclamation_red.gif" /> <a href="rejects.php?state=1">'. msg('message_documents_rejected') . '</a>: ' .sizeof($rejected_files_obj) . '<br />';
}

$llen = $user_obj->getNumExpiredFiles();
if ($llen > 0) {
    echo '<img src="images/exclamation_red.gif"><a href="javascript:window.location=\'search.php?submit=submit&sort_by=id&where=author_locked_files&sort_order=asc&keyword=-1&exact_phrase=on\'">' .msg('message_documents_expired'). ': ' . e::h($llen) . '</a><br />';
}
// get a list of documents the user has "view" permission for
// get current user's information-->department



//set values
$user_perms = new UserPermission($_SESSION['uid'], $pdo);
//$start_P = getmicrotime();
$file_id_array = $user_perms->getViewableFileIds(true);
//$end_P = getmicrotime();
 
list_files($file_id_array, $user_perms, $GLOBALS['CONFIG']['dataDir'], false);

draw_footer();
//Fb::log('<br> <b> Load Page Time: ' . (getmicrotime() - $start_time) . ' </b>');
//echo '<br> <b> Load Permission Time: ' . ($end_P - $start_P) . ' </b>';	
//echo '<br> <b> Load Sort Time: ' . ($lsort_e - $lsort_b) . ' </b>';	
//echo '<br> <b> Load Table Time: ' . ($llist_e - $llist_b) . ' </b>';	
