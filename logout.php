<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION = array();
        session_destroy();
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
    }
?>