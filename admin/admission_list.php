<?php
include "header.php";
include "conn.php"
?>

<main>
    <div class="">
        <div class="container p-3 ">
            <h1 class="text-white bg-primary p-1 text-center rounded-3">Admisson list</h1>

             <div>
                <div class="table-responsive">
                    <table id="onlineform" class="table table-striped table-bordered  table-hover table-sm align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Sn</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Category</th>
                                <th>Mob.Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM onlineform");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['fname']; ?></td>
                                    <td><?= $row['mname']; ?></td>
                                    <td><?= $row['dob']; ?></td>
                                    <td><?= $row['gender']; ?></td>
                                    <td><?= $row['category']; ?></td>
                                    <td><?= $row['mnumber']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['address']; ?></td>
                                    <td><?= $row['course']; ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    </div>
    </div>
</main>

<?php
include "footer.php"
?>