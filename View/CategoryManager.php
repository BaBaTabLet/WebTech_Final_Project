<?php
require_once("../session.php");
require_once("../Model/categoryModel.php");
$categories =getAllCategories();
$message =$_GET['message'] ?? '';
$error =$_GET['error'] ?? '';


?>
<!DOCTYPE html>
<html>
<head>
    <title>Category Manager</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Manage Categories</h2>
        
        <?php if ($message): ?>
            <p class="message"><?=htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?=htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="../Controller/CategoryController.php" method="post">
            Category Name: <input type="text" name="category_name" required>
            <input type="submit" name="add_category" value="Add Category">
        </form>
        <hr>
        <h3>Existing Categories</h3>
        <table>
            <thead>
                <tr>
                    <th>Serial No.</th> <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $rowNumber = 1; 
               ?>
                <?php foreach($categories as $cat): ?>
                <tr>
               <td><?= $rowNumber ?></td> <td><?= htmlspecialchars($cat['category_name']) ?></td>
               <td>
                   <a href="../Controller/CategoryController.php?delete_id=<?= $cat['category_id'] ?>" 
                   class="btn btn-delete" 
                   onclick="return confirm('WARNING: Are you sure you want to delete this category? This will also permanently delete ALL questions associated with it.')">
                   Delete </a>
                </td>
                </tr>

      <?php $rowNumber++; 
       ?>
      <?php endforeach; 
      ?>

     </tbody>
        </table>
        <br>
        <a href="Home.php">Back to Home</a>
</div>
</body>
</html>