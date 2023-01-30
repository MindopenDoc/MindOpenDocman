<?php
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
    if(isset($_POST["cat"]) && isset($_POST["subcat"]) && isset($_POST["dep"])){
        $cat=$_POST['cat'];
        $subcat=$_POST['subcat'];
        $dap=$_POST['dep'];
        $id="SELECT id FROM category WHERE cat_name='$cat'";
        $result = $conn->query($id);
        if(!$result){
            while($row = $result->fetch_assoc())
            {
                $pr_subcat=$row['id'];
            }
            $sql2="INSERT INTO subcategory (pr_id,sub_cat_name) VALUES ($pr_subcat,'$subcat')";
            if (!$conn->query($sql2) === TRUE) {
                die("Error: " . $sql2. "<br>" . $conn->error);
         
           }
           header("Location:http://localhost:8080/opendocman/out.php");

        
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
            
              header("Location:http://localhost:8080/opendocman/out.php");

    }
        
    }
    else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>OpenDocman - Department</title>
</head>

<body>

<form action="add_cat.php" method="post" target="_blank">
    <?php
    
        $sql = "SELECT * FROM odm_department";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
    ?>
    <div class="container p-5   bg-secondary text-white">
        <select id="selected" class="form-control m-2" name="dep">
            <option>Select An Department</option>
            <?php while($row = $result->fetch_assoc()) {?>
            <option value="<?php echo $row['id']  ?>"><?php echo $row["name"]?></option>
            <?php } ?>
        </select>
                <input type="text" id="selectedCategory" name="cat" class="form-control m-2" placeholder="Enter category" disabled>
                <input type="text" id="selectedSubCategory" name="subcat" class="form-control m-2" placeholder="Enter subcategory" disabled>
                <input id="submit1" type="submit" value="Submit" disabled>
            </div>
        <script>
             const myElement = document.getElementById("selected");
             const myElement2 = document.getElementById("selectedCategory");
             const myElement3 = document.getElementById("selectedSubCategory");
             const myElement4 = document.getElementById("submit1");
             myElement.addEventListener('change', (e) => {
                myElement2.disabled = false;
            })
            myElement2.addEventListener('change', (e) => {
                myElement3.disabled = false;
            })
            myElement3.addEventListener('keyup', (e) => {
                myElement4.disabled = false;
            })
    </script>
    <?php
} else {
  echo "0 results";
}
    }
?>
</form>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

</body>

</html>