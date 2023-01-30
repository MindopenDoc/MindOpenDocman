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