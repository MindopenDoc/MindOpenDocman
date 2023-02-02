

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
                console.warn(some);
                const $tree = $("#tree1");
                $tree.tree({
                    autoOpen: 0,
                    data: some,
                    dragAndDrop: true,
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
