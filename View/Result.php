<?php
require_once("../session.php");
$score = $_SESSION['last_score'] ?? 'N/A';
unset($_SESSION['last_score']);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Test Result</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container" style="text-align: center;">
        <h2>Test Complete!</h2>
        <h3>Your Score: <?= htmlspecialchars($score) ?>%</h3>
        <br>
        <a href="SelectTest.php" class="btn">Take another test</a>
        <a href="ResultHistory.php" class="btn">View my result history</a><br><br>

        <a href="Home.php">Back to Home</a>

 </div>
</body>
</html>