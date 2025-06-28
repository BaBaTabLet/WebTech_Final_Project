<?php

require_once("../session.php");
require_once("../Model/questionModel.php");
require_once("../Model/categoryModel.php");
$question_id = $_GET['id'] ?? null;
if (!$question_id)
 {
  header("Location: QuestionList.php");
 exit;
}
$question =fetchQuestionWithAnswers($question_id);
$categories =getAllCategories();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
     <h2>Edit Question</h2>

     <form action="../Controller/EditQuestionController.php" method="post">
         <input type="hidden" name="question_id" value="<?= htmlspecialchars($question['question_id']) ?>">

            Question Text:<br>
            <textarea name="question_text" required><?= htmlspecialchars($question['question_text']) ?></textarea><br><br>

            Category:
            <select name="category_id" required>
              <?php foreach($categories as $cat): ?>
             <option value="<?= $cat['category_id'] ?>" <?= ($cat['category_id'] == $question['category_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['category_name']) ?>
                </option>
                <?php endforeach; ?>
            </select><br><br>
            <hr>

            <h3>Answers (for MCQs)</h3>
            <div id="answers_container">
         <?php if ($question['question_type'] === 'mcq' && isset($question['answers'])): ?>
          <?php foreach ($question['answers'] as $index => $answer): ?>
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
               <input type="text" name="answers[<?= $index ?>][text]" value="<?= htmlspecialchars($answer['answer_text']) ?>" placeholder="Answer text" required style="flex-grow: 1; margin: 0 10px 0 0;">
            <label><input type="checkbox" name="answers[<?= $index ?>][is_correct]" value="1" <?= ($answer['is_correct']) ? 'checked' : '' ?>> Correct</label>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
            </div>
            
            <?php if ($question['question_type'] === 'mcq'): 
                ?>
                <button type="button" class="btn" onclick="addAnswerField()">Add New Answer Field</button>
            <?php else: 
                ?>
                <p><em>Editing answers is only available for MCQ questions.</em></p>
            <?php endif; 
            ?>

            <hr>
            <input type="submit"name="update_question" value="Update Question">
        </form>
        <br>
        <a href="QuestionList.php">Back to Question Bank</a>
    </div>

    <script>
        let answerCount = <?= isset($question['answers']) ? count($question['answers']) : 0 ?>;

        function addAnswerField() {
            const container =document.getElementById('answers_container');
            const newAnswer =document.createElement('div');
            newAnswer.style.cssText ="display: flex; align-items: center; margin-bottom: 10px;";
            newAnswer.innerHTML= `
                <input type="text" name="answers[${answerCount}][text]" placeholder="New answer text" required style="flex-grow: 1; margin: 0 10px 0 0;">
                <label><input type="checkbox" name="answers[${answerCount}][is_correct]" value="1"> Correct</label>`;
            container.appendChild(newAnswer);
            answerCount++; }
    </script>
</body>
</html>