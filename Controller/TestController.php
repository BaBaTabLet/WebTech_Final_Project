<?php

session_start();
require_once("../Model/testModel.php");

if ($_SERVER['REQUEST_METHOD'] ==='POST' && isset($_POST['submit_test'])) 
{
     $submittedAnswers = $_POST['answers'] ??[];
    $categoryId = $_POST['category_id'];
    $userId = $_SESSION['user']['id'];

    $scoreableAnswers =[];
    foreach($submittedAnswers as $qId =>$ansId){
        if(!empty($ansId)){ 
          $scoreableAnswers[$qId]=$ansId;
        }
    }

    $score = calculateScore($scoreableAnswers);
    saveTestResult($userId, $categoryId, $score);

    $_SESSION['last_score'] = $score;
    header("Location: ../View/Result.php");
    exit;
}

?>