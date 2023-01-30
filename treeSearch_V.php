<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>MindRuby Doc  - Files List</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
		  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
		  integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="src/css/bstreeview.css" rel="stylesheet">
    <link rel="shortcut icon" href="http://localhost/opendocman-1.4.4-release/templates/tweeter/images/faviconMR.png">
</head>

<body>
	<div class="container-fluid">
		<div class="content">
			<div class="row">
				<div class="col-md-3 pt-5">
					<div id="tree">
					</div>
                    <div id="tree12">
					</div>
				</div>
                <div class="col-md-9 p-4 pt-5" >
                <table class="table table-hover" id="hiddenTable" style="display:none;">
                    <thead>
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Description</th>
                        <th scope="col">Comment</th>
                        </tr>
                    </thead>
                    <tbody id="data_table" > 
                    </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
			integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
			integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
			crossorigin="anonymous"></script>

	<script src="src/js/bstreeview.js">
	</script>
	<script>
        function SwitchCheckCase(checkState){
            switch(checkState){
                case 'Department': return "department";
                case 'Category': return "dep_category";
                case 'sub category': return "sub_category";
                case 'Designation': return "Designation";
                case 'Author': return "owner";
                case 'Status': return "status";
                case 'File Category': return "category";
                default : return null;
            }
        }
        function SwitchGetIndexCase(checkState){
            switch(checkState){
                case 'Department': return 0;
                case 'Category': return 1;
                case 'sub category': return 2;
                case 'Designation': return 3;
                case 'Author': return 4;
                case 'Status': return  5;
                case 'File Category': return  6;
                default : return  null;
            }
        }
        let jsonTreeData = [					
				{
					icon: "fa fa-inbox fa-fw",
					text: "Department",
                    nodes:[
                    ]
				},
				{
					icon: "fa fa-inbox fa-fw",
					text: "Category",
                    nodes:[
                        {
                            icon: "",
                            text: "Word document" 
                        },
                        {
                            icon: "",
                            text: "Hypertext markup language "
                        },
                        {
                            icon: "",
                            text: "Microsoft excel spreadsheet file"
                        },
                        {
                            icon: "",
                            text: "Portable document format (PDF)"
                        }
                    ]
				},
				{
					icon: "fa fa-inbox fa-fw",
					text: "sub category",
                    nodes:[
                        {
                            icon:"",
                            text:"subcategory1"
                        },
                        {
                            icon:"",
                            text:"subcategory2"
                        },
                        {
                            icon:"",
                            text:"subcategory3"
                        }
                    ]
				},
				{
					icon: "fa fa-archive fa-fw",
					text: "Designation",
                    nodes:[
                        {
                            icon: "",
                            text: "software Engineer" 
                        },
                        {
                            icon: "",
                            text: "Quality assurance engineer"
                        },
                        {
                            icon: "",
                            text: "Product Manager"
                        },
                        {
                            icon: "",
                            text: "Software Architect"
                        }
                    ]
				},
				{
					icon: "fa fa-user-astronaut",
					text: "Author",
                    nodes:[
                        {
                            icon:"",
                            text:"Admin"
                        },
                        {
                            icon:"",
                            text:"Ritik"
                        },
                        {
                            icon:"",
                            text:"nikita"
                        }
                    ]
				},
				{
					icon: "fa fa-exclamation-triangle",
					text: "Status",
                    nodes:[
                        {
                            icon:"",
                            text:"Approved"
                        },
                        {
                            icon:"",
                            text:"Not Approved"
                        } 
                    ]
				},
				{
					icon: "fa fa-trash fa-fw",
					text: "File Category",
                    nodes:[
                        {
                            icon:"",
                            text:"category"
                        },
                        {
                            icon:"",
                            text:"Training Manual"
                        },
                        {
                            icon:"",
                            text:"Presentation"
                        }
                    ]
				}
			];
		function DrawBtree(jsonTreeDataParam,elemet) {
            console.log("this Drawbtree is called ?");
            // $("#tree").html("")
			$(elemet).bstreeview({
				data: jsonTreeDataParam,
                expandIcon: 'fa fa-angle-down fa-fw',
                collapseIcon: 'fa fa-angle-right fa-fw',
                indent: 1.25,
                parentsMarginLeft: '1.25rem',
                openNodeLinkOnNewTab: true
			});
		};
        // console.log("This is old node tree JSON :: ",jsonTreeData);
        DrawBtree(jsonTreeData,"#tree");


        $(document).ready(function(){
            let listGrp = document.querySelectorAll(".list-group-item");
            listGrp.forEach(function(elemt){
                elemt.addEventListener('click',(e)=>{
                    let parentElemt = e.srcElement.parentNode.previousSibling.innerText ;
                    let currentElemt = e.srcElement.innerText;
                    if (typeof parentElemt === 'undefined'){
                        currentIndex =  SwitchGetIndexCase(currentElemt);
                        currentElemt = SwitchCheckCase(currentElemt);
                        $.get(`Controller\\AjaxControl\\getAllTableLabels.php?currentElemt=${currentElemt}`, function(data, status){
                            data = JSON.parse(data);
                            console.log("This is the Return value ::",data);
                            let funcIntoJson = jsonTreeData;
                            vijay = [];
                            data.forEach(element => {
                                vijay.push({text : element});
                                
                            });
                            funcIntoJson[currentIndex]['nodes'] = vijay;
                            DrawBtree(funcIntoJson,"#tree12");
                            // console.log("This is new node tree JSON :: ",funcIntoJson);
                            // -------------------------------------------------------------------------------
                            // let datatableNode = document.getElementById("tree");
                            // datatableNode.innerHTML = "";
                            // datatableNode.classList.toggle("bstreeview");
                            // console.log(datatableNode.childNodes);
                            // -------------------------------------------------------------------------------


                            // console.log(funcIntoJson);
                        });
                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    }
                    else{
                        parentElemt = SwitchCheckCase(parentElemt); 
                        console.log(parentElemt);
                        if (parentElemt === null){
                            document.getElementById("hiddenTable").style.display = "block"; 
                            document.getElementById("data_table").innerHTML = "<tr><tr>No Records Available</td></tr>" ;
                            return;
                        }                  
                        $.get(`Controller\\AjaxControl\\getSearchData.php?currentElemt=${currentElemt}&parentElemt=${parentElemt}`, function(data, status){
                            data = JSON.parse(data);
                            console.log(data[0]);
                            data_table_str = "";
                            if (data[0] === "No records found !"){
                                data_table_str += "<tr><td>No Records Found !</td></tr>" ;
                                document.getElementById("hiddenTable").style.display = "block" ; 
                                document.getElementById("data_table").innerHTML = data_table_str ; //JSON.stringify(arr,null, 4);
                                return;
                            }
                           
                            data.forEach((eachrow)=>{
                                data_table_str += `<tr> 
                                                    <td>${eachrow['id'] }</td>
                                                    <td>${eachrow['description'] }</td>
                                                    <td>${eachrow['comment'] }</td>
                                                </tr>`;
                            });                           
                            document.getElementById("hiddenTable").style.display = "block" ; 
                            document.getElementById("data_table").innerHTML = data_table_str ; //JSON.stringify(arr,null, 4);
                        });
                    }
                })
            } );
        })
	</script>
</body>
</html>




 