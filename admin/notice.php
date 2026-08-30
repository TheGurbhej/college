<?php
include "header.php";
include "conn.php";
if (isset($_POST['addNotice'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $link = $_POST['link'];

    $sql = "INSERT INTO noticeboard (title,body,link) VALUES (:title,:body,:link)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(
        [
            ':title' => $title,
            ':body' => $body,
            ':link' => $link
        ]
    );

    echo "Notice added";
}
?>
<?php
$stmt = $conn->prepare("SELECT * FROM noticeboard ORDER BY id DESC");
$stmt->execute();
$notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div class="container p-4">
        <h1 class="text-white">Notice Board Management (Show in main web)</h1>
        <div class="bg-dark rounded-4 m-3 p-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-white" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Create Notice</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-white" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Notice Board</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">

                    <div>
                        <form method="POST" class="row  g-3 p-3 w-50">
                            <div class="col-md-12">
                                <label for="inputEmail4" class="form-label text-white">Notice Title</label>
                                <input type="text" name="title" class="form-control" id="">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label text-white">Notice Body</label>
                                <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-white"> Link</label>
                                <input type="url" name="link" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="reset" class="btn  btn-outline-primary">Reset</button>
                                <button type="submit" name="addNotice" class="btn btn-outline-success">
                                    Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="bg-dark">
                        <h1 class="text-white">Notice Board</h1>
                        <div>
                            <div class="container py-4">

                                <h2 class="text-white mb-4">Latest Notices</h2>

                                <div class="row g-4">

                                    <?php if (count($notices) > 0) { ?>

                                        <?php foreach ($notices as $notice) { ?>

                                            <div class="col-md-6 col-lg-4">

                                                <div class="card h-100 rounded-3  border-2">

                                                    <div class="card-header bg-primary py-3 text-white">
                                                        <h5 class="mb-0">
                                                            <?= htmlspecialchars($notice['title']); ?>
                                                        </h5>
                                                    </div>

                                                    <div class="card-body bg-dark ">

                                                        <p class="text-white">
                                                            <?= nl2br(htmlspecialchars($notice['body'])); ?>
                                                        </p>

                                                    </div>
                                                </div>

                                            </div>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                No Notices Available.
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        >
    </div>
</main>
<?php
include "footer.php";
?>