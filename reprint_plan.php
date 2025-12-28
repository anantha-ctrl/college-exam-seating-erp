<?php
include 'connection.php';
session_start();

// Initialize session variables compatible with PHP 5.4.16
$_SESSION['hall_no'] = isset($_SESSION['hall_no']) ? $_SESSION['hall_no'] : 'H1';
$_SESSION['exam_date'] = isset($_SESSION['exam_date']) ? $_SESSION['exam_date'] : date('Y-m-d');
$_SESSION['session_val'] = isset($_SESSION['session_val']) ? $_SESSION['session_val'] : 'FN';
$_SESSION['left_values'] = isset($_SESSION['left_values']) ? $_SESSION['left_values'] : [101, 102, 103];
$_SESSION['left_subjects'] = isset($_SESSION['left_subjects']) ? $_SESSION['left_subjects'] : ['Math', 'Math', 'Physics'];
$_SESSION['right_values'] = isset($_SESSION['right_values']) ? $_SESSION['right_values'] : [201, 202];
$_SESSION['right_subjects'] = isset($_SESSION['right_subjects']) ? $_SESSION['right_subjects'] : ['Chemistry', 'Biology'];

// Prepare data for display
$left_values = $_SESSION['left_values'];
$left_subjects = $_SESSION['left_subjects'];
$right_values = $_SESSION['right_values'];
$right_subjects = $_SESSION['right_subjects'];

$hall_no_value = $_SESSION['hall_no'];
$exam_date_value = $_SESSION['exam_date'];
$session_value = $_SESSION['session_val'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Exam Seating Arrangement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            border: 1px solid black;
            padding: 8px;
            height: 80px;
            position: relative;
            vertical-align: top;
            background-color: #e3f2fd;
            text-align: center;
        }

        .a1-box {
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border: 1px solid black;
            width: 20px;
            height: 20px;
            font-weight: bold;
            line-height: 20px;
            font-size: 12px;
            border-radius: 3px;
        }

        span.regno {
            display: block;
            margin-top: 24px;
            font-weight: bold;
            font-size: 18px;
        }

        span.subj {
            display: block;
            font-size: 12px;
            margin-top: 4px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 50px;
            vertical-align: middle;
        }

        .header h1 {
            display: inline-block;
            margin-left: 10px;
            vertical-align: middle;
            font-size: 24px;
            color: #007bff;
        }

        .info-bar {
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }

        #print-button {
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="https://res.cloudinary.com/de1tywvqm/image/upload/v1764171191/au_logo_f8g8al.png" alt="AU Logo" />
        <h1>Grace College - Exam Seating</h1>
    </div>

    <div class="info-bar">
        <strong>Hall No:</strong> <?php echo htmlspecialchars($hall_no_value); ?> |
        <strong>Date:</strong> <?php echo htmlspecialchars($exam_date_value); ?> |
        <strong>Session:</strong> <?php echo htmlspecialchars($session_value); ?>
    </div>

    <div class="table-responsive">
        <table id="seatingTable">
            <tbody>
                <?php
                $cells = [
                    ['odd1', 'even1', 'odd2', 'even2', 'odd3'],
                    ['even3', 'odd4', 'even4', 'odd5', 'even5'],
                    ['odd6', 'even6', 'odd7', 'even7', 'odd8'],
                    ['even8', 'odd9', 'even9', 'odd10', 'even10'],
                    ['odd11', 'even11', 'odd12', 'even12', 'odd13']
                ];

                $oddValues = [];
                $evenValues = [];
                $oddSubjects = [];
                $evenSubjects = [];

                foreach ($left_values as $i => $reg) {
                    $oddValues['odd' . ($i + 1)] = $reg;
                    $oddSubjects['odd' . ($i + 1)] = isset($left_subjects[$i]) ? $left_subjects[$i] : '';
                }
                foreach ($right_values as $i => $reg) {
                    $evenValues['even' . ($i + 1)] = $reg;
                    $evenSubjects['even' . ($i + 1)] = isset($right_subjects[$i]) ? $right_subjects[$i] : '';
                }

                for ($r = 0; $r < 5; $r++) {
                    echo '<tr>';
                    for ($c = 0; $c < 5; $c++) {
                        $key = $cells[$r][$c];
                        if (strpos($key, 'odd') === 0) {
                            $reg = isset($oddValues[$key]) ? $oddValues[$key] : '';
                            $subj = isset($oddSubjects[$key]) ? $oddSubjects[$key] : '';
                        } else {
                            $reg = isset($evenValues[$key]) ? $evenValues[$key] : '';
                            $subj = isset($evenSubjects[$key]) ? $evenSubjects[$key] : '';
                        }
                        $label = chr(65 + $c) . ($r + 1);
                        echo "<th><div class='a1-box'>$label</div><span class='regno'>$reg</span><span class='subj'>$subj</span></th>";
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <button id="print-button" class="btn btn-primary btn-lg" onclick="openPrintPreview()">Print Seating Arrangement</button>

    <script>
        function openPrintPreview() {
            // Get table HTML
            var tableHtml = document.getElementById('seatingTable').outerHTML;

            // Get top info
            var hallNo = '<?php echo addslashes($hall_no_value); ?>';
            var examDate = '<?php echo addslashes($exam_date_value); ?>';
            var session = '<?php echo addslashes($session_value); ?>';

            // Open popup
            var printWindow = window.open('', '_blank', 'width=900,height=700,scrollbars=yes');
            if (!printWindow) {
                alert('Popup blocked! Please allow popups for this site.');
                return;
            }

            // Write full HTML (NO extra <script> inside)
            printWindow.document.open();
            printWindow.document.write(
                '<html>' +
                '<head>' +
                '  <title>Print Seating Arrangement</title>' +
                '  <style>' +
                '    @page { size: A4 landscape; margin: 10mm; }' +
                '    body { font-family: Arial, sans-serif; margin: 10px; }' +
                '    table { width: 100%; border-collapse: collapse; font-size: 12px; }' +
                '    th { border: 1px solid black; padding: 6px; height: 80px; position: relative; text-align: center; vertical-align: top; background:#e3f2fd; }' +
                '    .a1-box { position:absolute; top:4px; left:50%; transform:translateX(-50%); border:2px solid #000; background:#fff; border-radius:3px; width:20px; height:20px; font-weight:bold; font-size:10px; line-height:20px; }' +
                '    span.regno { display:block; font-weight:bold; font-size:16px; margin-top:24px; }' +
                '    span.subj { display:block; font-size:12px; margin-top:5px; }' +
                '    .header { text-align:center; margin-bottom:20px; }' +
                '    .header img { height:50px; vertical-align:middle; }' +
                '    .header h2 { display:inline-block; margin-left:10px; vertical-align:middle; color:#007bff; }' +
                '    .info-bar { font-size:14px; text-align:center; margin-bottom:15px; }' +
                '    .footer-note { margin-top:20px; font-size:13px; }' +
                '    .signature-section { display:flex; justify-content:space-between; margin-top:30px; font-size:13px; }' +
                '    footer { margin-top:20px; font-size:12px; text-align:center; border-top:1px solid #000; padding-top:5px; }' +
                '  </style>' +
                '</head>' +
                '<body>' +
                '  <div class="header">' +
                '    <img src="https://res.cloudinary.com/de1tywvqm/image/upload/v1764171191/au_logo_f8g8al.png" alt="AU Logo">' +
                '    <h2>Grace College - Exam Seating</h2>' +
                '  </div>' +
                '  <div class="info-bar">' +
                '    <strong>Hall No:</strong> ' + hallNo + ' | ' +
                '    <strong>Date:</strong> ' + examDate + ' | ' +
                '    <strong>Session:</strong> ' + session +
                '  </div>' +
                tableHtml +
                '  <div class="footer-note">' +
                '    <p>No. of Present: __________________</p>' +
                '    <p>No. of Absent: __________________</p>' +
                '    <p><strong>Note:</strong> Hall Superintendent must encircle the absent register numbers.</p>' +
                '  </div>' +
                '  <div class="signature-section">' +
                '    <div>Signature of Hall Superintendent</div>' +
                '    <div>Signature of Chief Superintendent</div>' +
                '  </div>' +
                '  <footer>© 2025 Grace College of Engineering - Exam Seating Arrangement</footer>' +
                '</body>' +
                '</html>'
            );
            printWindow.document.close();

            // Trigger print after a short delay so content loads
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                // printWindow.close(); // optional
            }, 500);
        }
    </script>

</body>

</html>
`);
printWindow.document.close();
}
</script>

</body>

</html>