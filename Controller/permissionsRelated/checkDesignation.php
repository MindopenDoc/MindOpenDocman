
<?php

    session_start();
    $GLOBALS['state'] = 1;
    require_once '../../odm-load.php';
    
    $dataDir = $GLOBALS['CONFIG']['dataDir'];
    $userperms_obj = new UserPermission($_SESSION['uid'], $pdo);
    
    $showCheckBox = false;
    $rejectpage = false;
    if(isset($_GET['query'])){
        $deptIdCheck = $_GET['query'];
        
        $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation where dept_id = $deptIdCheck";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $num_rows = $stmt->rowCount();
        if($num_rows>0){
            $result_Send = array();        
            foreach($result as $row){
                array_push($result_Send,array($row['id'],$row['name']));
            }
            print_r(json_encode($result_Send));
        }
        else{
            print_r(json_encode(array()));

        }
        
    }
