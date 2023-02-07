const DeptChange = document.getElementById("selected");
    
$(`#selected`).click (function(){
    let selectedDept = $('#selected').val();
    $.get(`Controller\\permissionsRelated\\checkDesignation.php?query=${selectedDept}`, (data, status)=>{
            data = JSON.parse(data);
            optionsElemt = "";
            data.forEach(element => {
                optionsElemt += `<option value="${element[0]}" >${element[1]}</option> `;
            });
            $('#selectedDesignation').html(optionsElemt); 
        });
})

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
                <td><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"  ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
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
                <td><input type="radio" name="department_permission[${element[0]}]" value="0" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
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
                <td><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2"  ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
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
                <td><input type="radio" name="department_permission[${element[0]}]" value="0" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
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



var DesignationuncheckedForBdn = true;
var DesignationuncheckedWrite = true;
$('#checkAllDesignationForbidden').click(function(){
    selectDeptms = ``;
    $.get(`Controller\\permissionsRelated\\getallDesignations.php`, (data, status)=>{
        data = JSON.parse(data);
        console.log(data);
        count=1;
        if (DesignationuncheckedForBdn){
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"  ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                // ${element[0]==selectedDept?"checked='checked'":""}
                count += 1; 
            });
            DesignationuncheckedForBdn = false;
            DesignationuncheckedWrite = true;

        }
        else{
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="0" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
            DesignationuncheckedForBdn = true;
            DesignationuncheckedWrite = true;
        }
            $('#DesignationPermissionsAll').html(selectDeptms);
    });
})

$('#checkAllDesignationWrite').click(function(){
    $.get(`Controller\\permissionsRelated\\getallDesignations.php`, (data, status)=>{
        data = JSON.parse(data);
        selectDeptms = "";
        count=1;
        if (DesignationuncheckedWrite){
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="0"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2"  ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
            DesignationuncheckedWrite = false;
            DesignationuncheckedForBdn = true;
        }
        else{
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="0" checked="checked"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2" ></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
            DesignationuncheckedWrite = true;
            DesignationuncheckedForBdn = true;
        }
            $('#DesignationPermissionsAll').html(selectDeptms);
    });
})




