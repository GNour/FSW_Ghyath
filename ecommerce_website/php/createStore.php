<?php

require_once "./base/App.php";

if (isset($_POST["submit"])) {
    if ($_FILES["imagePrimary"]["name"] != "" && $_FILES["imageHeader"]["name"]) {
        $target_dir = "../uploads/stores/";

        $imageFileType_primary = strtolower(pathinfo(basename($_FILES["imagePrimary"]["name"]), PATHINFO_EXTENSION));
        $target_file_primary = $target_dir . strtolower($_POST["name"]) . "_primary." . $imageFileType;

        $imageFileType_header = strtolower(pathinfo(basename($_FILES["imageHeader"]["name"]), PATHINFO_EXTENSION));
        $target_file_header = $target_dir . strtolower($_POST["name"]) . "_header." . $imageFileType;

        $uploadok = 1;

        $check_primary = getimagesize($_FILES["imagePrimary"]["tmp_name"]);
        $check_header = getimagesize($_FILES["imageHeader"]["tmp_name"]);

        if ($check_primary !== false && $check_header !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if (file_exists($target_file_primary)) {
            unlink($target_file_primary);
        }

        if (file_exists($target_file_header)) {
            unlink($target_file_header);
        }

        if ($_FILES["imagePrimary"]["size"] > 5000000 || $_FILES["imageHeader"]["size"] > 5000000) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your files was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["imagePrimary"]["tmp_name"], $target_file_primary) &&
                move_uploaded_file($_FILES["imageHeader"]["tmp_name"], $target_file_header)) {

                App::createStore($_POST["name"], $_POST["description"], $_POST["country"], $_POST["city"],
                    $_POST["street"], $_POST["phone"], $_POST["email"], $target_file_primary, $target_file_header);

            } else {
                echo "Failed to create Store";
            }
        }
    }

}
