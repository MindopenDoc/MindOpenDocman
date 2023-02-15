<?php
    session_start();
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

    $flag=0;
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
    if(isset($_POST["dep"]) && (isset($_POST["cat"]) or isset($_POST["icat"])) && (isset($_POST["subcat"]) or isset($_POST["isubcat"]))){
        print_r($_POST);
        // die();
        // $subcat=$_POST['subcat'];
        $dap=$_POST['dep'];
        if(isset($_POST['icat']) && $_POST['icat']){
            $cat=$_POST['icat'];
        }
        else{
            $cat=$_POST['cat'];
        }
        if(isset($_POST['subcat']) && $_POST['subcat']){
            $subcat=$_POST['subcat'];
        }
        else{
            $subcat=$_POST['isubcat'];
        }
        $qw=0;
        if(is_numeric($cat)){
            $id="SELECT id FROM category WHERE id='$cat'";
            $result = $conn->query($id);
            $query="SELECT * FROM category WHERE id='$cat'";
            $result1 = $conn->query($query);
            while($row1 = $result1->fetch_assoc())
            {
                $cat=$row1['cat_name'];
                $qw=1;
            }
        }
        else{
        $id="SELECT * FROM category WHERE cat_name='$cat'";
        $result = $conn->query($id);
        while($row = $result->fetch_assoc())
            {
                $qw=1;
            }
        }
        if($qw){
            $id1="SELECT * FROM category WHERE cat_name='$cat'";
            $result1 = $conn->query($id1);
            while($row2= $result1->fetch_assoc())
            {
                {
                    $pr_subcat=$row2['id'];
                }
            }
            $sql2="INSERT INTO subcategory (pr_id,sub_cat_name) VALUES ($pr_subcat,'$subcat')";
            if (!$conn->query($sql2) === TRUE) {
                die("Error: " . $sql2. "<br>" . $conn->error);
         
           }
           
           header("Location:". get_base_url() ."/out.php?last_message=Successfully Added  subcategory");

        
        }
        else{
                $sql1="INSERT INTO category (pr_id,cat_name) VALUES ($dap,'$cat')";
                if (!$conn->query($sql1) === TRUE)
                {
                die("Error: " . $sql1. "<br>" . $conn->error);
                }
                $id="SELECT id FROM category WHERE cat_name='$cat'";
                $result = $conn->query($id);
       
            while($row = $result->fetch_assoc())
            {
                $pr_subcat=$row['id'];
            }
            $sql2="INSERT INTO subcategory (pr_id,sub_cat_name) VALUES ($pr_subcat,'$subcat')";
            if (!$conn->query($sql2) === TRUE) {
                die("Error: " . $sql2. "<br>" . $conn->error);
              }       
              header("Location:". get_base_url() ."/out.php?last_message=Successfully Added category and subcategory");
    }
    }
    else{
?>

<?php
        $last_message = isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '';

        draw_header("Add Category or subcategory", $last_message);
        $sql = "SELECT * FROM odm_department";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
    ?>
<style>
#selectedCategoryinput {
    display: none;
}

#selectedCategoryinput1 {
    display: none;
}
</style>
<form action="text.php" method="post" target="_blank" onsubmit="return validateForm()">
    <table>
        <tr>
            <td>Select Department</td>
            <td colspan="2">
                <select id="DeptSelected" class="form-control m-2" name="dep">
                    <option>Select An Department</option>
                    <?php while($row = $result->fetch_assoc()) {?>
                    <option value="<?php echo $row['id']  ?>"><?php echo $row["name"]?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Select / Add Category
            </td>
            <td>
                <select id="selectedCategory" class="form-control m-2" name="cat" disabled>
                    <option value="">Select An Category</option>
                </select>
            </td>
            <td>
                <input type="button" id="addinput" value="Add new Category" disabled />
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="1">
                <input type="text" id="selectedCategoryinput" name="icat" class="form-control m-2 "
                    placeholder="Enter category">
            </td>
            <td id="errormsg_cat">

            </td>
        </tr>
        <tr>
            <td>
                Select / Add SubCategory
            </td>
            <td>
                <select id="selectedSubCategory" class="form-control m-2" name="subcat" disabled>
                    <option value="">Select An Sub-category</option>
                </select>
            </td>
            <td>
                <input type="button" id="addinput2" value="Add new sub-Category" disabled />
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="1">
                <input type="text" id="selectedCategoryinput1" name="isubcat" class="form-control m-2 "
                    placeholder="Enter subcategory">
            </td>
            <td id="errormsg_sub_cat"></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <input id="submit1" type="submit" value="Submit" disabled>
            </td>
        </tr>
    </table>
</form>
<?php

    $query = "SELECT id,name FROM {$GLOBALS['CONFIG']['db_prefix']}department ORDER BY `id` ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $Dept_result = $stmt->fetchAll();
    
    $num_rows = $stmt->rowCount();
    $Dept_name = array();
    // Set the values for the hidden sub-select fields
    foreach ($Dept_result as $DeptData) {
        $dept_id = $DeptData['id'];
        $CategoryQuery = "SELECT id,pr_id,cat_name FROM category WHERE pr_id = $dept_id";
        $CategoryStmt = $pdo->prepare($CategoryQuery);
        $CategoryStmt->execute();
        $Category_result = $CategoryStmt->fetchAll();
        $Category_name  = array();
        foreach($Category_result as $CateData){
            $cat_id = $CateData['id'];
            $SubCategoryQuery = "SELECT id,pr_id,sub_cat_name FROM subcategory WHERE pr_id = $dept_id";
            $SubCategoryStmt = $pdo->prepare($SubCategoryQuery);
            $SubCategoryStmt->execute();
            $SubCategory_result = $SubCategoryStmt->fetchAll();
            $SubCategory_name  = array();
            foreach($SubCategory_result as $subCatData){
                array_push($SubCategory_name,array("id"=>$subCatData['id'],"name"=>$subCatData['sub_cat_name']));
            }
            array_push($Category_name,array("id"=>$CateData['id'],"name"=>$CateData['cat_name'],"sub_category"=>$SubCategory_name));
        }
        array_push($Dept_name,array("id"=>$DeptData['id'],"name"=>$DeptData['name'],"category"=>$Category_name));
    }
?>
<table border="3" cellspacing="5" cellpadding="5" style="width:100%">
    <tr>
        <th>Department</th>
        <th>Category</th>
    </tr>
 
    <?php foreach($Dept_name as $Dept) { ?>
    <tr>
        <td> <?php  echo $Dept['name']  ?></td>
        <td>
            <table  border="2"  cellspacing="4" cellpadding="4" style="width:100%">
                    <?php foreach($Dept['category'] as $Categ) { ?>
                    <tr><td>
                        <?php  echo $Categ['name'] ?>
                        </td>
                        <td>
                        <table  border="1"  cellspacing="3" cellpadding="3" style="width:100%">
                            <?php foreach($Categ['sub_category'] as $SubCateg) {?>
                            <tr><td><?php echo $SubCateg['name']  ?></td></tr>
                            <?php } ?>
                        </table>
                        </td>
                    </tr>
                    <?php } ?>
            </table>
            </td>
    </tr>
    <?php } ?>
</table>


<script>
const DeptElement = document.getElementById("DeptSelected");
const CategoryElement2 = document.getElementById("selectedCategory");
const SubCategoryElement3 = document.getElementById("selectedSubCategory");
const inputCategory = document.getElementById("addinput");
const inputSubCateory = document.getElementById("addinput2");
const inputBoxCategoryinput = document.getElementById("selectedCategoryinput");

function validateForm() {
    let x = document.forms["myForm"]["fname"].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
}

$("#selectedCategoryinput").blur(() => {
    evtVal = $("#selectedCategoryinput").val();
    if (evtVal.length < 2) {
        $('#submit1').prop('disabled', true);
        $('#errormsg_cat').html("<b>The Entered Category is not a Valid.</b>");
    } else if (evtVal.length > 30) {
        $('#submit1').prop('disabled', true);
        $('#errormsg_cat').html("<b>The Category must be less than 30 characters.</b>");
    } else {
        $('#submit1').prop('disabled', false);
        $('#errormsg_cat').html("");
    }
})
$("#selectedCategoryinput1").blur(() => {
    evtVal = $("#selectedCategoryinput1").val();
    console.log(evtVal);
    if (evtVal.length < 2) {
        $('#submit1').prop('disabled', true);
        $('#errormsg_sub_cat').html("<b>The Entered sub-Category is not a Valid.</b>");
    } else if (evtVal.length > 30) {
        $('#submit1').prop('disabled', true);
        $('#errormsg_sub_cat').html("<b>The sub-Category must be less than 30 characters.</b>");
    } else {
        $('#submit1').prop('disabled', false);
        $('#errormsg_sub_cat').html("");
    }
})


DeptElement.addEventListener('change', (e) => {
    let a = 0;
    a = CategoryElement2.value;
    inputCategory.disabled = false;
    showuser(DeptElement.value);
})
CategoryElement2.addEventListener('change', (e) => {
    inputSubCateory.disabled = false;
})
SubCategoryElement3.addEventListener('change', (e) => {
    submit1.disabled = false;
    inputSubCateory.disabled = false;
})
inputCategory.addEventListener('click', (e) => {
    selectedCategoryinput.style.display = 'inline'
})
inputSubCateory.addEventListener('click', (e) => {
    selectedCategoryinput1.style.display = 'inline'
    submit1.disabled = false;

})
inputBoxCategoryinput.addEventListener('keyup', (e) => {
    inputSubCateory.disabled = false;
})

function showuser(data) {
    if (data == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        console.log(this.readyState);
        if (this.readyState == 4 && this.status == 200) {
            let ReturnData = JSON.parse(this.responseText);
            let CreateOptions = " <option value='' >Select An Category</option>";
            for (const key in ReturnData) {
                CreateOptions += `<option value=${key}>${ReturnData[key]}</option>`;
            }
            CategoryElement2.disabled = false;
            CategoryElement2.innerHTML = CreateOptions;
            // document.getElementById("txtHint").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "getuser.php?q=" + data, true);
    xmlhttp.send();
}
CategoryElement2.addEventListener('change', (e) => {
    showSubCategory(CategoryElement2.value)
});

function showSubCategory(data) {
    if (data == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let ReturnData = JSON.parse(this.responseText);
            let CreateOptions = " <option value='' >Select An Sub-category</option>";
            for (const key in ReturnData) {
                CreateOptions += `<option value=${key}>${ReturnData[key]}</option>`;
            }
            SubCategoryElement3.disabled = false;
            inputCategory.disabled = true;

            SubCategoryElement3.innerHTML = CreateOptions;
        }
    }
    xmlhttp.open("GET", "getSubCategory.php?q=" + data, true);
    xmlhttp.send();
}
</script>
<?php
        draw_footer();
    ?>
<?php
} else {
  echo "0 results";
}
$conn->close();
    }
?>