<?php
include 'connection.php';
session_start();

// get filters
$filter_date    = isset($_GET['exam_date']) ? trim($_GET['exam_date']) : '';
$filter_session = isset($_GET['session']) ? trim($_GET['session']) : '';

// base query
$sql = "SELECT * FROM exam_seating WHERE 1=1";

if ($filter_date != '') {
    $date_esc = mysqli_real_escape_string($conn, $filter_date);
    $sql .= " AND exam_date = '" . $date_esc . "'";
}

if ($filter_session != '') {
    $sess_esc = mysqli_real_escape_string($conn, $filter_session);
    $sql .= " AND session = '" . $sess_esc . "'";
}

$sql .= " ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Seating Arrangements</title>
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/x-icon"> 
    <style>
        /* BASE STYLES */
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; color: #333; }
        .container { width: 95%; max-width: 1200px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h3 { text-align: center; color: #2c3e50; }

        /* FORM STYLES (Flexbox for Desktop) */
        .filter-form { display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; align-items: flex-end; margin-bottom: 30px; padding: 15px; background: #f9f9f9; border-radius: 5px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-size: 0.9rem; font-weight: bold; margin-bottom: 5px; }
        .form-control { padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; }
        
        /* BUTTONS */
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 0.9rem; transition: opacity 0.2s; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn-view { background-color: #2ecc71; color: white; padding: 5px 10px; border-radius: 3px; }
        .btn:hover { opacity: 0.8; }

        /* TABLE STYLES (Desktop Default) */
        .seating-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .seating-table th, .seating-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .seating-table thead { background-color: #2c3e50; color: white; }
        .seating-table tr:nth-child(even) { background-color: #f2f2f2; }

        /* --- RESPONSIVE DESIGN --- */

        /* Tablet View (max-width: 768px) */
        @media (max-width: 768px) {
            .filter-form { flex-direction: row; } /* Keep items side-by-side but allow wrapping */
            .form-group { flex: 1 1 40%; } /* Two inputs per row */
            .seating-table th, .seating-table td { padding: 8px; font-size: 0.85rem; }
        }

        /* Mobile View (max-width: 500px) */
        @media (max-width: 500px) {
            .container { width: 100%; padding: 10px; border-radius: 0; }
            .form-group { flex: 1 1 100%; } /* One input per row */
            
            /* Force table to not behave like a table */
            .seating-table, .seating-table thead, .seating-table tbody, .seating-table th, .seating-table td, .seating-table tr { 
                display: block; 
            }
            
            /* Hide table headers */
            .seating-table thead tr { position: absolute; top: -9999px; left: -9999px; }
            
            .seating-table tr { border: 1px solid #ccc; margin-bottom: 15px; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0,0,0,0.05); }
            
            .seating-table td { 
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
                text-align: right;
            }
            
            /* Add Label labels via CSS pseudo-elements */
            .seating-table td:before { 
                position: absolute;
                top: 12px;
                left: 12px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                content: attr(data-label);
            }
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h3>Saved Seating Arrangements</h3>

        <form method="get" class="filter-form">
            <div class="form-group">
                <label>Exam Date:</label>
                <input type="date" name="exam_date" class="form-control"
                    value="<?php echo htmlspecialchars($filter_date); ?>">
            </div>

            <div class="form-group">
                <label>Session:</label>
                <select name="session" class="form-control">
                    <option value="">All</option>
                    <option value="FN" <?php if ($filter_session == 'FN') echo 'selected'; ?>>FN</option>
                    <option value="AN" <?php if ($filter_session == 'AN') echo 'selected'; ?>>AN</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Search</button>
            <a href="view_seating_list.php" class="btn btn-secondary">Reset</a>
        </form>

        <table class="seating-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hall No</th>
                    <th>Exam Date</th>
                    <th>Session</th>
                    <th>Odd/Even</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $oddArr  = unserialize($row['odd_i']);
                        $evenArr = unserialize($row['even_i']);
                        $oddCount  = is_array($oddArr)  ? count($oddArr)  : 0;
                        $evenCount = is_array($evenArr) ? count($evenArr) : 0;

                        // data-label is used for the mobile card view
                        echo "<tr>
                            <td data-label='ID'>{$row['id']}</td>
                            <td data-label='Hall No'>{$row['hall_no']}</td>
                            <td data-label='Date'>{$row['exam_date']}</td>
                            <td data-label='Session'>{$row['session']}</td>
                            <td data-label='Counts'>O: $oddCount | E: $evenCount</td>
                            <td data-label='Total'>{$row['total_students']}</td>
                            <td data-label='Action'>
                                <a href='view_seating_single.php?id={$row['id']}' class='btn-view'>View Detail</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; color:red;'>No seating plans found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>