<?php
include 'connection.php';

// ---------- BULK DELETE ----------
if (isset($_POST['delete_multiple']) && !empty($_POST['reg_no'])) {
    $regnos = array_map('trim', $_POST['reg_no']);
    $safe = array();
    foreach ($regnos as $r) {
        $safe[] = "'" . mysqli_real_escape_string($conn, $r) . "'";
    }
    $reg_list = implode(',', $safe);
    $sql_del = "DELETE FROM students WHERE reg_no IN ($reg_list)";
    mysqli_query($conn, $sql_del);
}

// ---------- FILTER INPUTS ----------
$selected_dept = isset($_GET['dept']) ? $_GET['dept'] : '';
$selected_year = isset($_GET['year']) ? $_GET['year'] : '';
$search_text   = isset($_GET['q']) ? trim($_GET['q']) : '';

// ---------- DISTINCT DEPARTMENTS ----------
$dept_sql = "SELECT DISTINCT department FROM students ORDER BY department";
$dept_res = mysqli_query($conn, $dept_sql);

// ---------- DISTINCT YEARS FROM reg_no (pos 5-6) ----------
$year_sql = "SELECT DISTINCT SUBSTRING(reg_no,5,2) AS yr FROM students ORDER BY yr";
$year_res = mysqli_query($conn, $year_sql);

// ---------- LOAD STUDENTS WITH ALL FILTERS ----------
$student_sql = "SELECT reg_no, name, department FROM students WHERE 1=1";
if ($selected_dept != '') {
    $student_sql .= " AND department = '" . mysqli_real_escape_string($conn, $selected_dept) . "'";
}
if ($selected_year != '') {
    $student_sql .= " AND SUBSTRING(reg_no,5,2) = '" . mysqli_real_escape_string($conn, $selected_year) . "'";
}
if ($search_text != '') {
    $search_esc = mysqli_real_escape_string($conn, $search_text);
    $student_sql .= " AND (reg_no LIKE '%$search_esc%' OR name LIKE '%$search_esc%')";
}
$student_sql .= " ORDER BY department, reg_no";
$student_res = mysqli_query($conn, $student_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/x-icon"> 
    <style>
        :root {
            --primary: #2563eb;
            --danger: #dc2626;
            --gray: #f3f4f6;
            --text: #1f2937;
            --border: #d1d5db;
        }

        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; color: var(--text); line-height: 1.5; margin: 0; padding: 20px; }
        h4 { margin-top: 0; }

        /* Form Styling */
        .filter-form { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; background: var(--gray); padding: 15px; border-radius: 8px; }
        .form-group { display: flex; flex-direction: column; flex: 1; min-width: 150px; }
        input, select { padding: 8px; border: 1px solid var(--border); border-radius: 4px; font-size: 14px; }
        
        /* Buttons */
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-danger { background: var(--danger); color: white; margin-bottom: 10px; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-info { background: #0891b2; color: white; }

        /* Responsive Table */
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid var(--border); }
        th { background: #f9fafb; font-weight: 600; }

        /* MODAL STYLES (Pure CSS/JS) */
        .custom-modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 10% auto; padding: 20px; width: 90%; max-width: 500px; border-radius: 8px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 10px; }
        .close-modal { font-size: 24px; cursor: pointer; }

        /* --- MOBILE RESPONSIVENESS --- */
        @media (max-width: 768px) {
            /* Hide table headers */
            thead { display: none; }
            
            /* Make each row a card */
            tr { display: block; border: 1px solid var(--border); margin-bottom: 15px; border-radius: 8px; padding: 10px; background: #fff; }
            td { display: flex; justify-content: space-between; align-items: center; border: none; padding: 5px 0; }
            
            /* Add labels before data */
            td::before { content: attr(data-label); font-weight: bold; color: #6b7280; font-size: 12px; text-transform: uppercase; }
            
            .form-group { flex: 1 1 100%; } /* Stack inputs on small mobile */
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>

    <h4>Student Management</h4>

    <form method="get" class="filter-form">
        <div class="form-group">
            <input type="text" name="q" placeholder="Search reg no / name" value="<?php echo htmlspecialchars($search_text); ?>">
        </div>
        <div class="form-group">
            <select name="dept">
                <option value="">All Departments</option>
                <?php while ($d = mysqli_fetch_assoc($dept_res)): ?>
                    <option value="<?php echo htmlspecialchars($d['department']); ?>" <?php if ($selected_dept == $d['department']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($d['department']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <select name="year">
                <option value="">All Years</option>
                <?php while ($y = mysqli_fetch_assoc($year_res)): ?>
                    <option value="<?php echo htmlspecialchars($y['yr']); ?>" <?php if ($selected_year == $y['yr']) echo 'selected'; ?>>
                        <?php echo '20' . htmlspecialchars($y['yr']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="stud_del.php" class="btn btn-secondary">Reset</a>
    </form>

    <form method="post" onsubmit="return confirm('Delete selected students?');">
        <button type="submit" name="delete_multiple" class="btn btn-danger">Delete Selected</button>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="checkAll"></th>
                        <th>Sl.No</th>
                        <th>Reg No</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl = 1;
                    if ($student_res && mysqli_num_rows($student_res) > 0):
                        while ($row = mysqli_fetch_assoc($student_res)):
                    ?>
                            <tr>
                                <td data-label="Select">
                                    <input type="checkbox" name="reg_no[]" value="<?php echo htmlspecialchars($row['reg_no']); ?>">
                                </td>
                                <td data-label="Sl.No"><?php echo $sl++; ?></td>
                                <td data-label="Reg No"><?php echo htmlspecialchars($row['reg_no']); ?></td>
                                <td data-label="Name"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td data-label="Dept"><?php echo htmlspecialchars($row['department']); ?></td>
                                <td data-label="Action">
                                    <button type="button" class="btn btn-info" onclick="openEditModal('<?php echo htmlspecialchars($row['reg_no']); ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="6" style="text-align:center;">No students found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>

    <div id="editModal" class="custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Student</h5>
                <span class="close-modal" onclick="closeModal()">&times;</span>
            </div>
            <div id="editModalBody" style="padding-top:15px;">
                Loading...
            </div>
        </div>
    </div>

    <script>
        // Check/Uncheck All
        document.getElementById('checkAll').onclick = function() {
            var cbs = document.querySelectorAll('input[name="reg_no[]"]');
            cbs.forEach(cb => cb.checked = this.checked);
        };

        // Modal Logic
        function openEditModal(regno) {
            const modal = document.getElementById('editModal');
            const body = document.getElementById('editModalBody');
            modal.style.display = "block";
            body.innerHTML = 'Loading...';

            // Using standard Fetch API instead of jQuery $.get
            fetch('stud_edit.php?reg_no=' + regno)
                .then(response => response.text())
                .then(data => {
                    body.innerHTML = data;
                });
        }

        function closeModal() {
            document.getElementById('editModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeModal();
            }
        }

        function studentUpdated() {
            closeModal();
            location.reload();
        }
    </script>
</body>
</html>

<?php include 'footer.php'; ?>