

<?php include_once 'header.php'; ?>
<?php

require_once './libs/Database.php';
require_once './libs/Task.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Create a User instance
$task = new Task($conn);
$allTask = $task->getAllTasks();

// DELETE TASK 
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["taskId"])) {
    $taskId = $_POST["taskId"];
    $result = $task->deleteTask($taskId);
    if($result){
        header("location: index.php");
        exit();
    } 
}

?>

<div class='container-sm mt-4'>
    <?php if (!empty($success)): ?>
        <div class="p-3 mb-4 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
  <?php echo $success; ?>
</div>
    <?php endif; ?>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
        <?php 
        while($row = $allTask->fetch_assoc()){
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td class='d-flex gap-3'>
                <a class='btn btn-primary' href='/rtsoft/edit.php?id=" . $row["id"] . "'>Edit</a>
                <form method='post' action='index.php'>
                        <input type='hidden' name='taskId' value='" . $row["id"] . "'>
                        <button type='submit' class='btn btn-danger'>Delete</button>
                    </form>

                
            </td>";
            echo "</tr>";
        } ?>
      
    
  </tbody>
</table>
</div>

<?php include_once 'footer.php'; ?>