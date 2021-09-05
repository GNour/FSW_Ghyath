<?php

require_once "./base/App.php";
if (isset($_POST["submit"])) {
    if ($_FILES["imagePrimary"]["name"] != "" && $_FILES["imageHover"]["name"]) {
        $target_dir = "../uploads/products/";

        $imageFileType_primary = strtolower(pathinfo(basename($_FILES["imagePrimary"]["name"]), PATHINFO_EXTENSION));
        $target_file_primary = $target_dir . strtolower($_POST["name"]) . "_primary." . $imageFileType_primary;

        $imageFileType_hover = strtolower(pathinfo(basename($_FILES["imageHover"]["name"]), PATHINFO_EXTENSION));
        $target_file_hover = $target_dir . strtolower($_POST["name"]) . "_hover." . $imageFileType_hover;

        $uploadok = 1;

        $check_primary = getimagesize($_FILES["imagePrimary"]["tmp_name"]);
        $check_hover = getimagesize($_FILES["imageHover"]["tmp_name"]);

        if ($check_primary !== false && $check_hover !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if (file_exists($target_file_primary)) {
            unlink($target_file_primary);
        }

        if (file_exists($target_file_hover)) {
            unlink($target_file_hover);
        }

        if ($_FILES["imagePrimary"]["size"] > 5000000 || $_FILES["imageHover"]["size"] > 5000000) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your files was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["imagePrimary"]["tmp_name"], $target_file_primary) &&
                move_uploaded_file($_FILES["imageHover"]["tmp_name"], $target_file_hover)) {
                $images[] = $target_file_primary;
                $images[] = $target_file_hover;

                App::addProduct($_POST["name"], $_POST["description"], $_POST["price"], $_POST["quantity"], $images);

            } else {
                echo "Failed To Add Product";
            }
        }
    }

}
