<?php
    session_start();

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
            echo "inside is_numeric";
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
        echo "inside string";
        $id="SELECT * FROM category WHERE cat_name='$cat'";
        $result = $conn->query($id);
        while($row = $result->fetch_assoc())
            {
                $qw=1;
            }
        }
        if($qw){
            echo "inside already exist";
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
           
           header("Location:http://localhost:8080/opendoccopy/out.php?last_message=Successfully Added category or subcategory");

        
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
              header("Location:http://localhost:8080/opendoccopy/out.php?last_message=Successfully Added category or subcategory");


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
        #selectedCategoryinput{
  display: none;
}
    #selectedCategoryinput1{
    display: none;
    }

        </style>
        <form action="text.php" method="post" target="_blank">
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
                            <option value="" >Select An Category</option>
                        </select>
                        </td>
                    <td>
                        <input type="button" id="addinput" value="Add new Category"  disabled />
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="text" id="selectedCategoryinput" name="icat" class="form-control m-2 " placeholder="Enter category" >
                    </td>
                </tr>
                <tr>
                    <td>
                        Select / Add SubCategory
                    </td>
                    <td>
                        <select id="selectedSubCategory" class="form-control m-2" name="subcat" disabled>
                            <option value="" >Select An Sub-category</option>
                        </select>  
                    </td>
                    <td>
                        <input type="button" id="addinput2" value="Add new sub-Category" disabled/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input type="text" id="selectedCategoryinput1" name="isubcat" class="form-control m-2 " placeholder="Enter subcategory" >
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <input id="submit1" type="submit" value="Submit" disabled>
                    </td>
                </tr>

            </table>

    <div class="container p-5   bg-secondary text-white">
        
        <div class="form-check-inline">
             
            <span></span>
            
        </div>
        
        
        <div class="form-check-inline">
            
            <span></span>
            
        </div>
        
        

    </div>
            </form>
    <script>
    const myElement = document.getElementById("selected");
    const myElement2 = document.getElementById("selectedCategory");
    const myElement3 = document.getElementById("selectedSubCategory");
    const myElement4 = document.getElementById("addinput");
    const myElement5 = document.getElementById("addinput2");
    const myElement6 = document.getElementById("selectedCategoryinput");
    myElement.addEventListener('change', (e) => {
        let a=0;
        a=myElement2.value;
        myElement4.disabled = false;
        showuser(myElement.value);
    })
    myElement2.addEventListener('change', (e) => {
        myElement5.disabled = false;

    })
    myElement3.addEventListener('change', (e) => {
        // myElement5.disabled = true;
        submit1.disabled = false;
        myElement5.disabled = false;

    })
    myElement4.addEventListener('click', (e) => {
        selectedCategoryinput.style.display='inline'
    })
    myElement5.addEventListener('click', (e) => {
        selectedCategoryinput1.style.display='inline'
        submit1.disabled = false;

    })
    myElement6.addEventListener('keyup', (e) => {
        myElement5.disabled = false;
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
                myElement4.disabled = true;

                myElement3.innerHTML = CreateOptions;
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

 
