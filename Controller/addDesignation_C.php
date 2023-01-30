<?php
   session_start();
   include('../odm-load.php');
    // include('../odm-init.php');

    $pdo = $GLOBALS['pdo'];
    if(isset($_POST['InputDesignation'])){
        $newDesignation =  $_POST['InputDesignation'];
        $query = "SELECT * FROM {$GLOBALS['CONFIG']['db_prefix']}designation where name = '$newDesignation'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $num_rows = $stmt->rowCount();
 
        foreach ($result as $var) {
            if (strtoupper($_POST['InputDesignation'])  === strtoupper($var['name'])){
                echo "Designation already Exist";
                header('Location:error.php?ec=26');
                die();
            }
        }
        $designation_data_query = "INSERT INTO 
        {$GLOBALS['CONFIG']['db_prefix']}designation (
            name
        )
            VALUES
        (
            :name
        )";
        $designation_data_stmt = $pdo->prepare($designation_data_query);
        $designation_data_stmt->bindParam(':name', $_POST['InputDesignation']);
        $designation_data_stmt->execute();
        // get id from INSERT operation
        $designationId = $pdo->lastInsertId();
        header('Location: addDesignation_V.php?last_message'.urlencode("Designation Added"));
        exit;
        echo "we Could move further";
    }