<?php


session_start();
require_once("QuestionController.php");

$errors=[];
if (empty($_POST['question_text'])) $errors[]="Question text is required.";
if (empty($_POST['category_id'])) $errors[]="Category is required.";
if ($_POST['question_type'] === 'mcq' && empty($_POST['answers'])) $errors[]="MCQ questions must have answers.";

if (count($errors) > 0) 
{
 $_SESSION['errors'] = $errors;
 header("Location: ../View/AddQuestion.php");
 exit;
}

$questionData =[
    'text' => $_POST['question_text'],
    'type' => $_POST['question_type'],
    'category_id' => $_POST['category_id'],
    'answers' => $_POST['answers'] ?? []
];

$success=addQuestion($questionData);
$msg =$success ? "Question added successfully." : "Failed to add question.";
header("Location: ../View/QuestionList.php?message=" . urlencode($msg));
exit;
?>