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
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    ✓ Seating saved successfully!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                 </div>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/png">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }


        /* A1 label (screen + print) */
        .a1-box {
            position: absolute;
            top: 0px;
            /* small overlap above cell */
            left: 50%;
            transform: translateX(-50%);
            padding: 1px 8px;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid #000;
            border-radius: 4px;
            background: #fff;
        }


        /* Responsive Container */
        .left,
        .right {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
            height: 100%;
        }


        /* Table Styling */
        .table-responsive {
            margin-top: 20px;
            border: 1px solid #dee2e6;
        }


        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            min-width: 800px;
        }


        th,
        td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
            word-wrap: break-word;
            vertical-align: top;
        }


        /* CELL CONTENT: REGNO, NAME, DEPT, SUBJ */
        th .regno,
        th .name,
        th .dept,
        th .subj {
            display: block;
            width: 100%;
            text-align: center;
            margin: 0;
            line-height: 1.1;
        }


        /* FIRST LINE BIG REGISTER NO */
        th .regno {
            margin-top: 14px;
            /* distance from A1 to REG NO */
            font-size: 20px;
            font-weight: bold;
        }


        /* SECOND LINE SMALLER NAME */
        th .name {
            font-size: 13px;
            font-weight: bold;
        }


        /* THIRD / FOURTH LINES: DEPT, SUBJECT */
        th .dept,
        th .subj {
            font-size: 11px;
        }


        #mainTable th {
            background: #f0f8ff;
            color: #333;
            position: relative;
            /* needed for absolute A1 */
            padding-top: 18px;
            /* space for A1 box */
        }


        #mainTable th:nth-child(odd) {
            background: #d6eaff;
        }


        #mainTable th:nth-child(even) {
            background: #c1e1c1;
        }


        .section-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #007bff;
        }


        .instruction {
            background: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #ffc107;
            font-size: 0.9rem;
        }


        .save-section {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #e7f3ff;
            border-radius: 5px;
        }


        @media (max-width: 768px) {
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }


            h2 {
                font-size: 1.5rem;
            }


            td,
            th {
                padding: 5px;
                font-size: 12px;
            }


            th .regno {
                font-size: 18px;
            }


            th .name {
                font-size: 12px;
            }


            th .dept,
            th .subj {
                font-size: 10px;
            }
        }
    </style>



</head>


<body>
    <?php include 'menu.php'; ?>



    <div class="container-fluid px-lg-5 mt-3">





        <form method="post">
            <div class="form-row align-items-center mb-3">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <input type="text" name="hall_no" value="<?php echo htmlspecialchars($hall_no_value); ?>" placeholder="Hall No" class="form-control">
                </div>


                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <input type="date" name="exam_date" value="<?php echo htmlspecialchars($exam_date_value); ?>" class="form-control">
                </div>


                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <select name="session" class="form-control">
                        <option value="">Session</option>
                        <option value="FN" <?php echo ($session_value == 'FN') ? 'selected' : ''; ?>>FN</option>
                        <option value="AN" <?php echo ($session_value == 'AN') ? 'selected' : ''; ?>>AN</option>
                    </select>
                </div>


                <div class="col-12 col-lg-2 mb-2">
                    <input type="submit" name="clear_hall" value="Clear Info" class="btn btn-danger btn-block">
                </div>
            </div>



            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="left h-100">
                        <div class="section-title">Left Section (Odd - 13)</div>
                        <p>Filled: <strong><?php echo $left_current_index; ?> / 13</strong></p>
                        <?php if ($left_current_index < 13): ?>
                            <div class="form-group">
                                <input type="text" name="input_value_left" placeholder="e.g., 101-113" class="form-control mb-2">
                                <input type="text" name="input_subject_left" placeholder="Subject for left" class="form-control mb-2">
                                <input type="submit" value="Submit Left" class="btn btn-primary btn-block mb-2">
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success py-2">✓ Full</div>
                        <?php endif; ?>
                        <input type="submit" name="clear_left" value="Clear Left" class="btn btn-warning btn-sm btn-block">
                    </div>
                </div>


                <div class="col-12 col-lg-6">
                    <div class="right h-100">
                        <div class="section-title">Right Section (Even - 12)</div>
                        <p>Filled: <strong><?php echo $right_current_index; ?> / 12</strong></p>
                        <?php if ($right_current_index < 12): ?>
                            <div class="form-group">
                                <input type="text" name="input_value_right" placeholder="e.g., 201-212" class="form-control mb-2">
                                <input type="text" name="input_subject_right" placeholder="Subject for right" class="form-control mb-2">
                                <input type="submit" value="Submit Right" class="btn btn-primary btn-block mb-2">
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success py-2">✓ Full</div>
                        <?php endif; ?>
                        <input type="submit" name="clear_right" value="Clear Right" class="btn btn-warning btn-sm btn-block">
                    </div>
                </div>
            </div>


            <div class="save-section container my-4">


                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">


                    <!-- LEFT SIDE -->
                    <div class="mr-md-3">
                        <input type="submit" name="save" value="Save Both Sections" class="btn btn-success btn-lg">
                        <p class="mt-2 text-muted small">Save will store both sections and exam details to database</p>
                    </div>


                    <!-- RIGHT SIDE -->
                    <div class="mt-3 mt-md-0">
                        <button type="button" onclick="openPrintPreview()" class="btn btn-primary btn-lg">
                            Print Seating Arrangement
                        </button>
                    </div>


                </div>


            </div>


        </form>


        <div class="row mb-3">



            <div class="table-responsive">
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
    <div class='a1-box'>$label</div>
    <span class='regno'>$reg_no</span>
    <span class='name'>$name</span>
    <span class='dept'>$dept</span>
    <span class='subj'>$subj</span>
</th>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>


            <button type="button" onclick="openPrintPreview()" class="btn btn-primary btn-block btn-lg mt-3 mb-5">Print Seating Arrangement</button>


        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        <script>
            function openPrintPreview() {


                var tableContent = document.getElementById('tableBody').outerHTML;
                var title = "PROFORMA-I";
                var subtitle2 = "CENTRE:9503 - GRACE COLLEGE OF ENGINEERING";
                var hallNoValue = document.querySelector('input[name="hall_no"]').value;
                var examDateValue = document.querySelector('input[name="exam_date"]').value;
                var sessionValue = document.querySelector('select[name="session"]').value;


                var newWindow = window.open('', '', 'width=800,height=600');


                newWindow.document.write(`
        <html>
        <head>
            <title>Print Preview</title>


<style>
@media print {


    @page {
        size: A4 landscape;
        margin: 0;
    }


    body {
        margin: 1cm;
        font-family: Arial, sans-serif;
    }


    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px !important;
    }


  th, td {
    border: 1px solid black;
    text-align: center;
    vertical-align: top;
    padding: 6px !important;
    padding-top: 14px !important;
    word-wrap: break-word;
    position: relative;      /* IMPORTANT for A1 */
    height: 80px;            /* fixed cell height */
    max-height: 80px;        /* prevent growth */
    overflow: hidden;        /* hide extra content if too long */
}



    .a1-box {
       position: absolute;
top: 0px;
left: 50%;
transform: translateX(-50%);
width: 20px;                 /* same width and height  */
height: 20px;
padding: 0;                  /* let width/height control size */
font-size: 9px !important;
font-weight: bold;
border: 2px solid #000;
border-radius: 2px;          /* or 0 for sharp corners */
background: #fff;
display: flex;               /* center text inside box */
align-items: center;
justify-content: center;

    }


     th span.regno,
    th span.name,
    th span.dept,
    th span.subj {
        display: block !important;
        width: 100%;
        text-align: center !important;
        margin: 0 !important;
        line-height: 1.2 !important;
    }

    th span.regno {
        margin-top: 14px !important;
        font-size: 16px !important;
        font-weight: bold !important;
    }

    th span.name {
        font-size: 12px !important;
        font-weight: bold !important;
    }

    th span.dept,
    th span.subj {
        font-size: 11px !important;
        font-weight: normal !important;
    }
            }


            .proforma-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.proforma-header .ph-left,
.proforma-header .ph-right {
    width: 80px;
    text-align: center;
}

.proforma-header .ph-center {
    flex: 1;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    line-height: 1.2;
}

.proforma-header .ph-logo {
    max-width: 70px;
    max-height: 70px;
}

</style>





        </head>
        <body>
    `);


                // HEADER
                // HEADER WITH LEFT LOGO & RIGHT TEXT
                newWindow.document.write(`
    <div class="proforma-header">
        <div class="ph-left">
            <img src="au.png" alt="Logo" class="ph-logo">
        </div>
        <div class="ph-center">
            <div><strong>${title}</strong></div>
            <div>${subtitle2}</div>
            <div style="margin-top:4px; font-size:14px; font-weight:normal;">
                <strong>Hall No:</strong> ${hallNoValue}
                &nbsp; | &nbsp;
                <strong>Date:</strong> ${examDateValue}
                &nbsp; | &nbsp;
                <strong>Session:</strong> ${sessionValue}
            </div>
        </div>
        <div class="ph-right">
   <img src="grace.png" alt="Logo" class="ph-logo">
        </div>
    </div>
`);



                // TABLE
                newWindow.document.write(`
        <table>${tableContent}
        <?php
        $all_subjects   = array_merge($left_subjects, $right_subjects);
        $subject_counts = array_count_values($all_subjects);
        $names          = array_keys($subject_counts);
        $total          = count($names);
        $half           = ceil($total / 2);

        $left_names  = array_slice($names, 0, $half);
        $right_names = array_slice($names, $half);
        ?>
        
        </table>
<?php
$all_subjects   = array_merge($left_subjects, $right_subjects);
$subject_counts = array_count_values($all_subjects);

$parts = array();
foreach ($subject_counts as $name => $cnt) {
    $parts[] = htmlspecialchars($name) . ' : ' . intval($cnt);
}
$line = implode(' || ', $parts);
?>

<div class="mt-3">
  
    <div><?php echo $line; ?></div>
</div>
    `);



                // PRESENT/ABSENT SECTION
                newWindow.document.write(`
        <div style="margin-top:18px; font-size:13px;">
            <p>No. of Present: __________________</p>
            <p>No. of Absent: ___________________</p>
            <p><strong>Note:</strong> Hall Superintendent has to encircle the absent Register Number(s)</p>
        </div>
    `);


                // SIGNATURE SECTION
                newWindow.document.write(`
        <div style="margin-top:30px; display:flex; justify-content:space-between; font-size:15px;">
            <p>Signature of Hall Superintendent</p>
            <p>Signature of Chief Superintendent</p>
        </div>
    `);

                newWindow.document.write(`
    <footer style="
        position: fixed;
        bottom: 0;
        width: 100%;
        font-size: 12px;
        text-align: center;
        border-top: 1px solid #000;
        padding: 8px 0;
        background-color: #fff;">
        © 2025 Grace College of Engineering - Exam Seating Arrangement
    </footer>
`);


                newWindow.document.write(`</body></html>`);
                newWindow.document.close();
                newWindow.print();
            }

            // SUBJECT COUNT (two columns: first half left, second half right)
            var subjectCounts = {};
            var subjSpans = document.querySelectorAll('#tableBody .subj');
            subjSpans.forEach(function(el) {
                var txt = el.textContent.trim();
                if (!txt) return;
                subjectCounts[txt] = (subjectCounts[txt] || 0) + 1;
            });

            var names = Object.keys(subjectCounts);
            var total = names.length;
            var half = Math.ceil(total / 2);

            var leftNames = names.slice(0, half);
            var rightNames = names.slice(half);

            var leftHtml = '';
            var rightHtml = '';

            leftNames.forEach(function(name) {
                leftHtml += name + ' : ' + subjectCounts[name] + '<br>';
            });
            rightNames.forEach(function(name) {
                rightHtml += name + ' : ' + subjectCounts[name] + '<br>';
            });

            newWindow.document.write(`
    <div style="margin-top:10px; font-size:13px;">
        <strong>Subject-wise Count:</strong>
        <div style="display:flex; justify-content:space-between; margin-top:4px;">
            <div style="width:50%; text-align:left;">${leftHtml}</div>
            <div style="width:50%; text-align:right;">${rightHtml}</div>
        </div>
    </div>
`);
        </script>
</body>


</html>
<?php include 'footer.php'; ?>