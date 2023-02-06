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




function myDisplayer(some) {
    // console.warn(some);
    // document.getElementById("ViewJSON").innerHTML = JSON.stringify(some);// some;
    const $tree = $("#tree1");
    $tree.tree({
        autoOpen: 0,
        data: some,
        // dragAndDrop: false,
        // selectable: false,
        onCanSelectNode: function (node) {
            if (node.children.length == 0) {
                // Nodes without children can be selected
                console.warn("PARENT", node);
                if (typeof node.name !== "undefined" && node.hasOwnProperty('parent')) {
                    console.log("->>", node.name);
                    console.log("->>", node.id);
                }
                if (node.parent.name !== "" && node.parent.hasOwnProperty('parent')) {
                    console.log("-->>>>", node.parent.name);
                    console.log("-->>>>", node.parent.id);
                }
                if (node.parent.parent.name !== "" && node.parent.parent.hasOwnProperty('parent')) {
                    console.log("--->>>>>>", node.parent.parent.name);
                    console.log("--->>>>>>", node.parent.parent.id);
                }
                if (node.parent.parent.name !== "" && node.parent.parent.hasOwnProperty('parent')) {
                    console.log("---->>>>>>>>", node.parent.parent.parent.name);
                    console.log("---->>>>>>>>", node.parent.parent.parent.id);
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

let myPromise = new Promise(function (myResolve, myReject) {
    $.get(`Controller\\AjaxControl\\createJSON.php`, (data, status) => {
        value = JSON.parse(data);
        // value = data;
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
