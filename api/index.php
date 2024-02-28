<?php

require_once 'database.php';
require_once 'util.php';
require_once 'topic_validator.php';
$database = new Database;
$topics = $database->read();
$lastTopic = $database->readLast();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['body'])) {
        $validation = new TopicValidator($_POST);
        $errors = $validation->validateForm();

        if (!$errors) {
            $title = test_intput($_POST['title']);
            $body = test_intput($_POST['body']);
            $database->insert(test_intput($title), $body);
            $lastTopic = $database->readLast();
            $topics = $database->read();
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>ตั้งกระทู้ใหม่</title>
</head>

<body>
    <br><br>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>ตั้งกระทู้ใหม่</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <label for="title">หัวข้อกระทู้</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="หัวข้อกระทู้" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''  ?>">
                            <?php
                            if (array_key_exists('title', $errors)) {
                                echo "<p class='text-danger'>" . $errors['title'] . "</p>";
                            }
                            ?>
                            <br>
                            <label for="body">เนื้อหากระทู้</label>
                            <textarea class="form-control" id="body" name="body" rows="4" placeholder="เนื้อหากระทู้"><?php echo isset($_POST['body']) ? $_POST['body'] : ''  ?></textarea>
                            <?php
                            if (array_key_exists('body', $errors)) {
                                echo "<p class='text-danger'>" . $errors['body'] . "</p>";
                            }
                            ?>

                            <br>
                            <input type="submit" class="btn btn-primary" value="สร้างกระทู้">
                        </form>
                    </div>
                </div>
                <br>
                <div class="card shadow">
                    <div class="card-header">
                        <h4>กระทู้ล่าสุด</h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php
                            if ($lastTopic) {
                                echo "โพสต์ล่าสุดเมื่อ " . date('d/m/Y H:i:s', strtotime($lastTopic['created_at']));
                            } else {
                                echo "ยังไม่มีกระทู้";
                            }
                            ?>
                        </h6>
                    </div>
                    <?php if ($lastTopic) {
                        echo "<div class='card-body'>";

                        echo "<h4 class='card-title mt-3'><u>" . htmlspecialchars_decode($lastTopic['title']) . "</u></h4>";
                        echo "<p class='card-text'>" . htmlspecialchars_decode($lastTopic['body']) . "</p>";

                        echo "</div>";
                    }
                    ?>

                </div>
                <br>
                <div class="card shadow">
                    <div class="card-header">
                        <h4>กระทู้ทั้งหมด</h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php
                            if (!$lastTopic) {
                                echo "ยังไม่มีโพสต์";
                            } else {
                                echo "จำนวน " . count($topics) . " กระทู้";
                            }
                            ?>
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        foreach ($topics as $topic) {
                            echo "<li class='list-group-item'>";
                            echo "<h5 class='card-title mt-2'><u>" . $topic['title'] . "</u></h5>";
                            echo "<p class='card-text'>" . htmlspecialchars_decode($topic['body']) . "</p>";
                            echo "</li>";
                        }
                        ?>
                    </ul>

                </div>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
</body>

</html>