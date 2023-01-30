
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



    {php}
        $sql = "SELECT * FROM odm_department";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
    {/php}
    <div class="">
        <select id="selected" class="" name ="dap">
            <option>Select An Department</option>
            {php} while($row = $result->fetch_assoc()) {{/php}
            <option  value="{php} echo $row['id'] {/php}">{php} echo $row["name"]{/php}</option>
            {php} } {/php}
        </select>

        <select id="selectedCategory" class="form-control m-2" name ="cat" disabled>
            <option >Select An Category</option>
        </select>  
        
        <select id="selectedSubCategory" class="form-control m-2" name ="subcat" disabled>
            <option >Select An Sub-category</option>
        </select>  
        <div id="txtHint" class="p-3"><b></b></div>
    </div>

    
    

    <script type="text/javascript">
    { literal}
    
    const myElement = document.getElementById("selected");
    const myElement2 = document.getElementById("selectedCategory");
    const myElement3 = document.getElementById("selectedSubCategory");
    console.log(myElement,myElement2,myElement3);
    myElement.addEventListener('change', (e) => {
        var a=0;
        a=myElement.value;
        showuser(a);
    })

    function showuser(data) {
         if (data == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        console.log("inside function");
            if (this.readyState == 4 && this.status == 200) {
                let ReturnData = JSON.parse(this.responseText);
                let CreateOptions = " <option >Select An Category</option>";
                for (const key in ReturnData) {
                    CreateOptions += `<option value=${key}>${ReturnData[key]}</option>`;
                }
                myElement2.disabled = false;
                myElement2.innerHTML = CreateOptions;
            }
        }
        xmlhttp.open("GET", "getuser.php?q=" +data, true);
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
                let CreateOptions = " <option >Select An Sub-category</option>";
                for (const key in ReturnData) {
                    CreateOptions += `<option value=${key}>${ReturnData[key]}</option>`;
                }
                myElement3.disabled = false;
                myElement3.innerHTML = CreateOptions;
            }
        }
        xmlhttp.open("GET", "getSubCategory.php?q=" + data, true);
        xmlhttp.send();
    }
    {/literal}
    </script>
    {php}
} else {
  echo "0 results";
}
$conn->close();
{/php}

    


    