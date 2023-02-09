let UserValue = document.getElementById("FileOwner").value;
$.get(`Controller\\permissionsRelated\\getAllUsers.php?userID=${UserValue}`, (data, status)=>{ 
    data = JSON.parse(data);
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

// DESIGNATION SELECT  KRNA PA JO USER ANA CHAIYA WOH YHA SE AA PAYENGA 
allselectedDesignations = [];
$("#DesignationEvent").click(function(){  
    AlreadyDesignations.forEach(selectedDesign => {
        $.get(`Controller\\permissionsRelated\\getallDesignations.php?userQuery=${selectedDesign}`, (DesignationData, status)=>{
            DesignationData = JSON.parse(DesignationData);
            count=1;
            DesignationData.forEach(Designationelement => {    
                let designation_permissionEvn = document.getElementsByName(`designation_permission[${Designationelement[0]}]`);
                designation_permissionEvn.forEach(DesignationNodeelement => {
                    DesignationNodeelement.addEventListener("click", function(e){
                        if( allselectedDesignations.includes(DesignationData[0][0])){
                            return;
                        }
                        allselectedDesignations.push(DesignationData[0][0]);
                        $.get(`Controller\\permissionsRelated\\getAllDepts.php?query=${DesignationData[0][2]}`, (DepartmentData, status)=>{
                            DepartmentData = JSON.parse(DepartmentData);
                            $.get(`Controller\\permissionsRelated\\getAllUsers.php?designation=${DesignationData[0][0]}&department=${DesignationData[0][2]}`, (Userdata, status)=>{ 
                                Userdata = JSON.parse(Userdata);
                                if (Userdata[0] === 'No records found!'){
                                    return;
                                }
                                    let UserNode = document.getElementById("UserPermissionsAllCheck").innerHTML;
                                    count=1;
                                    Userdata.forEach(element => {    
                                        UserNode += `
                                        <tr class="${count%2==0?"even":"odd"}">
                                        ${count==1?`<td rowspan=${Userdata.length}>${DepartmentData[0][1]} </td>`:""}
                                        ${count==1?`<td rowspan=${Userdata.length}>${Designationelement[1]}  </td>`:""}
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
    // let selectedDept = $('#selected').val();
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

// $('#checkAllDepartmentWrite').click(function(){
//     $.get(`Controller\\permissionsRelated\\getAllDepts.php`, (data, status)=>{
//         data = JSON.parse(data);
//         selectDeptms = "";
//         count=1;
//         if (uncheckedWrite){
//             data.forEach(element => {    
//                 selectDeptms += `
//                 <tr class="${count%2==0?"even":"odd"}">
//                 <td class="sorting_1">${element[1]}</td>
//                 <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="2"  ></td>
//                 <td><input type="radio" name="department_permission[${element[0]}]" value="3" checked="checked"></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
//                 </tr>   
//                 `; 
//                 count += 1; 
//             });
//             uncheckedWrite = false;
//             uncheckedForBdn = true;
//         }
//         else{
//             data.forEach(element => {    
//                 selectDeptms += `
//                 <tr class="${count%2==0?"even":"odd"}">
//                 <td class="sorting_1">${element[1]}</td>
//                 <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
//                 <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
//                 <td class="hideTD"><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
//                 </tr>   
//                 `; 
//                 count += 1; 
//             });
//             uncheckedWrite = true;
//             uncheckedForBdn = true;
//         }
//             $('#DepartmentPermissionsAll').html(selectDeptms);
//     });
// })





