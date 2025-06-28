<?php
require_once("db.php");

function insertQuestion($question) {
    $con = getConnection();
    mysqli_begin_transaction($con);

    try {
        $sqlQuestion = "INSERT INTO questions (category_id, question_type, question_text) VALUES (?, ?, ?)";
        $stmtQuestion = mysqli_prepare($con, $sqlQuestion);
        mysqli_stmt_bind_param($stmtQuestion, "iss", $question['category_id'], $question['type'], $question['text']);
        mysqli_stmt_execute($stmtQuestion);
        $questionId = mysqli_insert_id($con);

        if ($question['type'] ==='mcq' && !empty($question['answers'])) {
            $sqlAnswer = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)";
            $stmtAnswer = mysqli_prepare($con, $sqlAnswer);
            foreach ($question['answers'] as $answer) {
                $isCorrect = isset($answer['is_correct']) ? 1 : 0;
                mysqli_stmt_bind_param($stmtAnswer, "isi", $questionId, $answer['text'], $isCorrect);
                mysqli_stmt_execute($stmtAnswer);
            }
        }
        mysqli_commit($con);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($con);
        return false;
    }
}

function fetchAllQuestions() {
    $con = getConnection();
    $sql = "SELECT q.*, c.category_name 
            FROM questions q 
            JOIN categories c ON q.category_id = c.category_id 
            ORDER BY q.question_id DESC";
    $result = mysqli_query($con, $sql);
    $questions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row;
    }
    return $questions;
}

function deleteQuestionById($questionId) {
    $con = getConnection();
    $sql = "DELETE FROM questions WHERE question_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $questionId);
    return mysqli_stmt_execute($stmt);
}

function fetchQuestionWithAnswers($questionId) {
    $con = getConnection();
    $question = null;

   
    $sql_q = "SELECT * FROM questions WHERE question_id = ?";
    $stmt_q = mysqli_prepare($con, $sql_q);
    mysqli_stmt_bind_param($stmt_q, "i", $questionId);
    mysqli_stmt_execute($stmt_q);
    $result_q = mysqli_stmt_get_result($stmt_q);
    $question = mysqli_fetch_assoc($result_q);

    if ($question) {
        if ($question['question_type'] === 'mcq') {
            $sql_a = "SELECT * FROM answers WHERE question_id = ?";
            $stmt_a = mysqli_prepare($con, $sql_a);
            mysqli_stmt_bind_param($stmt_a, "i", $questionId);
            mysqli_stmt_execute($stmt_a);
            $result_a = mysqli_stmt_get_result($stmt_a);
            $answers = [];
            while ($row = mysqli_fetch_assoc($result_a)) {
                $answers[] = $row;
            }
            $question['answers'] = $answers;
        }
    }
    return $question;
}

function updateQuestionAndAnswers($questionData) 
{
    $con = getConnection();
    mysqli_begin_transaction($con);

    try {
        
        $sql_q = "UPDATE questions SET question_text = ?, category_id = ? WHERE question_id = ?";
        $stmt_q = mysqli_prepare($con, $sql_q);
        mysqli_stmt_bind_param($stmt_q, "sii", $questionData['text'], $questionData['category_id'], $questionData['id']);
        mysqli_stmt_execute($stmt_q);

        $sql_del = "DELETE FROM answers WHERE question_id = ?";
        $stmt_del = mysqli_prepare($con, $sql_del);
        mysqli_stmt_bind_param($stmt_del, "i", $questionData['id']);
        mysqli_stmt_execute($stmt_del);
        
     
        if (isset($questionData['answers']) && !empty($questionData['answers'])) 
        {
            $sql_ins ="INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)";
            $stmt_ins = mysqli_prepare($con, $sql_ins);
            foreach ($questionData['answers'] as $answer) 
            {
              if (empty($answer['text'])) continue; 
                $isCorrect = isset($answer['is_correct']) ? 1 : 0;
                mysqli_stmt_bind_param($stmt_ins, "isi", $questionData['id'], $answer['text'], $isCorrect);
                mysqli_stmt_execute($stmt_ins);
            }
        }
        mysqli_commit($con);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($con);

  return false;
}
}


?>