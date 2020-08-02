<?php

//Enable cross origin access control
header("Access-Control-Allow-Origin: *");

//Load recources
require_once('./classes/recordset.class.php');
// require_once('./classes/recordSet_rmv_header.class.php');
require_once('./classes/pdoDB.class.php');

//Start Session
session_start();

//Time and Date
$mysqlDateandTime = date("Y-m-d H:i:s");

//Standard REQUEST
$call = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'error';
$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : null;
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

//BUS REQUEST
$b_id= isset($_REQUEST['b_id']) ? $_REQUEST['b_id'] : null;
$b_name= isset($_REQUEST['b_name']) ? $_REQUEST['b_name'] : null;
$b_plate_no= isset($_REQUEST['b_plate_no']) ? $_REQUEST['b_plate_no'] : null;
$b_capacity= isset($_REQUEST['b_capacity']) ? $_REQUEST['b_capacity'] : null;

//DESTINATION REQUEST
$d_id= isset($_REQUEST['d_id']) ? $_REQUEST['d_id'] : null;
$d_from= isset($_REQUEST['d_from']) ? $_REQUEST['d_from'] : null;
$d_to= isset($_REQUEST['d_to']) ? $_REQUEST['d_to'] : null;

//TRAVELS REQUEST
$t_bus= isset($_REQUEST['t_bus']) ? $_REQUEST['t_bus'] : null;
$t_destination= isset($_REQUEST['t_destination']) ? $_REQUEST['t_destination'] : null;
$t_date= isset($_REQUEST['t_date']) ? $_REQUEST['t_date'] : null;
$t_time= isset($_REQUEST['t_time']) ? $_REQUEST['t_time'] : null;

//USER REQUEST
$u_email= isset($_REQUEST['u_email']) ? $_REQUEST['u_email'] : null;
$u_password= isset($_REQUEST['u_password']) ? $_REQUEST['u_password'] : null;
$u_name= isset($_REQUEST['u_name']) ? $_REQUEST['u_name'] : null;

//TRANSACTION REQUEST
$transaction_user= isset($_REQUEST['transaction_user']) ? $_REQUEST['transaction_user'] : null;
$transaction_travel= isset($_REQUEST['transaction_travel']) ? $_REQUEST['transaction_travel'] : null;


//Action and Subject to Route
$route = $call . ucfirst($subject);

// Connect to db
$db = pdoDB::getConnection();

//set the header to json because everything is returned in that format
header("Content-Type: application/json");

function option($retval, $type){

    $ret = json_decode($retval, true);
    $option = "<option></option>";

    if($ret['RowCount'] == 0){
        $option = '<option>No option available</option>';
    }else{
        foreach($ret['results'] as $value){
            $option = $option.'<option value = "'.$value[$type].'">'.$value[$type].'</option>';
        }
    }

    return $option;
}

switch ($route) {

//  Standard
    case 'showAllBus':
        $sqlSearch = "SELECT * FROM bus";
        $rs = new JSONRecordSet();
        $retval = $rs->getRecordSet($sqlSearch, null, null);
        echo $retval;
        break;

    case 'showAllDestinations':
        $sqlSearch = "SELECT * FROM destinations";
        $rs = new JSONRecordSet();
        $retval = $rs->getRecordSet($sqlSearch, null, null);
        echo $retval;
        break;

    case 'showAllUsers':
        $sqlSearch = "SELECT * FROM user";
        $rs = new JSONRecordSet();
        $retval = $rs->getRecordSet($sqlSearch, null, null);
        echo $retval;
        break;

    case 'showAllUsersByEmail':
        $sqlSearch = "SELECT * FROM user WHERE u_email=:u_email";
        $rs = new JSONRecordSet();
        $retval = $rs->getRecordSet($sqlSearch, null, array(
            ':u_email'=>$u_email
        ));
        echo $retval;
        break;

    case 'showAllTravels':
        $sqlSearch = "SELECT travels.*, bus.*, destinations.* FROM travels LEFT JOIN bus ON travels.t_bus=bus.b_id LEFT JOIN destinations ON travels.t_destination=destinations.d_id GROUP BY travels.t_id";
        $rs = new JSONRecordSet();
        $retval = $rs->getRecordSet($sqlSearch, null, null);
        echo $retval;
        break;

    case 'showAllTransactionByUser':
        $sqlSearch = "SELECT transactions.*, travels.*, bus.*, destinations.* FROM transactions LEFT JOIN travels ON transactions.transaction_travel=travels.t_id RIGHT JOIN bus ON travels.t_bus=bus.b_id RIGHT JOIN destinations ON travels.t_destination=destinations.d_id WHERE transaction_user=:transaction_user GROUP BY travels.t_id";
        $rs = new JSONRecordSet();
        $retval = $rs->getRecordSet($sqlSearch, null, array(
            ':transaction_user'=>$transaction_user
        ));
        echo $retval;
        break;

    case 'addBus':
        $sqlInsert="INSERT INTO 
                    `bus_system`.`bus` 
                    (
                    `b_name`, 
                    `b_plate_no`, 
                    `b_capacity`
                    ) 
                    VALUES 
                    (
                    :b_name,
                    :b_plate_no,
                    :b_capacity
                    )";
        $rs = new JSONRecordSet();
        $retval = $rs->setRecord(
            $sqlInsert, null, array(
                ':b_name'=>$b_name,
                ':b_plate_no'=>$b_plate_no,
                ':b_capacity'=>$b_capacity
            )
        );
        echo $retval;
        break;

    case 'addDestination':
        $sqlInsert="INSERT INTO 
                    `bus_system`.`destinations` 
                    (
                    `d_from`, 
                    `d_to`
                    ) 
                    VALUES 
                    (
                    :d_from,
                    :d_to
                    )";
        $rs = new JSONRecordSet();
        $retval = $rs->setRecord(
            $sqlInsert, null, array(
                ':d_from'=>$d_from,
                ':d_to'=>$d_to
            )
        );
        echo $retval;
        break;

    case 'addTravels':
        $sqlInsert="INSERT INTO 
                    `bus_system`.`travels` 
                    (
                    `t_bus`, 
                    `t_destination`, 
                    `t_date`, 
                    `t_time`
                    ) 
                    VALUES 
                    (
                    :t_bus,
                    :t_destination,
                    :t_date,
                    :t_time
                    )";
        $rs = new JSONRecordSet();
        $retval = $rs->setRecord(
            $sqlInsert, null, array(
                ':t_bus'=>$t_bus,
                ':t_destination'=>$t_destination,
                ':t_date'=>$t_date,
                ':t_time'=>$t_time
            )
        );
        echo $retval;
        break;

    case 'addUser':
        $sqlInsert="INSERT INTO 
                    `bus_system`.`user` 
                    (
                    `u_email`, 
                    `u_password`, 
                    `u_name`
                    ) 
                    VALUES 
                    (
                    :u_email,
                    :u_password,
                    :u_name)";
        $rs = new JSONRecordSet();
        $retval = $rs->setRecord(
            $sqlInsert, null, array(
                ':u_email'=>$u_email,
                ':u_password'=>password_hash($u_password, PASSWORD_DEFAULT),
                ':u_name'=>$u_name
            )
        );
        echo $retval;
        break;

    case 'addTransaction':
        $sqlInsert="INSERT INTO 
                    `bus_system`.`transactions` 
                    (
                    `transaction_user`, 
                    `transaction_travel`
                    ) 
                    VALUES 
                    (
                    :transaction_user,
                    :transaction_travel
                    )";
        $rs = new JSONRecordSet();
        $retval = $rs->setRecord($sqlInsert, null, array(
            ':transaction_user'=>$transaction_user,
            ':transaction_travel'=>$transaction_travel
            )
        );
        echo $retval;
        break;


    case 'logout':
        session_unset();
        session_destroy();
        header("Location: http://localhost/bus_system");


}//end of switch
?>