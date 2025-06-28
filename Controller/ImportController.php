<?php
session_start();
require_once("../Model/questionModel.php");

if (isset($_FILES['question_csv']) && $_FILES['question_csv']['error'] == 0)
 {
    $fileName = $_FILES['question_csv']['tmp_name'];
    $file = fopen($fileName, "r");
    fgetcsv($file); 

    $successCount =0;
    $errorCount =0;

    while (($column = fgetcsv($file)) !== FALSE) {
        if (count($column) < 3) {
            $errorCount++;
            continue;
        }
        $questionData = [
            'text' => $column[0],
            'type' => $column[1],
            'category_id' => $column[2],
            'answers' => []
        ];
        
        if (!empty($questionData['text']) && !empty($questionData['category_id']) && in_array($questionData['type'], ['mcq', 'essay', 'true_false'])) {
            if(insertQuestion($questionData)) 
            {
             $successCount++;
            } 
            else {$errorCount++;}
        } 
        else { $errorCount++;}
    }

    $msg ="Import complete. {$successCount} questions added, {$errorCount} rows failed.";
    header("Location: ../View/BulkImport.php?message=" . urlencode($msg));
} 
else 
{
      header("Location: ../View/BulkImport.php?error=File upload failed.");
}

exit;

?>