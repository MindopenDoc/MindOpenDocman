let DisplayDesignation = [];
let selectedDesignations = [];
let DisplayUser = [];
let selectedUsers = [];
let forbiddenUser = [];
let ReadUser = [];


const ReomoveSelected = (isDepart,value) =>{
    if(isDepart){
        forbiddenUser = forbiddenUser.filter(el=>el.depart!==value);
        ReadUser = ReadUser.filter(el=>el.depart!==value);
        selectedUsers = selectedUsers.filter(el=>el.depart!==value);
    }
    else{
        forbiddenUser = forbiddenUser.filter(el=>el.desig!==value);
        ReadUser = ReadUser.filter(el=>el.desig!==value);
        selectedUsers = selectedUsers.filter(el=>el.desig!==value);

    }
}

$.get(`Controller\\permissionsRelated\\APIFORDATA.php`, (data, status)=>{ 
    data = JSON.parse(data);
    let departmentName = data.map((el)=>{return {id:el.id,name:el.name}});
    count=1;
    departTable="";
    departmentName.forEach(element => {
        departTable+=`
        <tr class="${count%2==0?"even":"odd"}">
        <td class="sorting_1">${element.name}</td>
        <td><input type="radio" name="department_permission[${element.id}]" value="-1" ></td>
        <td><input type="radio" name="department_permission[${element.id}]" value="3"></td>
        </tr>   
        `
        count+=1;
    });
    $('#DepartmentPermissionsAll').html(departTable);
    departmentName.forEach(element => {
        let department_permissionEvn = document.getElementsByName(`department_permission[${element.id}]`);
        department_permissionEvn.forEach(Nodeelement => {
            Nodeelement.addEventListener("click", function (e) {
                let selectedDepartmentDesignations = data.filter((el)=>el.id===element.id)[0];
                let NodeEleValue = Nodeelement.value;
                if(DisplayDesignation.includes(selectedDepartmentDesignations) && NodeEleValue=="-1"){
                    DisplayDesignation = DisplayDesignation.filter(el=>el.id!==element.id)
                    DisplayUser[`${element.name}`] = [];
                    ReomoveSelected(true,element.name);
                    BuildUserTable(DisplayUser);
                    BuildDesiganationTable(DisplayDesignation);
                    return;
                }
                if(NodeEleValue==="-1"){
                    return;
                }
                if(DisplayDesignation.includes(selectedDepartmentDesignations) && NodeEleValue=="3"){
                    return;
                }
                DisplayDesignation.push(selectedDepartmentDesignations);
                BuildDesiganationTable(DisplayDesignation);
            });
        });
    })
});

const BuildDesiganationTable = (displayList)=>{

    desigTable="";
    displayList.forEach((element)=>{
        count=1;
        departmentName = element.name;
        element.designations.forEach((el)=>{
            let checked = selectedDesignations.filter(ele=>ele.id===el.id).length>0;
            desigTable+=`
            <tr class="${count % 2 == 0 ? "even" : "odd"}">
            ${count == 1 ? `<td rowspan=${element.designations.length}>${departmentName} </td>` : ""}
            <td class="sorting_1">${el.name}</td>
            <td><input type="radio" name="designation_permission[${el.id}]" value="-1" ></td>
            <td><input type="radio" name="designation_permission[${el.id}]" value="3" ${checked?checked="checked":""}></td>
            </tr>  
            `
            count+=1;
        })
    })
    $("#DesignationPermissionsAll").empty();
    $("#DesignationPermissionsAll").html(desigTable);
    displayList.forEach((element)=>{
        element.designations.forEach((el)=>{
            let designation_permissionEvn = document.getElementsByName(`designation_permission[${el.id}]`);
            designation_permissionEvn.forEach(DesignationNodeelement => {
                DesignationNodeelement.addEventListener("click", function(e){
                    let DesignationValue = DesignationNodeelement.value;
                    if(DisplayUser[`${element.name}`] && DesignationValue=='-1'){
                        DisplayUser[`${element.name}`] = DisplayUser[`${element.name}`].filter(ele=>ele.id!==el.id);
                        ReomoveSelected(false,el.name);
                        BuildUserTable(DisplayUser);
                        return;
                    }
                    if(DisplayUser[`${element.name}`] && DesignationValue=='3'){ 
                        let array = DisplayUser[`${element.name}`];
                        DisplayUser = {...DisplayUser,[element.name]:[...array,el]};
                        console.log(DisplayUser);
                        selectedDesignations.push(element.id);
                        BuildUserTable(DisplayUser);
                        return;
                    }
                    if(!DisplayUser[`${element.name}`] && DesignationValue=='3')  DisplayUser[`${element.name}`] = [el];
                    selectedDesignations.push({id : element.id,depart:element.name});
                    BuildUserTable(DisplayUser);
                })
            })
        })
    })
}

const BuildUserTable = (display_user)=>{
    let departnames = Object.keys(display_user);
    UserNode = ``;
    departnames.forEach((deptName)=>{
        display_user[deptName].forEach((desig)=>{
            count=1;
            let users = desig.users;
            users.forEach(user=>{ 
                    let fchecked = forbiddenUser.filter(el=>el.id==user.id).length>0;
                    let rchecked = ReadUser.filter(el=>el.id==user.id).length>0;  
                    let Wchecked = selectedUsers.filter(el=>el.id==user.id).length>0;    
                    UserNode += `
                    <tr class="${count%2==0?"even":"odd"}">
                    ${count==1?`<td rowspan=${users.length}>${deptName} </td>`:""}
                    ${count==1?`<td rowspan=${users.length}>${desig.name}  </td>`:""}
                    <td class="sorting_1">${user.name}</td>
                    <td><input type="radio" id="${deptName}_${desig.name}_${user.id}_0" class="user-select" name="user_permission[${user.id}]" value="-1" ${fchecked?"checked":""}></td>
                    <td><input type="radio" id="${deptName}_${desig.name}_${user.id}_2"class="user-select" name="user_permission[${user.id}]" value="2" ${rchecked?"checked":""}></td>
                    <td><input type="radio" id="${deptName}_${desig.name}_${user.id}_3"class="user-select" name="user_permission[${user.id}]" value="3" ${Wchecked?"checked":""}></td>
                    </tr>   
                    `; 
                    count += 1; 
                })
            })
        })
        $('#UserPermissionsAllCheck').html(UserNode);
        $(".user-select").on('click',(evt)=>{
            let [depart,desig,id,value] = evt.target.id.split("_");
            if(value==="3") {
                selectedUsers.push({id,depart,desig});
                forbiddenUser = forbiddenUser.filter(el=>el.id!==id);
                ReadUser = ReadUser.filter(el=>el.id!==id);
            }
            else if(value=="2"){
                selectedUsers = selectedUsers.filter(el=>el.id!==id);
                forbiddenUser = forbiddenUser.filter(el=>el.id!==id);
                ReadUser.push({id,depart,desig});

            }
            else if(value=="0"){
                selectedUsers = selectedUsers.filter(el=>el.id!==id);
                ReadUser = ReadUser.filter(el=>el.id!==id);
                forbiddenUser.push({id,depart,desig});
            }
        

        })
    }
