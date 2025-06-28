<?php


session_start();
require_once("../Model/questionModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_question']))
 {
   if (empty($_POST['question_text']) || empty($_POST['category_id']))
   {
      header("Location: ../View/EditQuestion.php?id=" . $_POST['question_id'] . "&error=Question text and category are required.");
      exit;
    }

    $questionData =[
        'id' =>$_POST['question_id'],
        'text' =>$_POST['question_text'],
        'category_id'=>$_POST['category_id'],
        'answers'=>$_POST['answers'] ??[]
    ];

    $success=updateQuestionAndAnswers($questionData);

    if ($success) 
    {
          header("Location: ../View/QuestionList.php?message=Question updated successfully.");
    }
     else
    {
        header("Location: ../View/EditQuestion.php?id=" . $_POST['question_id'] . "&error=Failed to update question.");
    }
    exit;
}


?>