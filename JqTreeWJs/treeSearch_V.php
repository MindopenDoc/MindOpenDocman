

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>JqTree devserver</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="jqtree.css" />
        <!-- Bootstrap -->
        <link href="../templates\tweeter\css\bootstrap.min.css" rel="stylesheet" media="screen">

    </head>
    <body>
        <div class="container">
            <div id="tree1"></div>
            <div id="ViewJSON"></div>
        </div>
    </body>
     
    <script src="../includes/jquery.min.js"></script>
    <script src="tree.jquery.js"></script>
    <script>
        var exampleData = [{
            name: "department",
            id: 123,
            // extra data
            intProperty: 1,
            strProperty: "1",
            children: [{
                name: "category",
                id: 125,
                intProperty: 2,
            }, {
                name: "subcategory",
                id: 126
            }
        ]
        },{
            name: "Author",
            id:125,
        },{
            name:"File Category",
            id:126,
        },{
            name:"Designation",
            id:127, 
        }];
        var value;
        

        
        
            function myDisplayer(some) {
                // console.warn(some);
                // document.getElementById("ViewJSON").innerHTML = JSON.stringify(some);// some;
                const $tree = $("#tree1");
                $tree.tree({
                    autoOpen: 0 ,
                    data: some,
                    // dragAndDrop: false,
                    // selectable: false,
                    onCanSelectNode: function(node) {
                        if (node.children.length == 0) {
                            // Nodes without children can be selected
                            // console.warn("PARENT",node);
                            let TableHeaders = [];
                            if( typeof node.name !== "undefined" && node.hasOwnProperty('parent')){
                                TableHeaders.push({"id":node.id,"name":node.name});
                            }
                            if(node.parent.name !==  "" && node.parent.hasOwnProperty('parent')){
                                TableHeaders.push({"id":node.parent.id,"name":node.parent.name});
                            }
                            if( node.parent.parent.name !==  "" && node.parent.parent.hasOwnProperty('parent')){
                                TableHeaders.push({"id":node.parent.parent.id,"name":node.parent.parent.name});
                            }
                            if( node.parent.parent.name !==  "" && node.parent.parent.hasOwnProperty('parent')){
                                TableHeaders.push({"id":node.parent.parent.parent.id,"name":node.parent.parent.parent.name});
                            }
                            const myJson =  JSON.stringify(TableHeaders);

                            $.get(`AJAX_REQUEST\\GetAllData.php?query=${myJson}`, (data, status)=>{
                                console.log(data);
                            });
                            return true;
                        }
                        else {
                            console.warn("CHILD");
                            // Nodes with children cannot be selected
                            return false;
                        }
                    }
                });
            }

            let myPromise = new Promise(function(myResolve, myReject) {
                $.get(`AJAX_REQUEST\\createJSON.php`, (data, status)=>{
                    value = JSON.parse(data);
                    // value = data;
                    if (value){
                        myResolve(value);
                    }
                    else{
                        myReject("There is some Error!");
                    }
                });
            });

            myPromise.then(
            function(value) {myDisplayer(value);},
            function(error) {myDisplayer(error);}
            );
       
        
    </script>
    
</html>
