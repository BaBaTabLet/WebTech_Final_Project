<?php


require_once("../Model/categoryModel.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category']))
 { $categoryName = $_POST['category_name'];

    if(!empty($categoryName)) {
        $success = createCategory($categoryName);
        $msg = $success ? "Category added successfully." : "Failed to add category.";
        header("Location: ../View/CategoryManager.php?message=".urlencode($msg));
    } 
    else 
    {
        header("Location: ../View/CategoryManager.php?error=Category name cannot be empty.");
    }
    exit;
}

if (isset($_GET['delete_id'])) 
{  $categoryId =$_GET['delete_id'];
    $success =deleteCategoryById($categoryId);
    $msg =$success ? "Category and all its questions have been deleted." : "Failed to delete category.";
    header("Location: ../View/CategoryManager.php?message=".urlencode($msg));

exit;
}


?>