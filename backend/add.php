<?php
require_once 'db.php';
require_once 'member.php';

header("Content-Type: application/json; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $data = $_POST;

    $name = $data['name'];
    $email = $data['email'];
    $school = $data['school'];

    // Instantiate DB & connect
    $database = new Database();

    $member = new Member($name, $email, $school);

    if ($database->insertMember($member)) {
        echo json_encode(
            array('message' => 'Success')
        );
    } else {
        echo json_encode(
            array('message' => 'Error')
        );
    }
}
