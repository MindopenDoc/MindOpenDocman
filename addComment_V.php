 

<?php
    session_start();
    include('odm-load.php');

    if (!isset($_SESSION['uid'])) {
        redirect_visitor();
    }

    include('udf_functions.php');
    require_once("AccessLog_class.php");
    require_once("File_class.php");
    require_once('Reviewer_class.php');
    require_once('Email_class.php');

    $user_obj = new User($_SESSION['uid'], $pdo);

    if (!$user_obj->canAdd()) {
        redirect_visitor('out.php');
    }
    if (!isset($_REQUEST['submit']) && ('Add Comment' == $_POST['Comment'] ))
    {
        // addcomment into DB 
        $comment_data_query = "INSERT INTO 
        {$GLOBALS['CONFIG']['db_prefix']}user_comments (
            name,
            od_id,
            created_by,
            created_date
        )
            VALUES
        (
            :name,
            :od_id,
            :created_by,
            NOW()
        )";

        $comment_data_stmt = $pdo->prepare($comment_data_query);
        
        $comment_data_stmt->bindParam(':name', $_REQUEST['comment']);
        $comment_data_stmt->bindParam(':od_id', $_REQUEST['File_id']);
        $comment_data_stmt->bindParam(':created_by', $_SESSION['uid']);
        $comment_data_stmt->execute();
        header('Location:  details.php?id='.$_REQUEST['File_id'].'&state='.$_REQUEST['File_state'].'&last_message='.urlencode("Comment Added"));
        echo "<br>This is insert ";
    }elseif (!isset($_POST['submit']) && 'Delete' == $_POST['Comment']) {
        print_r($_POST);
        echo "<br>This is delete message";
        // Make sure they are an admin
        if (!$user_obj->isAdmin()) {
            header('Location: error.php?ec=4');
            exit;
        }
    
        // DELETE comment
        $query = "DELETE FROM {$GLOBALS['CONFIG']['db_prefix']}user_comments WHERE id = :id ";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $_POST['Comment_id']));
    
        // // back to main page
        header('Location:  details.php?id='.$_REQUEST['File_id'].'&state='.$_REQUEST['File_state'].'&last_message='.urlencode("comment_successfully_deleted"));
    }
    else{
        echo "this is an else condition";
        // header('Location:  details.php?id='.$_REQUEST['File_id'].'&state='.$_REQUEST['File_state'].'&last_message='.urlencode("Error while Adding comment"));
    }

    ?>
 