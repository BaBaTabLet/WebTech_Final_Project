<?php

session_start();
if (isset($_SESSION['user'])) {
    header("Location: Home.php");
 exit;}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title><link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (isset($_GET['error'])): ?>
          <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; 
        ?>
        <form action="../Controller/AuthController.php" method="post">
            Username:<input type="text" name="username" required><br><br>
            Password:<input type="password" name="password" required><br><br>
     <input type="submit" name="login" value="Login">
      
    </form>
     </div>
</body>
</html>