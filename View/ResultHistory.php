<?php
require_once("../session.php");
require_once("../Model/testModel.php");
$history = getResultHistory($_SESSION['user']['id']);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Result History</title> <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>My Result History</h2>
    <table>
            <thead>
                <tr>
                <th>Test Category</th>
                <th>Score</th>
                <th>Date</th>
               </tr>

        
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="3" style="text-align: center;">No results found.</td></tr>
                <?php else: ?>
                    <?php foreach ($history as $row): ?>
                    <tr>
                  <td><?= htmlspecialchars($row['category_name']) ?></td>
                  <td><?= htmlspecialchars($row['score']) ?>%</td>
            <td><?= date('F j, Y, g:i a', strtotime($row['attempt_date'])) ?></td>  </tr>
                    <?php endforeach;
                    ?>
                <?php endif; 
                ?>
            </tbody>
        </table>
        <br>

        <a href="Home.php">Back to Home</a>
 </div>
</body>
</html>