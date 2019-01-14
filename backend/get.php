<?php
require_once 'db.php';
require_once 'member.php';

header("Content-Type: application/json; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (isset($_GET['school'])) {

        //get query string
        $schoolId = $_GET['school'];

        // Instantiate DB & connect
        $database = new Database();

        $result = $database->getMembers($schoolId);

        if ($result) {
            //rename m_name & m_email  keys to name & email (for security reasons)
            $result = array_map(function ($val) {
                return array(
                    'name' => $val['m_name'],
                    'email' => $val['m_email'],
                );
            }, $result);
            //output result
            echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        } else {
            if (empty($result)) {
                //query done but returned 0 rows
                echo json_encode(
                    array('message' => 'No data found')
                );
            } else {
                echo json_encode(
                    array('message' => 'Error')
                );
            }

        }
    }
}
