<?php

require_once("db.php");
function createCategory($categoryName) {
 $con =getConnection();
    $sql = "INSERT INTO categories (category_name) VALUES (?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $categoryName);

    return mysqli_stmt_execute($stmt);
}
function getAllCategories() {
    $con = getConnection();
    $sql = "SELECT * FROM categories ORDER BY category_name";
    $result = mysqli_query($con, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row; }
    return $categories;
}

function deleteCategoryById($categoryId)
 {
   $con = getConnection();
    $sql ="DELETE FROM categories WHERE category_id =?";
    $stmt =mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    return mysqli_stmt_execute($stmt);
}

?>