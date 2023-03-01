
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
    <tr>
    <td> Select Document Category :     </td>
        <td>
        <select id="selectedCategory" class="form-control m-2" name ="cat" disabled>
            <option >Select An Category</option>
        </select>  
        </td>
    </tr>
    <tr>
    <td> Select Document Subcategory :     </td>
        <td>
        <select id="selectedSubCategory" class="form-control m-2" name ="subcat" disabled>
            <option >Select An Sub-category</option>
        </select>  
        <div id="txtHint" class="p-3"><b></b></div>
        </td>
    </tr>

    
    

    <script type="text/javascript">
    { literal}
    
    const myElement = document.getElementById("selected");
    const myElement2 = document.getElementById("selectedCategory");
    const myElement3 = document.getElementById("selectedSubCategory");
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
                if(ReturnData[0] === "0 results"){
                    console.warn("This is 0 cond!");
                    return
                }
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

    


    