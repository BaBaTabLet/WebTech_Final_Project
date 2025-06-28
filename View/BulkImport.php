<?php
require_once("../session.php");
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Bulk Import</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Bulk Import Questions</h2>

   <?php 
        if ($message): 
  ?>
            <p class="message"><?=htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if ($error): 
            ?>

         <p class="error"><?=htmlspecialchars($error); ?></p>
        <?php endif; 
        ?>

        <p>Upload a CSV file with the columns: `question_text`, `question_type`, `category_id`</p>
        
        <form action="../Controller/ImportController.php" method="post" enctype="multipart/form-data">
            <input type="file" name="question_csv" accept=".csv" required><br><br>
            <input type="submit" value="Import Questions">
        </form>
<br>

        <a href="Home.php">Back to Home</a>
</div>
</body>
</html>