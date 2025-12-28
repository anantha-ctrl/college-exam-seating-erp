<?php
include 'connection.php';
session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id == 0) {
    die("<div class='alert alert-danger'>Invalid Seating ID</div>");
}

// Fetch record
$sql = "SELECT * FROM exam_seating WHERE id=$id";
$res = mysqli_query($conn, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
    die("<div class='alert alert-danger'>Record not found</div>");
}

$row = mysqli_fetch_assoc($res);

// Extract values
$odd = unserialize($row['odd_i']);
$even = unserialize($row['even_i']);
$oddSubj = unserialize($row['odd_subjects']);
$evenSubj = unserialize($row['even_subjects']);

$hall_no   = $row['hall_no'];
$exam_date = $row['exam_date'];
$session   = $row['session'];

// Prepare data arrays
$oddValues = $evenValues = $oddNames = $evenNames = $oddDeptVal = $evenDeptVal = $oddSub = $evenSub = [];

foreach ($odd as $i => $reg) {
    $key = "odd" . ($i + 1);
    $oddValues[$key] = $reg;
    $oddSub[$key] = $oddSubj[$i] ?? '';
    if ($reg != "") {
        $q = mysqli_query($conn, "SELECT name, department FROM students WHERE reg_no='$reg'");
        $st = mysqli_fetch_assoc($q);
        $oddNames[$key] = $st['name'] ?? '';
        $oddDeptVal[$key] = $st['department'] ?? '';
    }
}

foreach ($even as $i => $reg) {
    $key = "even" . ($i + 1);
    $evenValues[$key] = $reg;
    $evenSub[$key] = $evenSubj[$i] ?? '';
    if ($reg != "") {
        $q = mysqli_query($conn, "SELECT name, department FROM students WHERE reg_no='$reg'");
        $st = mysqli_fetch_assoc($q);
        $evenNames[$key] = $st['name'] ?? '';
        $evenDeptVal[$key] = $st['department'] ?? '';
    }
}

// Seat layout
$cells = [
    ['odd1', 'even5', 'odd6', 'even10', 'odd11'],
    ['even1', 'odd5', 'even6', 'odd10', 'even11'],
    ['odd2', 'even4', 'odd7', 'even9', 'odd12'],
    ['even3', 'odd4', 'even7', 'odd9', 'even12'],
    ['odd3', 'even2', 'odd8', 'even8', 'odd13']
];
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Seating</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/x-icon"> 
    <style>
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
            color: #de02fbff;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 700px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 14px;
            text-align: center;
            position: relative;
        }

        .a1-box {
            position: absolute;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
            padding: 1px 4px;
            font-size: 10px;
            border: 1px solid #000;
            background: #fff;
            border-radius: 3px;
        }

        .regno {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-top: 8px;
        }

        .name {
            font-size: 12px;
            font-weight: bold;
            display: block;
        }

        .dept,
        .subj {
            font-size: 10px;
            display: block;
        }

        @media print {
            button {
                display: none;
            }

            @page {
                size: landscape;
                margin: 10mm;
            }

            table {
                page-break-inside: avoid;
                width: 100%;
            }

            th,
            td {
                page-break-inside: avoid;
                padding: 14px;
            }

            .subject-count {
                font-size: 10px;
                margin-top: 5px;
            }

            .present-absent {
                font-size: 8px;

            }

            .signature-section {
                font-size: 8px;
                display: flex;
                justify-content: space-between;
            }

            .a1-box {
                position: absolute;
                top: 0px;
                left: 50%;
                transform: translateX(-50%);
                width: 20px;
                /* same width and height  */
                height: 20px;
                padding: 0;
                /* let width/height control size */
                font-size: 9px !important;
                font-weight: bold;
                border: 2px solid #000;
                border-radius: 2px;
                /* or 0 for sharp corners */
                background: #fff;
                display: flex;
                /* center text inside box */
                align-items: center;
                justify-content: center;

            }
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>

    <div class="header">
        <img src="https://res.cloudinary.com/de1tywvqm/image/upload/v1764171191/au_logo_f8g8al.png" alt="AU Logo" />
        <h1>Grace College - Exam Seating</h1>
    </div>

    <div class="container mt-3">
        <h3 class="text-center mb-2">Seating Arrangement - View</h3>

        <div class="alert alert-info">
            <strong>Hall No:</strong> <?= $hall_no ?> &nbsp;&nbsp;
            <strong>Date:</strong> <?= $exam_date ?> &nbsp;&nbsp;
            <strong>Session:</strong> <?= $session ?>
        </div>

        <div class="table-responsive">
            <table id="tableBody">
                <tbody>
                    <?php
                    for ($r = 0; $r < 5; $r++) {
                        echo "<tr>";
                        for ($c = 0; $c < 5; $c++) {
                            $key = $cells[$r][$c];
                            $reg = $oddValues[$key] ?? ($evenValues[$key] ?? '');
                            $name = $oddNames[$key] ?? ($evenNames[$key] ?? '');
                            $dept = $oddDeptVal[$key] ?? ($evenDeptVal[$key] ?? '');
                            $subj = $oddSub[$key] ?? ($evenSub[$key] ?? '');
                            $label = chr(65 + $c) . ($r + 1);
                            echo "<th>
                        <div class='a1-box'>$label</div>
                        <span class='regno'>$reg</span>
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

        <div class="text-center mt-3 mb-3">
            <button onclick="printSeating()" class="btn btn-primary btn-lg">Print This Seating</button>
            <button onclick="window.location.href='view_plan.php'" class="btn btn-secondary btn-lg">Back to Plan</button>
        </div>
    </div>

    <script>
        function printSeating() {
            var table = document.querySelector('table').cloneNode(true);

            // Subject counts
            var subjectCounts = {};
            table.querySelectorAll('.subj').forEach(function(el) {
                var txt = el.textContent.trim();
                if (!txt) return;
                subjectCounts[txt] = (subjectCounts[txt] || 0) + 1;
            });

            var names = Object.keys(subjectCounts);
            var half = Math.ceil(names.length / 2);
            var leftNames = names.slice(0, half);
            var rightNames = names.slice(half);

            var leftHtml = '',
                rightHtml = '';
            leftNames.forEach(name => leftHtml += name + ' : ' + subjectCounts[name] + '<br>');
            rightNames.forEach(name => rightHtml += name + ' : ' + subjectCounts[name] + '<br>');

            var newWindow = window.open('', '', 'width=1200,height=800');
            newWindow.document.write('<html><head><title>Print Seating</title>');
            newWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');

            // CSS for print
            newWindow.document.write(`
        <style>
            @media print {
                @page { size: landscape; margin:10mm; }
                body { font-size:12px; }
                table { width:100%; border-collapse:collapse; page-break-inside:avoid; }
                
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
                .regno { font-size:14px; font-weight:bold; display:block; margin-top:16px; }
                .name { font-size:12px; font-weight:bold; display:block; }
                .dept, .subj { font-size:10px; display:block; }
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
                .present-absent { font-size:10px; margin-top:5px; }
                .signature-section { font-size:11px; margin-top:10px; display:flex; justify-content:space-between; }
                .proforma-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
                .ph-left, .ph-right { width:80px; text-align:center; }
                .ph-center { flex:1; text-align:center; font-size:14px; font-weight:bold; line-height:1.2; }
                .ph-logo { max-width:70px; max-height:70px; }
            }
        </style>
    `);

            newWindow.document.write('</head><body>');

            // HEADER
            newWindow.document.write(`
        <div class="proforma-header">
            <div class="ph-left">
                <img src="au.png" alt="Logo" class="ph-logo">
            </div>
            <div class="ph-center">
                <div><strong>PROFORMA-I</strong></div>
                <div><strong>  CENTRE:9503 - GRACE COLLEGE OF ENGINEERING</strong></div>
                     <div style="margin-top:4px; font-size:14px; font-weight:normal;">
                    <strong>Hall No:</strong> <?= $hall_no ?> &nbsp; | &nbsp;
                    <strong>Date:</strong> <?= $exam_date ?> &nbsp; | &nbsp;
                    <strong>Session:</strong> <?= $session ?>
                </div>
            </div>
            <div class="ph-right">
                <img src="grace.png" alt="Logo" class="ph-logo">
            </div>
        </div>
    `);

            // TABLE
            newWindow.document.body.appendChild(table);

            // Subject-wise count
            newWindow.document.write(`
        <div class="subject-count">
            <strong>Subject-wise Count:</strong>
            <div style="display:flex; justify-content:space-between;">
                <div style="width:50%; text-align:left;">${leftHtml}</div>
                <div style="width:50%; text-align:right;">${rightHtml}</div>
            </div>
        </div>
    `);

            // Present/Absent
            // Present/Absent
            newWindow.document.write(`
    <div class="present-absent" style="line-height:1.1; margin-top:5px; font-size:12px;">
        <p style="margin:2px 0;">No. of Present: __________________</p>
        <p style="margin:2px 0;">No. of Absent: ___________________</p>
        <p style="margin:2px 0;"><strong>Note:</strong> Hall Superintendent has to encircle the absent Register Number(s)</p>
    </div>
`);


            // Signatures
            newWindow.document.write(`
    <div class="signature-section" style="line-height:1.1; margin-top:38px; display:flex; justify-content:space-between; font-size:12px;">
        <p style="margin:0;">Signature of Hall Superintendent</p>
        <p style="margin:0;">Signature of Chief Superintendent</p>
    </div>
`);


            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
        }
    </script>

</body>

</html>

<?php include 'footer.php'; ?>