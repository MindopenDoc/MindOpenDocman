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
    $url=get_base_url();
    
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
    if(isset($_POST["dep"]) && isset($_POST["cat"]) && isset($_POST["subcat"]) && isset($_POST["dep1"]) && isset($_POST["cat1"])){
            $d=$_POST["dep"];
            $c=$_POST["cat"];
            $sc=$_POST["subcat"];
            $d1=$_POST["dep1"];
            $c1=$_POST["cat1"];
            $sc1=$_POST["subcat1"];
            $query="UPDATE odm_data SET department=$d1,dep_category=$c1,sub_category=$sc1 WHERE (department=$d and dep_category=$c and sub_category=$sc);";
            if ($conn->query($query) === TRUE) {
                // header("location:/out.php?last_massage=subcategory move succesfully");
                $_SERVER['PHP_SELF'] = "$url/out.php?last_message=subcategory moved succesfully";
                header('Location: '.$_SERVER['PHP_SELF']);
                die;
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }

    }
    else{
?>

<?php
        $last_message = isset($_REQUEST['last_message']) ? $_REQUEST['last_message'] : '';

        draw_header("Move subcategory to another category", $last_message);
        $sql = "SELECT * FROM odm_department";
        $result = $conn->query($sql);
        $qer = $conn->query($sql);
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
<div class="container">
<div class="table_wrapper">
<table class="select_table">
  <tr>
<td>    <p>Select Departement>>Category you want to Move</p></td>

</tr>
<tr>
    <td>
<form action="move_subcat.php" method="post" target="_blank" style="margin:0px">
    <table>
     

        <tr>
            <td>Select Department</td>
            <td colspan="2">
                <select id="selected" class="form-control m-2" name="dep">
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
            
        </tr>
       
        <tr>
            <td colspan="3">
                <input id="submit1"  type="submit" value="Submit" disabled>
            </td>
        </tr>
                    
    </table>
</td>
<td style="padding-left:70px;">
    <table>
        <tr>
        
            <td>Select Department</td>
            <td colspan="2">
                <select id="selected1" class="form-control m-2" name="dep1">
                    <option>Select An Department</option>
                    <?php while($row11 = $qer->fetch_assoc()) {?>
                    <option value="<?php echo $row11['id']  ?>"><?php echo $row11["name"]?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Select / Add Category
            </td>
            <td>
                <select id="selectedCategory1" class="form-control m-2" name="cat1" disabled>
                    <option value="">Select An Category</option>
                </select>
            </td>
        </tr>
        <tr>
        <td>
                Select / Add SubCategory
            </td>
            <td>
                <select id="selectedSubCategory1" class="form-control m-2" name="subcat1" >
                    <option value="">Select An Sub-category</option>
                </select>
            </td>
                    </tr>

                    <tr>

                    <td>&nbsp;</td>
                    </tr>
                    
    </table>
</td>
                    </tr>
</form>
                    </table>
                    </div>  </div>
<script>
const myElement = document.getElementById("selected");
const myElement2 = document.getElementById("selectedCategory");
const myElement3 = document.getElementById("selectedSubCategory");
// const myElement4 = document.getElementById("addinput");
// const myElement5 = document.getElementById("addinput2");
// const myElement6 = document.getElementById("selectedCategoryinput");

// new code
const myElement7= document.getElementById("selected1");
const myElement8 = document.getElementById("selectedCategory1");
const myElement9 = document.getElementById("selectedSubCategory1");
myElement7.addEventListener('change', (e) => {
    showuser1(myElement7.value);
})
// new code end

myElement.addEventListener('change', (e) => {
    let a = 0;
    a = myElement2.value;
    // myElement4.disabled = false;
    showuser(myElement.value);
})
myElement2.addEventListener('change', (e) => {
    // myElement5.disabled = false;

})
myElement3.addEventListener('change', (e) => {
    // myElement5.disabled = true;
    // submit1.disabled = false;
    // myElement5.disabled = false;
    

})
myElement8.addEventListener('change', (e) => {
    submit1.disabled = false;
    showSubCategory1(myElement8.value)

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
            myElement2.disabled = false;
            myElement2.innerHTML = CreateOptions;
            // document.getElementById("txtHint").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "getuser.php?q=" + data, true);
    xmlhttp.send();
}
function showuser1(data) {
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
            myElement8.disabled = false;
            myElement8.innerHTML = CreateOptions;
            // document.getElementById("txtHint").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "getuser.php?q=" + data, true);
    xmlhttp.send();
}
myElement2.addEventListener('change', (e) => {
    showSubCategory(myElement2.value)
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
            myElement3.disabled = false;
            // myElement4.disabled = true;

            myElement3.innerHTML = CreateOptions;
        }
    }
    xmlhttp.open("GET", "getSubCategory.php?q=" + data, true);
    xmlhttp.send();
}
function showSubCategory1(data) {
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
            // myElement3.disabled = false;
            // myElement4.disabled = true;

            myElement9.innerHTML = CreateOptions;
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