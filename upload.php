<?php
// --- PHP LOGIC SECTION ---
$message = "";
$messageType = ""; // 'success' or 'error'

// Only attempt database logic if form is submitted
if (isset($_POST['upload_csv'])) {

    // Check if connection file exists to prevent crash
    if (file_exists('connection.php')) {
        include 'connection.php';
    } else {
        // Fallback for demonstration if connection.php is missing
        $conn = false;
        $message = "Error: 'connection.php' not found. Please ensure database connection is established.";
        $messageType = "error";
    }

    // Only proceed if we have a valid database connection and a file
    if ($conn && isset($_FILES['csv_file']['tmp_name']) && $_FILES['csv_file']['error'] == 0) {

        $file = $_FILES['csv_file']['tmp_name'];

        if (($handle = fopen($file, 'r')) !== FALSE) {
            // Get the header row
            $header = fgetcsv($handle);
            // Expected: reg_no,name,department

            $rowCount = 0;
            $errorCount = 0;
            $updatedCount = 0;
            $insertedCount = 0;

            while (($data = fgetcsv($handle)) !== FALSE) {
                // Ensure row has enough columns
                if (count($data) < 3) {
                    $errorCount++;
                    continue;
                }

                $rowCount++;
                $reg_no = mysqli_real_escape_string($conn, trim($data[0]));
                $name = mysqli_real_escape_string($conn, trim($data[1]));
                $department = mysqli_real_escape_string($conn, trim($data[2]));

                // Validation
                if ($reg_no === '' || $name === '' || $department === '') {
                    $errorCount++;
                    continue; // Skip incomplete rows
                }

                // Check if student exists
                $checkSql = "SELECT reg_no FROM students WHERE reg_no = '$reg_no'";
                $checkResult = $conn->query($checkSql);

                if ($checkResult && $checkResult->num_rows > 0) {
                    // Update existing student
                    $updateSql = "UPDATE students SET name='$name', department='$department' WHERE reg_no='$reg_no'";
                    if (!$conn->query($updateSql)) {
                        $errorCount++;
                    } else {
                        $updatedCount++;
                    }
                } else {
                    // Insert new student
                    $insertSql = "INSERT INTO students (reg_no, name, department) VALUES ('$reg_no', '$name', '$department')";
                    if (!$conn->query($insertSql)) {
                        $errorCount++;
                    } else {
                        $insertedCount++;
                    }
                }
            }
            fclose($handle);

            $message = "Process Complete!<br>
                        <strong>Total Rows:</strong> $rowCount<br>
                        <strong>Inserted:</strong> $insertedCount<br>
                        <strong>Updated:</strong> $updatedCount<br>
                        <strong>Skipped/Errors:</strong> $errorCount";
            $messageType = "success";
        } else {
            $message = "Failed to open CSV file.";
            $messageType = "error";
        }
    } elseif (isset($conn) && $conn) {
        $message = "Please select a valid CSV file.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Upload</title>
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/png">
    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --accent-color: #06b6d4;
            --bg-gradient: linear-gradient(135deg, #e0f2fe, #f5f3ff);
            --card-bg: #ffffff;
            --text-color: #111827;
            --muted-text: #6b7280;
            --border-radius: 14px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg-gradient);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px;
        }

        /* --- CONTAINER (Card) --- */
        .upload-shell {
            width: 100%;
            max-width: 960px;
        }

        .upload-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .upload-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 18px;
        }

        .upload-subtitle {
            font-size: 0.85rem;
            color: var(--muted-text);
        }

        .upload-container {
            background-color: var(--card-bg);
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.20);
            width: 100%;
            display: grid;
            grid-template-columns: minmax(0, 3fr) minmax(0, 2fr);
            gap: 1.5rem;
        }

        h2 {
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        .page-desc {
            font-size: 0.9rem;
            color: var(--muted-text);
            margin-bottom: 1.1rem;
        }

        /* --- FORM SIDE --- */
        .form-section {
            border-right: 1px solid #e5e7eb;
            padding-right: 1.25rem;
        }

        .instructions {
            background-color: #eff6ff;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1.1rem;
            border-left: 3px solid var(--primary-color);
            color: #1e3a8a;
        }

        .instructions strong {
            display: block;
            margin-bottom: 3px;
        }

        .form-group {
            margin-bottom: 1.1rem;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* File input wrapper */
        .file-drop {
            position: relative;
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 14px 14px 12px;
            background: #f9fafb;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
            text-align: center;
        }

        .file-drop:hover {
            border-color: var(--primary-color);
            background: #f3f4ff;
            box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.1);
        }

        .file-drop-icon {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 4px;
        }

        .file-drop-title {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .file-drop-sub {
            font-size: 0.8rem;
            color: var(--muted-text);
        }

        input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        input[type="submit"] {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            border-radius: 999px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: transform 0.1s ease, box-shadow 0.1s ease, filter 0.1s ease;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        input[type="submit"]:hover {
            filter: brightness(1.05);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
            transform: translateY(-1px);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: #f3f4f6;
            color: #111827;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.82rem;
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-back span {
            font-size: 1rem;
        }

        .btn-back:hover {
            background: #e5e7eb;
            color: #111827;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* --- ALERTS --- */
        .alert {
            padding: 10px 12px;
            margin-bottom: 14px;
            border-radius: 9px;
            line-height: 1.4;
            font-size: 0.86rem;
        }

        .alert.success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert.error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* --- SIDE INFO / TEMPLATE PANEL --- */
        .side-panel {
            padding-left: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .panel-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 0.9rem 0.95rem;
            border: 1px solid #e5e7eb;
        }

        .panel-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .panel-text {
            font-size: 0.8rem;
            color: var(--muted-text);
            margin-bottom: 8px;
        }

        .sample-format-list {
            list-style: none;
            font-size: 0.8rem;
            color: var(--muted-text);
            margin-bottom: 4px;
        }

        .sample-format-list li {
            margin-bottom: 2px;
        }

        .badge-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
            background: #e0f2fe;
            color: #1d4ed8;
            margin-top: 2px;
        }

        .btn-sample {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            background: #111827;
            color: #f9fafb;
            border-radius: 999px;
            font-size: 0.8rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.1s ease, box-shadow 0.1s ease;
        }

        .btn-sample:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.4);
        }

        .btn-sample span {
            font-size: 0.9rem;
        }

        .tiny-note {
            font-size: 0.74rem;
            color: var(--muted-text);
            margin-top: 4px;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 780px) {
            body {
                padding: 16px;
            }

            .upload-container {
                grid-template-columns: 1fr;
                padding: 1.4rem 1.2rem 1.1rem;
                box-shadow: 0 14px 30px rgba(15, 23, 42, 0.25);
            }

            .form-section {
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding-right: 0;
                padding-bottom: 1rem;
                margin-bottom: 0.6rem;
            }

            .side-panel {
                padding-left: 0;
            }

            h2 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>

    <div class="upload-shell">
        <div class="upload-header">
            <div class="upload-header-left">
                <div class="logo-circle">S</div>
                <div>
                    <div style="font-weight:600;font-size:0.95rem;">Student Data Import</div>
                    <div class="upload-subtitle">Upload or update student master records from CSV</div>
                </div>
            </div>
            <button type="button" class="btn-back" onclick="window.location.href='javascript:history.back();'">
                <span>←</span> Back
            </button>
        </div>

        <div class="upload-container">
            <!-- LEFT: FORM -->
            <div class="form-section">
                <h2>Upload CSV</h2>
                <p class="page-desc">Upload a CSV file to insert or update student details in the database.</p>

                <!-- Status Message Display -->
                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="instructions">
                    <strong>Expected CSV Header:</strong>
                    reg_no, name, department<br>
                    Values must not be empty for any row.
                </div>

                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="csv_file">CSV file</label>
                        <div class="file-drop">
                            <div class="file-drop-icon">📁</div>
                            <div class="file-drop-title">Click to choose file</div>
                            <div class="file-drop-sub">Only .csv files are supported</div>
                            <input type="file" id="csv_file" name="csv_file" accept=".csv" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="upload_csv" value="Upload & Process" />
                    </div>
                </form>
            </div>

            <!-- RIGHT: SIDE PANEL / TEMPLATE -->
            <div class="side-panel">
                <div class="panel-card">
                    <div class="panel-title">Download sample template</div>
                    <p class="panel-text">
                        Use this ready-made CSV template to ensure column order and format are correct.
                    </p>
                    <ul class="sample-format-list">
                        <li>Column 1: reg_no</li>
                        <li>Column 2: name</li>
                        <li>Column 3: department</li>
                    </ul>
                    <span class="badge-pill">UTF-8 CSV recommended</span>
                    <br><br>
                    <!-- Static file download; ensure sample_students.csv exists in same directory -->
                    <a href="sample_students.csv" download="sample_students.csv" class="btn-sample">
                        <span>⬇</span> Download Sample CSV
                    </a>
                    <div class="tiny-note">
                        Open the file, replace sample rows with your data, and upload it back here.
                    </div>
                </div>

                <div class="panel-card">
                    <div class="panel-title">Tips</div>
                    <p class="panel-text">
                        Make sure registration numbers are unique per student to avoid conflicts.
                        Avoid commas inside values or wrap such values in quotes in your CSV.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>