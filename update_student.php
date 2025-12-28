<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit('Invalid request');
}

$original_reg = isset($_POST['original_reg']) ? trim($_POST['original_reg']) : '';
$new_reg      = isset($_POST['reg_no']) ? trim($_POST['reg_no']) : '';
$name         = isset($_POST['name']) ? trim($_POST['name']) : '';
$dept         = isset($_POST['department']) ? trim($_POST['department']) : '';

if ($original_reg == '' || $new_reg == '' || $name == '' || $dept == '') {
    exit('All fields are required');
}

$original_reg = mysqli_real_escape_string($conn, $original_reg);
$new_reg      = mysqli_real_escape_string($conn, $new_reg);
$name         = mysqli_real_escape_string($conn, $name);
$dept         = mysqli_real_escape_string($conn, $dept);

// Optional: prevent duplicate reg_no when changing it
if ($original_reg != $new_reg) {
    $check_sql = "SELECT reg_no FROM students WHERE reg_no = '$new_reg' LIMIT 1";
    $check_res = mysqli_query($conn, $check_sql);
    if ($check_res && mysqli_num_rows($check_res) > 0) {
        exit('Register number already exists');
    }
}

$sql = "UPDATE students
        SET reg_no = '$new_reg',
            name   = '$name',
            department = '$dept'
        WHERE reg_no = '$original_reg'
        LIMIT 1";

if (mysqli_query($conn, $sql)) {
    echo 'OK';
} else {
    echo 'Update failed: ' . mysqli_error($conn);
}
