<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="http://localhost/opendocman-1.4.4-release/templates/tweeter/images/faviconMR.png">
    <title>MindRuby Doc  - Files List</title>
  </head>
  <body>
    
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-2">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <button class="btn parentChild " data-toggle="collapse" id="Department" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Department
                            </button>
                        </div>

                        <div id="collapseOne" class="collapse  px-4 py-2" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" value="Information Systems" >
                                <label class="form-check-label" for="exampleCheck1">Information Systems</label>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <button class="btn parentChild collapsed" id="Category" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Category
                            </button>
                        </div>
                        <div id="collapseFour" class="collapse p-4" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <button class="btn parentChild collapsed" id="sub_category" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                sub category
                            </button>
                        </div>
                        <div id="collapseFive" class="collapse p-4" aria-labelledby="headingFive" data-parent="#accordion">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <button class="btn parentChild collapsed" id="Author" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Author
                            </button>
                        </div>
                        <div id="collapseTwo" class="collapse p-4" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; Admin </label>    
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <button class="btn parentChild collapsed" id="FileCategory" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                File Category
                            </button>
                        </div>
                        <div id="collapseThree" class="collapse p-4" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSix">
                            <button class="btn parentChild collapsed" id="Designation" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Designation
                            </button>
                        </div>
                        <div id="collapseSix" class="collapse p-4" aria-labelledby="headingSix" data-parent="#accordion">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; category </label>    
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSeven">
                            <button class="btn parentChild collapsed" id="Status" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Status
                            </button>
                        </div>
                        <div id="collapseSeven" class="collapse p-4" aria-labelledby="headingSeven" data-parent="#accordion">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; Approved </label>    
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">             
                                <label class="form-check-label" for="inlineCheckbox1"> &nbsp;&nbsp; Not Approved </label>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <table class="table table-hover" id="hiddenTable" style="display:none;">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">File Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Date Modified</th>
                        </tr>
                    </thead>
                    <tbody id="data_table" > 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" 	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function SwitchCheckCase(checkState){
            switch(checkState){
                case 'Department': return "department";
                case 'Category': return "dep_category";
                case 'sub_category': return "sub_category";
                case 'Designation': return "Designation";
                case 'Author': return "owner";
                case 'Status': return "status";
                case 'FileCategory': return "category";
                default : return null;
            }
        }
        $(document).ready(function(){
            let allbtns = document.querySelectorAll(".parentChild");
            elemntArray = []
            allbtns.forEach(element => { elemntArray.push(element['attributes']['id'].value); });
            elemntArray.forEach(elemt=>{ 
                $(`#${elemt}`).click(function(){
                    currentElemt = SwitchCheckCase(elemt);
                    $.get(`Controller\\AjaxControl\\getAllTableLabels.php?currentElemt=${currentElemt}`, function(data, status){
                        data = JSON.parse(data);
                        // console.log("This is the Return value ::",data);
                        elements = "";
                        data.forEach(element => {
                            elements += `
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="${element.split(" ").join("")}" value="${element}" >
                                        <label class="form-check-label" for="${element.split(" ").join("")}">${element}</label>
                                    </div> `;
                        });
                        chldElmt = $(`#${elemt}`)[0]['attributes']['data-target'].value.substr(1);
                        $(`#${chldElmt}`).html(elements);
                        data.forEach(element => {
                            $(`#${element.split(" ").join("")}`).click(function(){                                
                                console.log("This is an event bind !!!",element);
                                console.log("this is that parent element !!",currentElemt);
                                parentElemt = currentElemt;
                                currentElemtforthis = element;
                                $.get(`Controller\\AjaxControl\\getSearchData.php?currentElemt=${currentElemtforthis}&parentElemt=${parentElemt}`, function(data, status){
                                    data = JSON.parse(data);
                                    console.log(data);
                                    // console.log(data[0]);
                                    data_table_str = "";
                                    if (data[0] === "No records found !"){
                                        console.log("This is no records found !!");
                                        data_table_str += "<tr><td>No Records Found !</td></tr>" ;
                                        document.getElementById("hiddenTable").style.display = "block" ; 
                                        document.getElementById("data_table").innerHTML = data_table_str ; //JSON.stringify(arr,null, 4);
                                        return;
                                    }
                                
                                    data.forEach((eachrow)=>{
                                        data_table_str += `<tr> 
                                                            <td>${eachrow['id'] }</td>
                                                            <td>${eachrow['realname'] }</td>
                                                            <td>${eachrow['description'] }</td>
                                                            <td>${eachrow['comment'] }</td>
                                                            <td>${eachrow['created'] }</td>
                                                            <td>${eachrow['comment'] }</td>
                                                        </tr>`;
                                    });  
                                    document.getElementById("hiddenTable").style.display = "block" ; 
                                    document.getElementById("data_table").innerHTML = data_table_str;
                                });
                            })
                        });
                    });
                });
            });
        })
    </script>

    </body>
</html>








