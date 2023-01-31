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
                elements = "";
                data.forEach(element => {
                    elements += `
                            <div class="form-check">
                                <input type="radio" name="radioBtn" class="form-check-input" id="${element.split(" ").join("")}" value="${element}" >
                                <label class="form-check-label" for="${element.split(" ").join("")}">${element}</label>
                            </div> `;
                });
                chldElmt = $(`#${elemt}`)[0]['attributes']['data-target'].value.substr(1);
                $(`#${chldElmt}`).html(elements);
                data.forEach(element => {
                    $(`#${element.split(" ").join("")}`).click(function(){                                
                        parentElemt = currentElemt;
                        currentElemtforthis = element;
                        $.get(`Controller\\AjaxControl\\getSearchData.php?currentElemt=${currentElemtforthis}&parentElemt=${parentElemt}`, function(data, status){
                            data_table_str = "";
                            try {
                                data = JSON.parse(data);
                            }
                            catch(err) {
                                
                                console.warn("This is no records found !!");
                                data_table_str += `<tr ><td colspan="9" align="center"> <h2> No Records Found ! </h2></td></tr>` ;
                                // document.getElementById("hiddenTable").style.display = "block" ; 
                                document.getElementById("data_table").innerHTML = data_table_str;
                                return;
                            }             
                            count = 1;                   
                            data.forEach((eachrow)=>{
                                data_table_str += `<tr class=" ${ count%2==0?"even":"odd"} "> 
                                                    <td>${eachrow['id'] }</td>
                                                    <td><a href="${eachrow['view_link'] }">View</a></td>
                                                    <td>${eachrow['filename'] }</td>
                                                    <td>${eachrow['description'] }</td>
                                                    <td>${eachrow['keyword'] }</td>
                                                    <td>${eachrow['rights'][0][1]} |${eachrow['rights'][1][1]} |${eachrow['rights'][2][1] }</td>
                                                    <td>${eachrow['created_date'] }</td>
                                                    <td>${eachrow['modified_date'] }</td>
                                                    <td>${eachrow['owner_name'] }</td>
                                                    <td>${eachrow['dept_name'] }</td>
                                                    <td>${eachrow['filesize'] }</td>
                                                </tr>`;
                                count += 1;
                            });   
                            // document.getElementById("hiddenTable").style.display = "block" ; 
                            document.getElementById("data_table").innerHTML = data_table_str;
                        });
                    })
                });
            });
        });
    });
})