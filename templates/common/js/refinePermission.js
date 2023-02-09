let UserValue = document.getElementById("FileOwner").value;
console.log(UserValue);
$.get(`Controller\\permissionsRelated\\getAllUsers.php?userID=${UserValue}`, (data, status)=>{ 
    data = JSON.parse(data);
    console.log(data);
    count=1;
    UserNode = ``;
    data.forEach(element => {    
        UserNode += `
        <tr class="${count%2==0?"even":"odd"}">
        ${count==1?`<td rowspan=${data.length}>Department </td>`:""}
        ${count==1?`<td rowspan=${data.length}>Designation </td>`:""}
        <td class="sorting_1">${element[1]}</td>
        <td><input type="radio" name="user_permission[${element[0]}]" value="-1" ></td>
        <td class="hideTD"><input type="radio" name="user_permission[${element[0]}]" value="1"></td>
        <td><input type="radio" name="user_permission[${element[0]}]" value="2"></td>
        <td><input type="radio" name="user_permission[${element[0]}]" value="3"></td>
        <td class="hideTD"><input type="radio" name="user_permission[${element[0]}]" value="4"></td>
        </tr>   
        `; 
        count += 1; 
    });
    $('#UserPermissionsAllCheck').html(UserNode);
});



var AlreadyselectedDepartment = [];
var AlreadyDesignations = [];
$(document).ready(function(){
    let selectedDeptVal = $('#file_department').val();
    AlreadyselectedDepartment.push(selectedDeptVal);
    if(AlreadyselectedDepartment.length>0){
        AlreadyselectedDepartment.forEach(element => {
            let DesignationNode = document.getElementById("DesignationPermissionsAll").innerHTML;
                    $.get(`Controller\\permissionsRelated\\getAllDepts.php?query=${element[0]}`, (DeptNamedata, status)=>{
                        DeptNamedata = JSON.parse(DeptNamedata);
                        $.get(`Controller\\permissionsRelated\\getallDesignations.php?query=${element[0]}`, (data, status)=>{ 
                            data = JSON.parse(data);
                            if (data[0] === 'No records found!'){
                                return;
                            }
                                count=1;
                                data.forEach(element => {    
                                    AlreadyDesignations.push(element[0]);
                                    DesignationNode += `
                                    <tr class="${count%2==0?"even":"odd"}">
                                    ${count==1?`<td rowspan=${data.length}>${DeptNamedata[0][1]} </td>`:""}
                                    <td class="sorting_1">${element[1]}</td>
                                    <td><input type="radio" name="designation_permission[${element[0]}]" value="-1" ></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="0"></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="1"></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="2"></td>
                                    <td><input type="radio" name="designation_permission[${element[0]}]" value="3"></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="4"></td>
                                    </tr>   
                                    `; 
                                    count += 1; 
                                });
                                $('#DesignationPermissionsAll').html(DesignationNode);
                        });
                    });
        });
    }
    $.get(`Controller\\permissionsRelated\\getAllDepts.php`, (data, status)=>{
        data = JSON.parse(data);
        count=1;
        selectDeptms = "";
        data.forEach(element => {    
            let department_permissionEvn = document.getElementsByName(`department_permission[${element[0]}]`);
            department_permissionEvn.forEach(Nodeelement => {
                Nodeelement.addEventListener("click", function(e){
                    if( AlreadyselectedDepartment.includes(element[0])){
                        return;
                    }
                    AlreadyselectedDepartment.push(element[0]);
                    let DesignationNode = document.getElementById("DesignationPermissionsAll").innerHTML;
                    console.log("this is dept id  ::: ",element[0]);
                    $.get(`Controller\\permissionsRelated\\getAllDepts.php?query=${element[0]}`, (DeptNamedata, status)=>{
                        DeptNamedata = JSON.parse(DeptNamedata);
                        $.get(`Controller\\permissionsRelated\\getallDesignations.php?query=${element[0]}`, (data, status)=>{ 
                            data = JSON.parse(data);
                            if (data[0] === 'No records found!'){
                                return;
                            }
                            count=1;
                                data.forEach(element => {    
                                    AlreadyDesignations.push(element[0]);
                                    DesignationNode += `
                                    <tr class="${count%2==0?"even":"odd"}">
                                    ${count==1?`<td rowspan=${data.length}>${DeptNamedata[0][1]} </td>`:""}
                                    <td class="sorting_1">${element[1]}</td>
                                    <td><input type="radio" name="designation_permission[${element[0]}]" value="-1" ></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="0"></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="1"></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="2"></td>
                                    <td><input type="radio" name="designation_permission[${element[0]}]" value="3"></td>
                                    <td class="hideTD"><input type="radio" name="designation_permission[${element[0]}]" value="4"></td>
                                    </tr>   
                                    `; 
                                    count += 1; 
                                });
                                $('#DesignationPermissionsAll').html(DesignationNode);
                        });
                    });
                });
            }); 
        });
    });
});


allselectedDesignations = [];
$("#DesignationEvent").click(function(){
    console.log(AlreadyselectedDepartment);
    console.log(AlreadyDesignations);
    
    AlreadyDesignations.forEach(selectedDesign => {
        $.get(`Controller\\permissionsRelated\\getallDesignations.php?userQuery=${selectedDesign}`, (data, status)=>{
            data = JSON.parse(data);
            console.log(data);
            count=1;
            data.forEach(element => {    
                let department_permissionEvn = document.getElementsByName(`designation_permission[${element[0]}]`);
                department_permissionEvn.forEach(Nodeelement => {
                    Nodeelement.addEventListener("click", function(e){
                        if( allselectedDesignations.includes(data[0])){
                            return;
                        }
                        allselectedDesignations.push(data[0]);
                        console.log("Designation ka event !",data[0][1],data[1],data[2]);
                        // Controller\permissionsRelated\getAllUsers.php
                        $.get(`Controller\\permissionsRelated\\getAllUsers.php?designation=${data[0][0]}&department=${data[0][2]}`, (data, status)=>{ 
                            data = JSON.parse(data);
                            console.log(data);
                            if (data[0] === 'No records found!'){
                                return;
                            }
                                let UserNode = document.getElementById("UserPermissionsAllCheck").innerHTML;
                                count=1;
                                data.forEach(element => {    
                                    UserNode += `
                                    <tr class="${count%2==0?"even":"odd"}">
                                    ${count==1?`<td rowspan=${data.length}>Department </td>`:""}
                                    ${count==1?`<td rowspan=${data.length}>Designation </td>`:""}
                                    <td class="sorting_1">${element[1]}</td>
                                    <td><input type="radio" name="user_permission[${element[0]}]" value="-1" ></td>
                                    <td><input type="radio" name="user_permission[${element[0]}]" value="1"></td>
                                    <td><input type="radio" name="user_permission[${element[0]}]" value="2"></td>
                                    <td><input type="radio" name="user_permission[${element[0]}]" value="3"></td>
                                    <td><input type="radio" name="user_permission[${element[0]}]" value="4"></td>
                                    </tr>   
                                    `; 
                                    count += 1; 
                                });
                                $('#UserPermissionsAllCheck').html(UserNode);
                        });
                    });
                }); 
            });
        });
    });
})










// UserEventAdding

















var uncheckedForBdn = true;
var uncheckedWrite = true;
$('#checkAllDepartmentForbidden').click(function(){
    let selectedDept = $('#selected').val();
    selectDeptms = ``;
    $.get(`Controller\\permissionsRelated\\getAllDepts.php`, (data, status)=>{
        data = JSON.parse(data);
        count=1;
        if (uncheckedForBdn){
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" checked="checked"></td>
                <td class="hideTD" ><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td class="hideTD" ><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td class="hideTD" ><input type="radio" name="department_permission[${element[0]}]" value="2"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"  ></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                // ${element[0]==selectedDept?"checked='checked'":""}
                count += 1; 
            });
            uncheckedForBdn = false;
            uncheckedWrite = true;
        }
        else{
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
            uncheckedForBdn = true;
            uncheckedWrite = true;
        }
            $('#DepartmentPermissionsAll').html(selectDeptms);
    });
})

$('#checkAllDepartmentWrite').click(function(){
    $.get(`Controller\\permissionsRelated\\getAllDepts.php`, (data, status)=>{
        data = JSON.parse(data);
        selectDeptms = "";
        count=1;
        if (uncheckedWrite){
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="2"  ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3" checked="checked"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
            uncheckedWrite = false;
            uncheckedForBdn = true;
        }
        else{
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
                <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
            uncheckedWrite = true;
            uncheckedForBdn = true;
        }
            $('#DepartmentPermissionsAll').html(selectDeptms);
    });
})





