<?php
    include 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // $username = "gag";
    // $password = "6102041610041";

    $query = $connect->query("SELECT * FROM member WHERE username='".$username."' and password='".$password."'");

    $result = array();

    while($fetchData=$query->fetch_assoc()) {
        $result[]=$fetchData;
    }

    echo json_encode($result);

?>