<?php
require_once("db.php");

function getQuestionsByCategory($categoryId) {
    $con = getConnection();
    $sql = "SELECT * FROM questions WHERE category_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $questions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['question_type'] === 'mcq') {
            $row['answers'] = getAnswersForQuestion($row['question_id']);
        }
        $questions[] = $row;
    }
    return $questions;
}

function getAnswersForQuestion($questionId) {
    $con = getConnection();
    $sql = "SELECT * FROM answers WHERE question_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $questionId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $answers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $answers[] = $row;
    }
    return $answers;
}

function calculateScore($submittedAnswers) {
    $score = 0;
    $totalQuestions = count($submittedAnswers);
    if ($totalQuestions == 0) return 0;

    $questionIds = array_keys($submittedAnswers);
    $con = getConnection();
    $sql = "SELECT question_id, answer_id FROM answers WHERE is_correct = 1 AND question_id IN (".implode(',', $questionIds).")";
    $result = mysqli_query($con, $sql);
    
    $correctAnswers = [];
    while($row = mysqli_fetch_assoc($result)){
        $correctAnswers[$row['question_id']][] = $row['answer_id'];
    }

    foreach ($submittedAnswers as $questionId => $studentAnswerId) {
        if (isset($correctAnswers[$questionId]) && in_array($studentAnswerId, $correctAnswers[$questionId])) {
            $score++;
        }
    }
    return ($score / $totalQuestions) * 100;
}

function saveTestResult($userId, $categoryId, $score) {
    $con = getConnection();
    $sql = "INSERT INTO test_attempts (user_id, category_id, score) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iid", $userId, $categoryId, $score);
    return mysqli_stmt_execute($stmt);
}

function getResultHistory($userId) {
    $con = getConnection();
    $sql = "SELECT ta.*, c.category_name 
            FROM test_attempts ta
            JOIN categories c ON ta.category_id = c.category_id
            WHERE ta.user_id = ? 
            ORDER BY ta.attempt_date DESC";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $history = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $history[] = $row;
    }
    return $history;
}
?>