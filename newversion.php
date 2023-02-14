<?php
include('odm-load.php');
if (!isset($_SESSION['uid'])) {
    redirect_visitor();
}

include('udf_functions.php');
require_once("AccessLog_class.php");
require_once("File_class.php");
require_once('Reviewer_class.php');
require_once('Email_class.php');
    function get_base_url(){
        // We don't want to re-write the base_url value when we are being called by a plugin
        if(!preg_match('/plug-ins*/', $_SERVER['REQUEST_URI'])) {
            return sprintf(
                "%s://%s",
                isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                $_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])
            );
        } else {
            // Set the base url relative to the plug-ins folder when being called from there
            return "../../";
    
        }
    }
    
    $GLOBALS['state'] = 1;
    require_once 'odm-load.php';

$servername = "localhost";
$username = "opendocman";
$password = "ideavate123";
$dbname = "OpenDocMan";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}
//check if form is submitted
$last_message = (isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '');
draw_header(msg('Add New version'), $last_message);

if (isset($_POST['submit']))
{
    $pid=$_POST['file2'];
    $filename = $_FILES['file1']['name'];
    //upload file
    if($filename != '')
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg',  'gif'];
    
        //check if file type is valid
        if (in_array($ext, $allowed))
        {
            // get last record id
            $temp=0;
            $sql = 'select max(id) as id from tbl_files';
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {
                $row = mysqli_fetch_array($result);
                $filename = ($row['id']+1) . '-' . $filename;
            }
            else{
                $filename = '1' . '-' . $filename;
            }
            //set target directory
            $path = 'versionfile/';
                
            $created = @date('Y-m-d H:i:s');
            move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
            
            // insert file details into database
            $sql = "INSERT INTO tbl_files(filename, created,fid) VALUES('$filename', '$created','$pid')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
            header("Location:". get_base_url() ."/details.php?id=$pid&state=2&last_message = Successfully Added a new version of File");

        }
        else
        {
            header("Location: newversion.php?st=error");
        }
    }
    else
        header("Location: newversion.php");
}
?>
<?php

// fetch files
$sql = "select filename from tbl_files";
$result =  $conn->query($sql);

$request_id = (int) $_GET['pid'];
$file_data_obj = new FileData($request_id, $pdo);
$user_id = $_SESSION['uid'];

?>

<ul class="breadcrumb">
  <li> <?php echo $file_data_obj->getDeptName() ?> <span class="divider">/</span></li>
  <li><?php echo $file_data_obj->get_dep_category() ?> <span class="divider">/</span></li>
  <li><?php echo $file_data_obj->get_sub_category() ?> <span class="divider">/</span></li>
  <li class="active"><?php echo $file_data_obj->Title() ?></li>
</ul>

<div class="container" align="center">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 well">
        <form action="newversion.php" method="post" enctype="multipart/form-data">
            <legend>Version File to Upload:</legend>
            <div class="form-group">
                <table style="width:100%">
                    <tr>
                        <td>Select the version file : </td>
                        <td><input type="file" name="file1" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="file2" value="<?php echo $_GET['pid'];?>"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="user_id" value="<?php echo $user_id;?>"/></td>
                    </tr>
                    <tr>
                        <td>Enter the version : </td>
                        <td><input type="text" name="VersionNo" value=""/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="submit" value="submit" class="btn btn-info"/></td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                
            </div>
            <?php if(isset($_GET['st'])) { ?>
                <div class="alert alert-danger text-center">
                <?php if ($_GET['st'] == 'success') {
                        echo "File Uploaded Successfully!";
                    }
                    else
                    {
                        echo 'Invalid File Extension!';
                    } ?>
                </div>
            <?php } ?>
        </form>
        </div>
    </div>
    
    
</div>
<?php
        draw_footer();
    ?>