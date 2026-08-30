<?php
include "conn.php";

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">Room NO</th>
            </tr>
        </thead>
        <tbody>
           
            <?php
            $stmt = $conn->prepare("SELECT * FROM depart");
            $stmt->execute();




            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['roomno']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>






      <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">Salary</th>
            </tr>
        </thead>
        <tbody>
           
            <?php
            $stmt = $conn->prepare("SELECT * FROM emp");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['salary']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>




      <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">Salary</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
            $stmt = $conn->prepare("SELECT id,name,salary FROM emp 
            
            INNER JOIN roomno ON emp.salary
            ");
            $stmt->execute();
            
           

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['salary']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>