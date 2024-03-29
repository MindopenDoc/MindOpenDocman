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
}, {
    name: "Author",
    id: 125,
}, {
    name: "File Category",
    id: 126,
}, {
    name: "Designation",
    id: 127,
}];
var value;

function SHOWErrorNotFound(){
    data_table_str= "";
    console.warn("No records found !!");
    data_table_str += `<tr ><td colspan="9" align="center"> <h2> No Records Found ! </h2></td></tr>` ;
    // document.getElementById("hiddenTable").style.display = "block" ; 
    // document.getElementById("SortView").style.display = "none" ;  
    document.getElementById("SortView").style.display = "none";
    // document.getElementById("footHideShow").style.display = "none";
    document.getElementById("data_table").innerHTML = data_table_str;
    return;
}


function myDisplayer(some) {
    // console.warn(some);
    // document.getElementById("ViewJSON").innerHTML = JSON.stringify(some);// some;
    const $tree = $("#tree1");
    $tree.tree({
        autoOpen: false,
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

                $.get(`Controller\\AjaxControl\\GetAllData.php?query=${myJson}`, (data, status)=>{
                    data_table_str = "";   
                    dataTableHeader = `
                                        <tr>
                                            <th>ID</th>
                                            <th>VIEW</th>
                                            <th>File Name</th>
                                            <th>Modified Date</th>
                                            <th>Author</th>
                                            <th>Department</th>
                                        </tr>`;                 
                    try {
                        data = JSON.parse(data);
                        if (data[0] === "No records found !"){
                            SHOWErrorNotFound();
                            return false;
                        }
                    }
                    catch(err) {
                        SHOWErrorNotFound();
                        return false;
                    }  

                    count = 1;                   
                    data.forEach((eachrow)=>{
                        data_table_str += `<tr class=" ${ count%2==0?"even":"odd"} "> 
                                            <td>${eachrow['id'] }</td>
                                            <td><a href="${eachrow['view_link'] }">View</a></td>
                                            <td>${eachrow['filename'] }</td>
                                            <td>${eachrow['modified_date'] }</td>
                                            <td>${eachrow['owner_name'] }</td>
                                            <td>${eachrow['dept_name'] }</td>
                                        </tr>`;
                        count += 1;
                    });   
                    document.getElementById("SortView").style.display = "table-row" ;  
                    // document.getElementById("footHideShow").style.display = "table-row" ;  
                    document.getElementById("SortView").innerHTML = dataTableHeader;
                    document.getElementById("footHideShow").innerHTML = dataTableHeader;
                    document.getElementById("data_table").innerHTML = data_table_str;
                });
                return true;
            }
            else {
                console.warn("CHILD");
                return false;
            }
        },
    });
    level0NodesOpen = [];
    level0CloseNodes = [];
    $('#tree1').on('click',function(){
        console.log("This is some change1!");
        
        var statOpt =   $tree.tree('getState');
        open_nodes = statOpt.open_nodes;
        let opennew =  open_nodes.filter(elp=>{
            return ((!level0NodesOpen.includes(elp) || level0CloseNodes.includes(elp)) && elp.toString().length === 1 );
        })
        if(opennew.length === 0){
            return;
        }
        console.log("This is open Len 1 new 129",opennew);
        let opennewlen2 =  open_nodes.filter(elp=>{
            return ((!level0NodesOpen.includes(elp) || level0CloseNodes.includes(elp)) && elp.toString().length !== 1);
        })
        console.log("This is some other len ",opennewlen2);
        // console.log("opennew :: ",opennew);
        if(level0CloseNodes.includes(opennew[0])){
            // console.log("------------>>>>>>131 ",opennew);
            level0CloseNodes = level0CloseNodes.filter(elp => {elp==opennew[0]});
        }
        // console.log("======>>>> level 0 closed ",level0CloseNodes);
        level0NodesOpen.forEach(elmo=>{
            if(elmo != opennew[0] && elmo.toString().length === 1){
                var node = $tree.tree('getNodeById', elmo);
                $tree.tree('closeNode', node);
                level0CloseNodes.push(elmo);
                $tree.tree('setState',elmo,0);
                // console.log("open Nodes :: 135 ::",statOpt.open_nodes);
            }
        })
        level0CloseNodes =  [...removeDuplicates(level0CloseNodes)];
        // console.warn("Closed Nodes !! ",level0CloseNodes);
        level0NodesOpen = [...open_nodes];
        // console.log("level0NodesOpen",level0NodesOpen);
        
    })
}
function removeDuplicates(arr) {
    return arr.filter((item, 
        index) => arr.indexOf(item) === index);
}
let myPromise = new Promise(function (myResolve, myReject) {
    $.get(`Controller\\AjaxControl\\createJSON.php`, (data, status) => {
        value = JSON.parse(data);
        // value = data;
        console.log(value);
        if (value) {
            myResolve(value);
        }
        else {
            myReject("There is some Error!");
        }
    });
});

myPromise.then(
    function (value) { myDisplayer(value); },
    function (error) { myDisplayer(error); }
    );
    
    // if(open_nodes.filter((elm)=>{
        //     if(elm.toString().length == 1 && level0NodesOpen.includes(elm)){
    //         return true;
    //     }
    // })){
        //     console.log("Alredy pushed");
        // }
        // else{
            // }
    // console.log("True o false",open_nodes.filter((elm)=>{
    //     return (elm.toString().length == 1 && level0NodesOpen.includes(elm))
    // }));