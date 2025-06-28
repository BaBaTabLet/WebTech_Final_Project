<?php

require_once("../session.php");
require_once("../Model/categoryModel.php");
$categories = getAllCategories();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Question</h2>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul style="padding-left: 20px;">
                 <?php foreach ($errors as $e): ?>
                <li><?php echo htmlspecialchars($e); ?></li>
                   <?php endforeach; ?>
                </ul>
            </div>
 <?php 
endif; 
?>

     <form action="../Controller/AddQuestionValidation.php" method="post">
          
     Question Text:<br>
        <textarea name="question_text" required></textarea><br><br>

         Category:
        <select name="category_id" required>
              <option value="">Select a Category</option>
              <?php foreach($categories as $cat): ?>
             <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
             <?php endforeach; ?>
        </select><br><br>
            
            Question Type:
            <select name="question_type" id="question_type" onchange="updateAnswerFields()">
               <option value="mcq">Multiple Choice</option>
               <option value="essay">Essay</option>
            </select><br><br>

            <div id="answers_container"></div>
            <button type="button" id="add_answer_btn" class="btn" onclick="addAnswerField()">Add Answer Field</button>
            <hr>
            <input type="submit" value="Save Question">
        </form>
        <br>
        <a href="Home.php">Back to Home</a>
    </div>



    <script>
        let answerCount = 0;
        function updateAnswerFields() {
            const type =document.getElementById('question_type').value;
            const container =document.getElementById('answers_container');
            const addBtn =document.getElementById('add_answer_btn');
            container.innerHTML ='';
            answerCount = 0;   
            if (type === 'mcq') {
                addBtn.style.display = 'inline-block';
                addAnswerField();
                addAnswerField();
            } else 
            {
              addBtn.style.display = 'none';
            } 
              }
          function addAnswerField() {
            const container = document.getElementById('answers_container');
            const newAnswer = document.createElement('div');
            newAnswer.innerHTML = `
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <input type="text" name="answers[${answerCount}][text]" placeholder="Answer text" required style="flex-grow: 1; margin: 0 10px 0 0;">
                    <label><input type="checkbox" name="answers[${answerCount}][is_correct]" value="1"> Correct</label>
                </div> `;
            container.appendChild(newAnswer);
            answerCount++;
        }

        document.addEventListener('DOMContentLoaded', updateAnswerFields);
        
    </script>
</body>
</html>