<?php
require_once("../session.php");
require_once("../Model/categoryModel.php");
$categories = getAllCategories();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Select a Test</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Select a Test</h2>
        <p>Choose a category from the list below to begin the test.</p>
        
        <nav class="main-menu">
            <ul>
                <?php if (empty($categories)): ?>
                    <li>No tests available at the moment.</li>
                <?php else: 
                    ?>
                    <?php foreach ($categories as $cat): 
                        ?>
               <li>
          <a href="TakeTest.php?category_id=<?= $cat['category_id'] ?>">
                  <?= htmlspecialchars($cat['category_name'])?>
                </a>
              </li>
                    <?php endforeach; 
                    ?>
                <?php endif; 
                ?>
            </ul>
        </nav>
        <br>

        <a href="Home.php">Back to Home</a>

 </div>
</body>
</html>