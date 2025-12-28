<?php
include 'connection.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reg_no = trim($_POST['reg_no']);
    $name   = trim($_POST['name']);
    $dept   = trim($_POST['department']);

    if ($reg_no == '' || $name == '' || $dept == '') {
        $msg = "All fields are required.";
    } else {
        $reg_no_esc = mysqli_real_escape_string($conn, $reg_no);
        $name_esc   = mysqli_real_escape_string($conn, $name);
        $dept_esc   = mysqli_real_escape_string($conn, $dept);

        $check_sql = "SELECT reg_no FROM students WHERE reg_no = '$reg_no_esc' LIMIT 1";
        $check_res = mysqli_query($conn, $check_sql);
        if ($check_res && mysqli_num_rows($check_res) > 0) {
            $msg = "Register number already exists.";
        } else {
            $ins_sql = "INSERT INTO students (reg_no, name, department) VALUES ('$reg_no_esc', '$name_esc', '$dept_esc')";
            if (mysqli_query($conn, $ins_sql)) {
                $msg = "Student added successfully.";
                $reg_no = $name = $dept = "";
            } else {
                $msg = "Insert failed: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/x-icon"> 
    <style>
        /* Base Styles (Mobile First) */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-top: 20px;
        }
        .card-header {
            background: #eee;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .card-body { padding: 20px; }
        
        /* Form Styling */
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-control {
            width: 100%;
            padding: 10px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .alert {
            padding: 15px;
            background-color: #d1ecf1;
            color: #0c5460;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        /* Buttons */
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }

        /* --- Responsive Breakpoints --- */

        /* Tablet View (600px and up) */
        @media (min-width: 600px) {
            .container { max-width: 80%; }
            .card { margin-top: 40px; }
        }

        /* Desktop/Laptop View (1024px and up) */
        @media (min-width: 1024px) {
            .container { max-width: 500px; } /* Centered narrow form for readability */
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Add Student</h3>
            </div>
            <div class="card-body">
                <?php if ($msg != ""): ?>
                    <div class="alert">
                        <?php echo htmlspecialchars($msg); ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label>Register Number</label>
                        <input type="text" name="reg_no" class="form-control" 
                               value="<?php echo isset($reg_no) ? htmlspecialchars($reg_no) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" name="name" class="form-control" 
                               value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="department" class="form-control" 
                               value="<?php echo isset($dept) ? htmlspecialchars($dept) : ''; ?>" required>
                    </div>

                    <div class="btn-group">
                        <a href="seat.php" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-success">Save Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

