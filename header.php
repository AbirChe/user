<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Login System</title>
    <link rel="stylesheet" href="./style.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body> 
    <nav>
    
        <ul>
        
        
            <a href="login.php"><li>Home</li></a>
            <?php if(!isset($_SESSION['id'])) : ?>
                <a href="signup.php"><li>Sign Up</li></a>
              
            <?php else: ?>
                <a href="./controllers/Users.php?q=logout"><li>Logout</li></a>
            <?php endif; ?>
            </ul>
    </nav>