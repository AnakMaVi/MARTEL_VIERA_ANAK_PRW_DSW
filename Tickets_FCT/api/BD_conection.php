<?php

function connectToDatabase() {
    $servername = "localhost";
    $username = "ANAK"; 
    $password = "1234"; 
    $database = "bd_ticket"; 
    
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
      
        return $conn;
        
    }

    function executeSQLQuery($conn, $sql) {
        $result = $conn->query($sql);
        if ($result === false) {
            die("Error executing SQL query: " . $conn->error);
        }
        return $result;
    }
    
    