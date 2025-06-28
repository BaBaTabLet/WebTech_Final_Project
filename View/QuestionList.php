<?php
require_once("../session.php");
require_once("../Controller/QuestionController.php");
$questions = getAllQuestions();
$message = $_GET['message'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Question Bank</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Question Bank</h2>
        <?php if ($message): ?>
            <p class="message"><?=htmlspecialchars($message); ?></p>
        <?php endif; ?>
         <table>
         <thead>
            <tr>
          <th>ID</th>
         <th>Category</th>
       <th>Type</th>
       <th>Question Text</th>
        <th>Action</th>
        </tr>
     </thead>
        <tbody>
                <?php foreach ($questions as $q):
                 ?> <tr>
           <td><?= $q['question_id'] ?></td>
                <td><?=htmlspecialchars($q['category_name']) ?></td>
                 <td><?=htmlspecialchars($q['question_type']) ?></td>
              <td><?=htmlspecialchars($q['question_text']) ?></td>
                    <td>
                        <div class="action-buttons">
                            
                  <a href="EditQuestion.php?id=<?= $q['question_id'] ?>" class="btn">Edit</a> 
                  <a href="../Controller/QuestionController.php?delete=<?= $q['question_id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-delete">Delete</a>
        </div>
       </td>
    </tr>
     <?php endforeach; 
     ?>
      </tbody>
     </table>
     <br>

        <a href="Home.php">Back to Home</a>

    </div>
</body>
</html>