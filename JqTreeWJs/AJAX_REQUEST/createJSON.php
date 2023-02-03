<?php
 
    $FullTree = array();
    $flag=0;
    $servername = "localhost";
    $username = "opendocman";
    $password = "ideavate123";
    $dbname = "OpenDocMan";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $node0Count = 1;
    $DepartmentTree = array("name"=>"Department","id"=>$node0Count);
    $Query="SELECT * FROM `odm_department`";
    
    $result = $conn->query($Query);
    if($result->num_rows >= 1){
        $departmentEntries = array();
        while($row= $result->fetch_assoc()){
            $pr_id = $row['id'];
            $CategoryQuery="SELECT * FROM `category` WHERE `category`.`pr_id` = $pr_id";
            $Categoryresult = $conn->query($CategoryQuery);
            if($Categoryresult->num_rows >= 1){
                $categoryEntries = array();
                while($Categoryrow= $Categoryresult->fetch_assoc()){ 
                    $pr_id_sub_Cat = $Categoryrow['id'];
                    $Sub_CategoryQuery="SELECT * FROM `subcategory` WHERE `subcategory`.`pr_id` = $pr_id_sub_Cat";
                    $Sub_Categoryresult = $conn->query($Sub_CategoryQuery);
                    if($Sub_Categoryresult->num_rows >= 1){
                        $Sub_categoryEntries = array();
                        while($sub_Categoryrow= $Sub_Categoryresult->fetch_assoc()){ 
                            array_push($Sub_categoryEntries,array("name"=>$sub_Categoryrow['sub_cat_name'],"id"=>"$node0Count $pr_id $pr_id_sub_Cat ".$sub_Categoryrow['id'].""));
                        }
                        array_push($categoryEntries,array("name"=>$Categoryrow['cat_name'],"id"=>"$node0Count $pr_id ".$Categoryrow['id']."","children"=>$Sub_categoryEntries));
                    }
                    else{
                        array_push($categoryEntries,array("name"=>$Categoryrow['cat_name'],"id"=>"$node0Count $pr_id ".$Categoryrow['id'].""));
                    }
                }

                array_push($departmentEntries,array("name"=>$row['name'],"id"=>"$node0Count ".$row['id']."","children"=>$categoryEntries));
            }
            else{
                array_push($departmentEntries,array("name"=>$row['name'],"id"=>"$node0Count ".$row['id'].""));
            }
           
        }
        $DepartmentTree['children'] = $departmentEntries;
    } 
    array_push($FullTree,$DepartmentTree);
    $node0Count = $node0Count+1;
    
    $UserTree = array("name"=>"Author","id"=>$node0Count);
    $Query="SELECT id,username as name FROM `odm_user`";
    $result = $conn->query($Query);
    if($result->num_rows >= 1){
        $userEntries = array();
        while($row= $result->fetch_assoc()){ array_push($userEntries,array("name"=>$row['name'],"id"=>"$node0Count ".$row['id'].""));}
        $UserTree['children'] = $userEntries;
    } 
    array_push($FullTree,$UserTree); 
    $node0Count = $node0Count+1;

    $DesignationTree = array("name"=>"Designation","id"=>$node0Count);
    $DesignationQuery="SELECT id,name  FROM `odm_designation`";
    $Designationresult = $conn->query($DesignationQuery);
    
    if($Designationresult->num_rows >= 1){
        $DesignationEntries = array();
        while($row= $Designationresult->fetch_assoc()){ array_push($DesignationEntries,array("name"=>$row['name'],"id"=>"$node0Count ".$row['id'].""));}
        $DesignationTree['children'] = $DesignationEntries;
    } 
    array_push($FullTree,$DesignationTree); 
    $node0Count = $node0Count+1;

    $FileCategoryTree = array("name"=>"File Category","id"=>$node0Count);
    $FileCategoryQuery="SELECT id,name FROM `odm_category`";
    $FileCategoryresult = $conn->query($FileCategoryQuery);
    
    if($FileCategoryresult->num_rows >= 1){
        $FileCategoryEntries = array();
        while($row= $FileCategoryresult->fetch_assoc()){ array_push($FileCategoryEntries,array("name"=>$row['name'],"id"=>"$node0Count ".$row['id'].""));}
        $FileCategoryTree['children'] = $FileCategoryEntries;
    }
    array_push($FullTree,$FileCategoryTree); 
    $node0Count = $node0Count+1;

 
    print_r(json_encode($FullTree));
    die();


?>