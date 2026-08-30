<?php
include "conn.php";

if (isset($_POST['name'])) {

    $sql = "INSERT INTO teacher
    (name,department,qualification,designation,date,salary,address)
    VALUES
    (:name,:department,:qualification,:designation,:date,:salary,:address)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':name' => $_POST['name'],
        ':department' => $_POST['department'],
        ':qualification' => $_POST['qualification'],
        ':designation' => $_POST['designation'],
        ':date' => $_POST['date'],
        ':salary' => $_POST['salary'],
        ':address' => $_POST['address']
    ]);

    echo "success";
}
