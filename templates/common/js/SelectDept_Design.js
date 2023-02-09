$(`#selected`).click (function(){
    let selectedDeptVal = $('#selected').val();
    $.get(`Controller\\permissionsRelated\\checkDesignation.php?query=${selectedDeptVal}`, (data, status)=>{
            data = JSON.parse(data);
            optionsElemt = "";
            data.forEach(element => {
                optionsElemt += `<option value="${element[0]}" >${element[1]}</option> `;
            });
            $('#selectedDesignation').html(optionsElemt); 
    });

    $.get(`Controller\\permissionsRelated\\getAllDepts.php`, (data, status)=>{
        data = JSON.parse(data);
        count=1;
        selectDeptms = "";
         
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="-1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="0" ${element[0]!==selectedDeptVal?"checked=checked":""}></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="2"></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="3" ${element[0]===selectedDeptVal?"checked=checked":""}></td>
                <td><input type="radio" name="department_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
        
            $('#DepartmentPermissionsAll').html(selectDeptms);
    });
})
 

$(`#selectedDesignation`).click (function(){
    let selectedDesignationVal = $('#selectedDesignation').val();
    console.log("This is designation Value :: ",selectedDesignationVal);
    $.get(`Controller\\permissionsRelated\\getallDesignations.php`, (data, status)=>{
        data = JSON.parse(data);
        selectDeptms = "";
        count=1;
            data.forEach(element => {    
                selectDeptms += `
                <tr class="${count%2==0?"even":"odd"}">
                <td class="sorting_1">${element[1]}</td>
                <td><input type="radio" name="designation_permission[${element[0]}]" value="-1" ></td>
                <td><input type="radio" name="designation_permission[${element[0]}]" value="0" ${element[0]!==selectedDesignationVal?"checked=checked":""}></td>
                <td><input type="radio" name="designation_permission[${element[0]}]" value="1"></td>
                <td><input type="radio" name="designation_permission[${element[0]}]" value="2"  ></td>
                <td><input type="radio" name="designation_permission[${element[0]}]" value="3" ${element[0]===selectedDesignationVal?"checked=checked":""}></td>
                <td><input type="radio" name="designation_permission[${element[0]}]" value="4"></td>
                </tr>   
                `; 
                count += 1; 
            });
        
        
            $('#DesignationPermissionsAll').html(selectDeptms);
    });
})