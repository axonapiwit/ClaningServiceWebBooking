<?php
    session_start();
    $condb = new mysqli('localhost','root','','cleaningservicz');
    if($condb->connect_error){
        die("Connection Failed!".$condb->connect_error);
    }
    
    $result = array('error'=>false);
    $action = '';

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    if($action == 'read'){
        $sql = $condb->query("SELECT * FROM customer");
        $customer = array();
        while($row = $sql->fetch_assoc()){
            array_push($customer, $row);
        }
        $result['customer'] = $customer;
    }
    
    if($action == 'createUser'){
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $R_Number = $_POST['R_Number'];
        $R_Floor = $_POST['R_Floor'];
        $R_Name = $_POST['R_Name'];
        
        $sql = $condb->query("INSERT INTO customer (FirstName,LastName,Email,Phone,R_Number,R_Floor,R_Name)
            VALUES('$FirstName','$LastName','$Email','$Phone','$R_Number','$R_Floor','$R_Name')");
        if($sql){
            $last_id = $condb->insert_id;
            $_SESSION["id"] = $last_id;
            $result['message'] = "User added successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = "Failed to add data!";
        }
    }


    if($action == 'read'){
        $sql = $condb->query("SELECT * FROM booking");
        $booking = array();
        while($row = $sql->fetch_assoc()){
            array_push($booking, $row);
        }
        $result['booking'] = $booking;
    }

    
    if($action == 'createBook'){
        $Pet = $_POST['Pet'];
        $B_Date = $_POST['B_Date'];
        $Detail = $_POST['Detail'];
        $Hour = $_POST['Hour'];
        $B_Time = $_POST['B_Time'];
        $R_Size = $_POST['R_Size'];
        $C_id = $_POST['C_id'];
        $B_id = $_POST['B_id'];
        
        $sql = $condb->query("INSERT INTO booking (B_id,C_id,Pet,B_Date,Detail,Hour,B_Time,R_Size)
            VALUES('$B_id','$C_id','$Pet','$B_Date','$Detail','$Hour','$B_Time','$R_Size')");
        if($sql){
            $result['message'] = "User added successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = "Failed to add data!";
        }
    }

    if($action == 'update'){
        $C_id = $_POST['C_id'];
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $R_Number = $_POST['R_Number'];
        $R_Floor = $_POST['R_Floor'];
        $R_Name = $_POST['R_Name'];
        
        $sql = $condb->query("UPDATE customer SET FirstName='$FirstName',LastName='$LastName',
            Email='$Email',Phone='$Phone',R_Number='$R_Number',R_Floor='$R_Floor',R_Name='$R_Name' 
            WHERE C_id='$C_id'");
        if($sql){
            $result['message'] = "User update successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = "Failed to update data!";
        }
    
    }

    if($action == 'delete'){
        $C_id = $_POST['C_id'];
        
        $sql = $condb->query("DELETE FROM booking WHERE C_id='$C_id'");
            
        if($sql){
            $result['message'] = "Booking deleted successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = "Failed to cancel booking!";
        }
    }

    if($action == 'join'){
        $sql = $condb->query("SELECT customer.C_id,customer.FirstName,customer.LastName,customer.Email,customer.Phone,customer.R_Number,customer.R_Name,customer.R_Floor,booking.B_id,booking.Pet,booking.B_Date,booking.Detail,booking.Hour,booking.B_Time,booking.R_Size 
        FROM customer INNER JOIN booking ON booking.C_id = customer.C_id ORDER BY customer.C_id");
        $join = array();
        while($row = $sql->fetch_assoc()){
            array_push($join, $row);
        }
        $result['join'] = $join;
        if($sql){
            $result['message'] = "Join data successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = "Failed data successfully!";
        }
    }
    
    $condb->close();
    echo json_encode($result);

?>