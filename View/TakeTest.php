<?php
require_once("../session.php");
require_once("../Model/testModel.php");
if (!isset($_GET['category_id'])) {
    header("Location: SelectTest.php");
   exit;}

$categoryId =$_GET['category_id'];
$questions =getQuestionsByCategory($categoryId);
$testDuration =count($questions) * 60; 

?>

<!DOCTYPE html>
<html>
<head>
    <title>Take Test</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div id="timer"></div>
    <div class="container">
        <h2>Test in Progress</h2>

        <form id="test_form" action="../Controller/TestController.php" method="post">
            <input type="hidden" name="category_id" value="<?= $categoryId ?>">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question">
           <h4>Q<?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?></h4>
              <?php if ($q['question_type'] === 'mcq'): ?>
              <?php foreach ($q['answers'] as $ans): ?>
               <label style="display: block; margin-bottom: 10px;">
                 <input type="radio" name="answers[<?= $q['question_id'] ?>]" value="<?= $ans['answer_id'] ?>" required>
                   <?= htmlspecialchars($ans['answer_text']) ?>
                 </label>
                     <?php endforeach; ?>
                    <?php elseif ($q['question_type'] === 'essay'): ?>
                     <textarea name="answers[<?= $q['question_id'] ?>]"></textarea>
                    <p><small>(Essay questions are not auto-scored)</small></p>
                    <?php endif; 
                    ?>
                </div>
            <?php endforeach; 
            ?>
            <input type="submit" name="submit_test" value="Submit Test">
        </form>
    </div>

    <script>
        const duration = <?= $testDuration ?>;
        const timerDisplay =document.getElementById('timer');
        const testForm =document.getElementById('test_form');
        let timer =duration;

        const interval= setInterval(() => {
            let minutes= Math.floor(timer / 60);
            let seconds= timer % 60;
            seconds =seconds < 10 ? '0'+ seconds : seconds;
            timerDisplay.textContent= `${minutes}:${seconds}`;
            
  if (--timer < 0) {
   clearInterval(interval);
alert('Time is up! Submitting your test.');
   testForm.submit();
            }
        },1000);

    </script>
</body>
</html>