<?php
require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM data_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    $errors = "";
    //connect to database
    $db = mysqli_connect('localhost', 'root', '', 'user_relgog');
    if (isset($_POST['submit'])){
        $task = $_POST['task'];
        $deadline = $_POST['deadline'];
        $deadline = date('Y-m-d', strtotime($_POST['deadline']));

        if(empty($task)){
            $errors = "You must fill in the task";
        }else{
            mysqli_query($db, "INSERT INTO tasks (task, deadline, id_user) VALUES ('$task','$deadline', '$id')");
            header('location: index.php');
        }
    }
    //delete task
    if (isset($_GET['del_task'])){
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
        header('location: index.php');
    }
    //mark task as done
    if (isset($_GET['done_task'])){
        $id = $_GET['done_task'];
        mysqli_query($db, "UPDATE tasks SET status='finished' WHERE id=$id");
        header('location: index.php');
    }
    //mark to unfinished task 
    if (isset($_GET['restore_task'])){
        $id = $_GET['restore_task'];
        mysqli_query($db, "UPDATE tasks SET status='unfinished' WHERE id=$id");
        header('location: index.php');
    }
    $tasks_unfinished = mysqli_query($db, "SELECT * FROM tasks WHERE id_user = $id AND status='unfinished'");
    $tasks_finished = mysqli_query($db, "SELECT * FROM tasks WHERE id_user = $id AND status='finished'");
}
else{
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="styleIndex.css">
    <style>
    body {
        font-family: 'Poppins';
        font-size: 24px;
    }
    </style>
    <title>LnT Back End Project</title>
</head>
<body>
<div class="grid">
    <div class="heading">
        <h1>Welcome <?php echo $row["name"]; ?></h1>
    </div>
    <form action="index.php" method="POST">
    <?php if (isset($errors)){ ?>
        <p><?php echo $errors;?></p>
    <?php }?>
        <label for="" class="NoBold">Task Name :</label>
        <input type="text" name="task" class="field" placeholder="Task Name"><br>
        <label for="" class="NoBold">Deadline  &nbsp  &nbsp&nbsp:</label>
        <input type="date" name="deadline" class="field"><br>
        <button type="submit" class="add_btn" value="submit" name="submit">Add Task</button>
    </form>
    <table class="NoBold">
    <thead>
    <div class="heading">
        <h1>Unfinished Tasks</h1>
    </div>
        <tr height="45px">
            <th width="28px">No</th>
            <th align="left" width="250px">Tasks</th>
            <th align="left" width="150px">Deadline</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if(mysqli_num_rows($tasks_unfinished)==0){ ?>
            <tr height="45px">
                <td colspan="5">There's no task to do</td>
            </tr>
        <?php }else {
            $i = 1;
            while($row = mysqli_fetch_array($tasks_unfinished)){ ?>
            <tr height="45px">
                <td align="center"><?php echo $i; ?></td>
                <td class="task"><?php echo $row['task']; ?></td>
                <td class="deadline"><?php echo $row['deadline']; ?></td>
                <td class="done"><a href="index.php?done_task=<?php echo $row['id'] ?>">
                    <svg fill="#63cf65" height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#63cf65"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M474.045,173.813c-4.201,1.371-6.494,5.888-5.123,10.088c7.571,23.199,11.411,47.457,11.411,72.1 c0,62.014-24.149,120.315-68,164.166s-102.153,68-164.167,68s-120.316-24.149-164.167-68S16,318.014,16,256 S40.149,135.684,84,91.833s102.153-68,164.167-68c32.889,0,64.668,6.734,94.455,20.017c28.781,12.834,54.287,31.108,75.81,54.315 c3.004,3.239,8.066,3.431,11.306,0.425c3.24-3.004,3.43-8.065,0.426-11.306c-23-24.799-50.26-44.328-81.024-58.047 C317.287,15.035,283.316,7.833,248.167,7.833c-66.288,0-128.608,25.813-175.48,72.687C25.814,127.392,0,189.712,0,256 c0,66.287,25.814,128.607,72.687,175.479c46.872,46.873,109.192,72.687,175.48,72.687s128.608-25.813,175.48-72.687 c46.873-46.872,72.687-109.192,72.687-175.479c0-26.332-4.105-52.26-12.201-77.064 C482.762,174.736,478.245,172.445,474.045,173.813z"></path> <path d="M504.969,83.262c-4.532-4.538-10.563-7.037-16.98-7.037s-12.448,2.499-16.978,7.034l-7.161,7.161 c-3.124,3.124-3.124,8.189,0,11.313c3.124,3.123,8.19,3.124,11.314-0.001l7.164-7.164c1.51-1.512,3.52-2.344,5.66-2.344 s4.15,0.832,5.664,2.348c1.514,1.514,2.348,3.524,2.348,5.663s-0.834,4.149-2.348,5.663L217.802,381.75 c-1.51,1.512-3.52,2.344-5.66,2.344s-4.15-0.832-5.664-2.348L98.747,274.015c-1.514-1.514-2.348-3.524-2.348-5.663 c0-2.138,0.834-4.149,2.351-5.667c1.51-1.512,3.52-2.344,5.66-2.344s4.15,0.832,5.664,2.348l96.411,96.411 c1.5,1.5,3.535,2.343,5.657,2.343s4.157-0.843,5.657-2.343l234.849-234.849c3.125-3.125,3.125-8.189,0-11.314 c-3.124-3.123-8.189-3.123-11.313,0L212.142,342.129l-90.75-90.751c-4.533-4.538-10.563-7.037-16.98-7.037 s-12.448,2.499-16.978,7.034c-4.536,4.536-7.034,10.565-7.034,16.977c0,6.412,2.498,12.441,7.034,16.978l107.728,107.728 c4.532,4.538,10.563,7.037,16.98,7.037c6.417,0,12.448-2.499,16.977-7.033l275.847-275.848c4.536-4.536,7.034-10.565,7.034-16.978 S509.502,87.794,504.969,83.262z"></path> </g> </g></svg>
                </a></td>
                <td class="delete">
                    <a href="index.php?del_task=<?php echo $row['id'] ?>">
                    <svg viewBox="0 0 24 24" fill="none" height="29.3px" width="29.3px" xmlns="http://www.w3.org/2000/svg" stroke="#ff0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16 8L8 16M12 12L16 16M8 8L10 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#ff0000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </a>
                </td>
            </tr>
        <?php $i++; }
        }?>
    </tbody>
</table>

<table class="NoBold">
    <thead>
    <div class="heading">
        <h1>Finished Tasks</h1>
    </div>
        <tr height="45px">
            <th width="28px">No</th>
            <th align="left" width="250px">Tasks</th>
            <th align="left" width="150px">Deadline</th>
            <th>Restore</th>
        </tr>
    </thead>
    <tbody>
        <?php if(mysqli_num_rows($tasks_finished)==0){ ?>
            <tr height="45px">
                <td colspan="4">There's no completed task</td>
            </tr>
        <?php } else {
        $i = 1;
        while($row = mysqli_fetch_array($tasks_finished)){ ?>
            <tr height="45px">
                <td align="center"><?php echo $i; ?></td>
                <td class="task"><?php echo $row['task']; ?></td>
                <td class="deadline"><?php echo $row['deadline']; ?></td>
                <td align="center"><a href="index.php?restore_task=<?php echo $row['id'] ?>">
                <svg viewBox="0 0 24 24" height="25px" width="25px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 20V4L18 10M9 7L6 10" stroke="#52d4ff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                </a></td>
            </tr>
        <?php $i++; } 
        }?>
    </tbody>
</table>
    <div class="kataMutiara">
        <br>
        <p> Finished? <br>
        <a href="logout.php">Logout</a>
    </div>
</div>
</body>
</html>