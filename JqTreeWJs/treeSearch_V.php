

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
    <!-- <script src="../templates/tweeter/js/bootstrap.min.js"></script> -->
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
                    autoOpen: 0,
                    data: some,
                    // dragAndDrop: false,
                    // selectable: false,
                    onCanSelectNode: function(node) {
                        if (node.children.length == 0) {
                            // Nodes without children can be selected
                            console.warn("PARENT",node);
                            if( typeof node.name !== "undefined" && node.hasOwnProperty('parent')){
                                console.log("1",node.name);
                            }
                            if(node.parent.name !==  "" && node.parent.hasOwnProperty('parent')){
                                console.log("12",node.parent.name);
                            }
                            if( node.parent.parent.name !==  "" && node.parent.parent.hasOwnProperty('parent')){
                                console.log("13",node.parent.parent.name);
                            }
                            if( node.parent.parent.name !==  "" && node.parent.parent.hasOwnProperty('parent')){
                                console.log("14",node.parent.parent.parent.name);
                            }
                            // console.log("Current :: ",node.name);
                            // console.log("iska parent Current :: ",node.parent.name);
                            // console.log("iska parent ka bhi parent Current :: ",node.parent.parent.name);
                            // console.log("iska parent ka bhi parent aur iska bhi parent Current :: ",node.parent.parent.parent.name);
                            // var element = node;
                            // count = 0;
                            // while(count<=3){
                            //     // if (typeof element.name == "undefined"){
                            //     //     break;
                            //     // }
                            //     console.log("element::",element.name);
                            //     // console.log("element Name::",element.name);
                            //     var element = node.parent;

                            //     count = count+1;
                            // }
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
