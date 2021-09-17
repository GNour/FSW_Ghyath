<?php
require_once "../base/User.php";

echo json_encode(User::checkIfUserLoggedIn());
