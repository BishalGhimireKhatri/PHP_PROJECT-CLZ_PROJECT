<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operation</title>
</head>
<body>
<?php
    include("database.php");
    ?>
    <?php
    $users = [];
    $sql = "SELECT * from member_information";
    $query = $conn->prepare($sql);
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $users = $query->fetchAll();
    ?>
    <a href="$/ROOT/mysite/PHP_PROJECT/Register.php">Add book</a>
    <br>
    <table border="1px solid;">
        <thead>
            <th>booknumber</th>
            <th>name</th>
            <th>bookname</th>
            <th>borrowDate</th>
            <th>returnDate</th>
        </thead>
        <tbody>
        <?php
            foreach ($users as $value) {
                echo "<tr>";
                echo "<td>" . $value['id'] . "</td>";
                echo "<td>" . $value['username'] . "</td>";
                echo "<td>" . $value['email'] . "</td>";
                echo "<td>" . $value['password'] . "</td>";
                echo "<td><a href='edit_delete/update.php?id=" . $value['id'] . "'>edit</a></td>";
                echo "<td><a href='edit_delete/delete.php?id=" . $value['id'] . "'>delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>