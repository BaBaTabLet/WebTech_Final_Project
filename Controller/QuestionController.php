<?php

require_once("../Model/questionModel.php");
function addQuestion($question) {
 return insertQuestion($question);
}

function getAllQuestions(){
    return fetchAllQuestions();
}

function deleteQuestion($questionId){
    return deleteQuestionById($questionId);
}

if (isset($_GET['delete'])) 
{
 $questionId =$_GET['delete'];
  $success =deleteQuestion($questionId);
  $msg =$success ? "Question deleted successfully." : "Failed to delete question.";
 header("Location: ../View/QuestionList.php?message=".urlencode($msg));
    exit;
}

?>