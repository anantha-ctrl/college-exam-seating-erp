<?php
include 'connection.php';
session_start();

// Initialize session variables compatible with PHP 5.4.16
$_SESSION['hall_no'] = isset($_SESSION['hall_no']) ? $_SESSION['hall_no'] : '';
$_SESSION['exam_date'] = isset($_SESSION['exam_date']) ? $_SESSION['exam_date'] : '';
$_SESSION['session_val'] = isset($_SESSION['session_val']) ? $_SESSION['session_val'] : '';
$_SESSION['subject'] = isset($_SESSION['subject']) ? $_SESSION['subject'] : '';
$_SESSION['left_values'] = isset($_SESSION['left_values']) ? $_SESSION['left_values'] : array();
$_SESSION['left_subjects'] = isset($_SESSION['left_subjects']) ? $_SESSION['left_subjects'] : array();
$_SESSION['right_values'] = isset($_SESSION['right_values']) ? $_SESSION['right_values'] : array();
$_SESSION['right_subjects'] = isset($_SESSION['right_subjects']) ? $_SESSION['right_subjects'] : array();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Update hall/session/subject
    $_SESSION['hall_no'] = isset($_POST['hall_no']) ? $_POST['hall_no'] : $_SESSION['hall_no'];
    $_SESSION['exam_date'] = isset($_POST['exam_date']) ? $_POST['exam_date'] : $_SESSION['exam_date'];
    $_SESSION['session_val'] = isset($_POST['session']) ? $_POST['session'] : $_SESSION['session_val'];
    $_SESSION['subject'] = isset($_POST['subject']) ? trim($_POST['subject']) : $_SESSION['subject'];

    // Clear Hall
    if (isset($_POST['clear_hall'])) {
        $_SESSION['hall_no'] = '';
        $_SESSION['exam_date'] = '';
        $_SESSION['session_val'] = '';
        $_SESSION['subject'] = '';
    }

    // Add LEFT seats
    if (!empty($_POST['input_value_left']) && !empty($_POST['input_subject_left'])) {
        $input_values = explode(',', $_POST['input_value_left']);
        $subject = trim($_POST['input_subject_left']);

        foreach ($input_values as $v) {
            $v = trim($v);
            if (strpos($v, '-') !== false) {
                list($s, $e) = explode('-', $v);
                for ($i = intval($s); $i <= intval($e); $i++) {
                    $_SESSION['left_values'][] = $i;
                    $_SESSION['left_subjects'][] = $subject;
                }
            } else {
                $_SESSION['left_values'][] = intval($v);
                $_SESSION['left_subjects'][] = $subject;
            }
        }
    }

    // Add RIGHT seats
    if (!empty($_POST['input_value_right']) && !empty($_POST['input_subject_right'])) {
        $input_values = explode(',', $_POST['input_value_right']);
        $subject = trim($_POST['input_subject_right']);

        foreach ($input_values as $v) {
            $v = trim($v);
            if (strpos($v, '-') !== false) {
                list($s, $e) = explode('-', $v);
                for ($i = intval($s); $i <= intval($e); $i++) {
                    $_SESSION['right_values'][] = $i;
                    $_SESSION['right_subjects'][] = $subject;
                }
            } else {
                $_SESSION['right_values'][] = intval($v);
                $_SESSION['right_subjects'][] = $subject;
            }
        }
    }

    // Clear left/right
    if (isset($_POST['clear_left'])) {
        $_SESSION['left_values'] = array();
        $_SESSION['left_subjects'] = array();
    }
    if (isset($_POST['clear_right'])) {
        $_SESSION['right_values'] = array();
        $_SESSION['right_subjects'] = array();
    }

    // Save both sections
    if (isset($_POST['save'])) {
        $leftArray = $_SESSION['left_values'];
        $leftSubj = $_SESSION['left_subjects'];
        $rightArray = $_SESSION['right_values'];
        $rightSubj = $_SESSION['right_subjects'];

        // Fetch departments
        $leftDept = array();
        foreach ($leftArray as $reg_no) {
            $res = mysqli_query($conn, "SELECT department FROM students WHERE reg_no='$reg_no'");
            $row = mysqli_fetch_assoc($res);
            $leftDept[] = isset($row['department']) ? $row['department'] : '';
        }

        $rightDept = array();
        foreach ($rightArray as $reg_no) {
            $res = mysqli_query($conn, "SELECT department FROM students WHERE reg_no='$reg_no'");
            $row = mysqli_fetch_assoc($res);
            $rightDept[] = isset($row['department']) ? $row['department'] : '';
        }

        $hall_no = mysqli_real_escape_string($conn, $_SESSION['hall_no']);
        $exam_date = mysqli_real_escape_string($conn, $_SESSION['exam_date']);
        $session = mysqli_real_escape_string($conn, $_SESSION['session_val']);
        $total_students = count($leftArray) + count($rightArray);

        $sql = "INSERT INTO exam_seating 
            (odd_i, even_i, odd_dept, even_dept, odd_subjects, even_subjects, hall_no, exam_date, session, total_students)
            VALUES (
                '" . serialize($leftArray) . "',
                '" . serialize($rightArray) . "',
                '" . serialize($leftDept) . "',
                '" . serialize($rightDept) . "',
                '" . serialize($leftSubj) . "',
                '" . serialize($rightSubj) . "',
                '$hall_no',
                '$exam_date',
                '$session',
                $total_students
            )";

        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>✓ Seating saved successfully!</div>";
            // Clear left/right arrays
            $_SESSION['left_values'] = array();
            $_SESSION['left_subjects'] = array();
            $_SESSION['right_values'] = array();
            $_SESSION['right_subjects'] = array();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// Prepare data for display
$left_values = $_SESSION['left_values'];
$left_subjects = $_SESSION['left_subjects'];
$right_values = $_SESSION['right_values'];
$right_subjects = $_SESSION['right_subjects'];

$left_current_index = count($left_values);
$right_current_index = count($right_values);

$hall_no_value = $_SESSION['hall_no'];
$exam_date_value = $_SESSION['exam_date'];
$session_value = $_SESSION['session_val'];
$subject_value = $_SESSION['subject'];
?>


<!DOCTYPE html>
<html>


<head>
    <title>Exam Seating Arrangement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            display: flex;
            flex-direction: column;
        }

        .sections-wrapper {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .left,
        .right {
            flex: 1;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
            word-wrap: break-word;
        }

        #mainTable th {
            background: #f0f8ff;
            color: #333;
        }

        #mainTable th:nth-child(odd) {
            background: #d6eaff;
        }

        #mainTable th:nth-child(even) {
            background: #c1e1c1;
        }

        .a1-box {
            border-top: 1px solid black;
            padding-top: 2px;
            font-weight: bold;
            background: #fff;
            display: inline-block;
            padding: 5px 10px;
        }

        .section-title {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
            color: #007bff;
        }

        .instruction {
            background: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #ffc107;
        }

        .save-section {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #e7f3ff;
            border-radius: 5px;
        }
    </style>
</head>


<body>
    <div class="container">
        <h2 class="text-center mt-3 mb-4">Exam Seating Arrangement</h2>

        <div class="instruction">
            <strong>Instructions:</strong> Enter numbers as: 101,102,103 or 101-110 or mixed 101,105-108
        </div>

        <form method="post">
            <div class="form-row mb-2">
                <div class="col"><input type="text" name="hall_no" value="<?php echo htmlspecialchars($hall_no_value); ?>" placeholder="Hall No" class="form-control"></div>
                <div class="col"><input type="date" name="exam_date" value="<?php echo htmlspecialchars($exam_date_value); ?>" class="form-control"></div>
                <div class="col"><input type="text" name="subject" value="<?php echo htmlspecialchars($subject_value); ?>" placeholder="Subject Name" class="form-control"></div>
                <div class="col">
                    <select name="session" class="form-control">
                        <option value="">Session</option>
                        <option value="FN" <?php echo ($session_value == 'FN') ? 'selected' : ''; ?>>FN</option>
                        <option value="AN" <?php echo ($session_value == 'AN') ? 'selected' : ''; ?>>AN</option>
                    </select>
                </div>
                <div class="col"><input type="submit" name="clear_hall" value="Clear Hall Info" class="btn btn-danger"></div>
            </div>

            <div class="sections-wrapper">
                <div class="left">
                    <div class="section-title">Left Section (Odd Seats - 13)</div>
                    <p>Filled: <strong><?php echo $left_current_index; ?> / 13</strong></p>
                    <?php if ($left_current_index < 13): ?>
                        <input type="text" name="input_value_left" placeholder="e.g., 101-113" class="form-control mb-2">
                        <input type="text" name="input_subject_left" placeholder="Subject for left seats" class="form-control mb-2">
                        <input type="submit" value="Submit Left" class="btn btn-primary mb-2">
                    <?php else: ?>
                        <p class="text-success">✓ All 13 left boxes filled!</p>
                    <?php endif; ?>
                    <input type="submit" name="clear_left" value="Clear Left" class="btn btn-warning">
                </div>

                <div class="right">
                    <div class="section-title">Right Section (Even Seats - 12)</div>
                    <p>Filled: <strong><?php echo $right_current_index; ?> / 12</strong></p>
                    <?php if ($right_current_index < 12): ?>
                        <input type="text" name="input_value_right" placeholder="e.g., 201-212" class="form-control mb-2">
                        <input type="text" name="input_subject_right" placeholder="Subject for right seats" class="form-control mb-2">
                        <input type="submit" value="Submit Right" class="btn btn-primary mb-2">
                    <?php else: ?>
                        <p class="text-success">✓ All 12 right boxes filled!</p>
                    <?php endif; ?>
                    <input type="submit" name="clear_right" value="Clear Right" class="btn btn-warning">
                </div>
            </div>

            <div class="save-section">
                <input type="submit" name="save" value="Save Both Sections" class="btn btn-success" style="font-size:18px;padding:10px 30px;">
                <p style="color:#666;">Save will store both sections and exam details to database</p>
            </div>
        </form>

        <!-- Seating Table -->
        <table id="mainTable">
            <tbody id="tableBody">
                <?php
                // Define seat layout (5x5 example)
                $cells = array(
                    array('odd1', 'even5', 'odd6', 'even10', 'odd11'),
                    array('even1', 'odd5', 'even6', 'odd10', 'even11'),
                    array('odd2', 'even4', 'odd7', 'even9', 'odd12'),
                    array('even3', 'odd4', 'even7', 'odd9', 'even12'),
                    array('odd3', 'even2', 'odd8', 'even8', 'odd13')
                );

                // Build associative arrays with reg_no, name, dept, subject
                $oddValues = array();
                $evenValues = array();
                $oddNames = array();
                $evenNames = array();
                $oddDept = array();
                $evenDept = array();
                $oddSubj = array();
                $evenSubj = array();

                foreach ($left_values as $i => $reg_no) {
                    $oddValues["odd" . ($i + 1)] = $reg_no;
                    $oddNames["odd" . ($i + 1)] = '';
                    $oddDept["odd" . ($i + 1)] = '';
                    $oddSubj["odd" . ($i + 1)] = isset($left_subjects[$i]) ? $left_subjects[$i] : '';
                    if ($reg_no != '') {
                        $res = mysqli_query($conn, "SELECT name, department FROM students WHERE reg_no='$reg_no'");
                        $row = mysqli_fetch_assoc($res);
                        $oddNames["odd" . ($i + 1)] = isset($row['name']) ? $row['name'] : '';
                        $oddDept["odd" . ($i + 1)] = isset($row['department']) ? $row['department'] : '';
                    }
                }

                foreach ($right_values as $i => $reg_no) {
                    $evenValues["even" . ($i + 1)] = $reg_no;
                    $evenNames["even" . ($i + 1)] = '';
                    $evenDept["even" . ($i + 1)] = '';
                    $evenSubj["even" . ($i + 1)] = isset($right_subjects[$i]) ? $right_subjects[$i] : '';
                    if ($reg_no != '') {
                        $res = mysqli_query($conn, "SELECT name, department FROM students WHERE reg_no='$reg_no'");
                        $row = mysqli_fetch_assoc($res);
                        $evenNames["even" . ($i + 1)] = isset($row['name']) ? $row['name'] : '';
                        $evenDept["even" . ($i + 1)] = isset($row['department']) ? $row['department'] : '';
                    }
                }

                // Generate table
                for ($r = 0; $r < 5; $r++) {
                    echo "<tr>";
                    for ($c = 0; $c < 5; $c++) {
                        $key = $cells[$r][$c];
                        $reg_no = isset($oddValues[$key]) ? $oddValues[$key] : (isset($evenValues[$key]) ? $evenValues[$key] : '');
                        $name = isset($oddNames[$key]) ? $oddNames[$key] : (isset($evenNames[$key]) ? $evenNames[$key] : '');
                        $dept = isset($oddDept[$key]) ? $oddDept[$key] : (isset($evenDept[$key]) ? $evenDept[$key] : '');
                        $subj = isset($oddSubj[$key]) ? $oddSubj[$key] : (isset($evenSubj[$key]) ? $evenSubj[$key] : '');
                        $label = chr(65 + $c) . ($r + 1);
                        echo "<th>
                        <div class='a1-box'>$label</div><br>
                        <strong>Reg:</strong> $reg_no<br>
                        <strong></strong> $name<br>
                        <small> $dept</small><br>
                        <small> $subj</small>
                     </th>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <button onclick="openPrintPreview()" class="btn btn-primary mt-3 mb-5">Print Seating Arrangement</button>
    </div>

    <script>
        function openPrintPreview() {
            var tableContent = document.getElementById('tableBody').outerHTML;
            var title = "PROFORMA-I";
            var subtitle2 = "CENTRE:9503- GRACE COLLEGE OF ENGINEERING";
            var hallNoValue = document.querySelector('input[name="hall_no"]').value;
            var examDateValue = document.querySelector('input[name="exam_date"]').value;
            var sessionValue = document.querySelector('select[name="session"]').value;

            var newWindow = window.open('', '', 'width=800,height=600');
            newWindow.document.write('<html><head><title>Print Preview</title>');
            newWindow.document.write('<style>@media print{@page{size:A4 landscape;margin:0;}body{margin:1cm;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid black;padding:8px;text-align:center;word-wrap:break-word;}.a1-box{font-weight:bold;background-color:#fff;display:inline-block;padding:5px 10px;border:1px solid black;}}</style></head><body>');
            newWindow.document.write('<div style="text-align:center"><h1>' + title + '</h1><h2>' + subtitle2 + '</h2></div>');
            newWindow.document.write('<div style="text-align:center"><span>Hall No: ' + hallNoValue + '</span> | <span>Date: ' + examDateValue + '</span> | <span>Session: ' + sessionValue + '</span></div>');
            newWindow.document.write('<table>' + tableContent + '</table>');
            newWindow.document.write('<div style="margin-top:20px"><p>No of Present: _______</p><p>No of Absent: _______</p><p>Note: Hall Superintendent has to encircle absent reg no(s)</p></div>');
            newWindow.document.write('<div style="margin-top:20px; display:flex; justify-content:space-between;"><p>Signature of Hall Superintendent: ___________</p><p>Signature of Chief Superintendent: ___________</p></div>');
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
        }
    </script>
</body>

</html>