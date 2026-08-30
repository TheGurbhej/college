<?php
include "header.php";
include "conn.php";
?>
    <?php
    $sql = "SELECT * FROM onlineform";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

<main>
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Online Admisson</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
            </li>

        </ul>
        <div class="tab-content  bg-secondary rounded-top-4 m-2  " id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <section>
                    <div class="">
                        <h3 class="text-center text-white mt-4 fw-bold">Admisson From College web</h3>
                    </div>
                    <div>
                        <table id="onlineform" class="table table-light table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Father Name</th>
                                    <th scope="col">Mother Name</th>
                                    <th scope="col">DOB</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Mob.Number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Course</th>
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
                </section>

            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">...</div>
            <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
        </div>
    </div>

</main>

<?php
include "footer.php";
?>