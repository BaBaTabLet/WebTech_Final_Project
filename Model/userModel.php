<?php

require_once("db.php");
function validateUser($username, $password) 
{
    $con= getConnection();
    $sql ="SELECT * FROM users WHERE username = ? AND password = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    
    
    $result = mysqli_stmt_get_result($stmt);
     $user = mysqli_fetch_assoc($result);
    
return $user;
}


?>