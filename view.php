<?php
// DB Connection
include 'connection.php';

// Helper Function: Group Consecutive Numbers
function groupConsecutive($numbers) {
    if (empty($numbers)) return array();
    
    // Ensure numbers are sorted integers
    $clean_numbers = array_map('intval', $numbers);
    sort($clean_numbers, SORT_NUMERIC);
    
    $grouped = array();
    $start = $end = null;

    foreach ($clean_numbers as $num) {
        if ($start === null) {
            $start = $end = $num;
        } elseif ($num == $end + 1) {
            $end = $num;
        } else {
            $grouped[] = ($start == $end) ? $start : "$start-$end";
            $start = $end = $num;
        }
    }
    if ($start !== null) {
        $grouped[] = ($start == $end) ? $start : "$start-$end";
    }
    return $grouped;
}

// 1. Handle Filters
$filter_date = isset($_GET['exam_date']) ? $_GET['exam_date'] : '';
$filter_session = isset($_GET['session']) ? $_GET['session'] : '';

// 2. Build Query
$sql = "SELECT * FROM exam_seating WHERE 1=1";
if ($filter_date != '') {
    $sql .= " AND exam_date = '" . mysqli_real_escape_string($conn, $filter_date) . "'";
}
if ($filter_session != '') {
    $sql .= " AND session = '" . mysqli_real_escape_string($conn, $filter_session) . "'";
}
$sql .= " ORDER BY exam_date DESC, hall_no ASC";

$result = $conn->query($sql);

// 3. Process Data into Array
// We process data first so we can loop through it twice (Desktop view & Mobile view)
$seatingData = array();
$grandTotal = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $oddRegs = @unserialize($row['odd_i']) ? unserialize($row['odd_i']) : array();
        $evenRegs = @unserialize($row['even_i']) ? unserialize($row['even_i']) : array();
        $oddSubjects = @unserialize($row['odd_subjects']) ? unserialize($row['odd_subjects']) : array();
        $evenSubjects = @unserialize($row['even_subjects']) ? unserialize($row['even_subjects']) : array();

        $allRegs = array_merge($oddRegs, $evenRegs);
        $allSubjects = array_merge($oddSubjects, $evenSubjects);

        // Group by subject
        $subjectGroups = array();
        foreach ($allRegs as $i => $reg) {
            $subj = isset($allSubjects[$i]) ? $allSubjects[$i] : 'Unknown';
            if (!isset($subjectGroups[$subj])) $subjectGroups[$subj] = array();
            $subjectGroups[$subj][] = $reg;
        }

        $totalInHall = count($allRegs);
        $grandTotal += $totalInHall;

        // Format subjects for display
        $formattedSubjects = array();
        foreach ($subjectGroups as $subj => $regs) {
            $regs_grouped = groupConsecutive($regs);
            $formattedSubjects[] = array(
                'code' => $subj,
                'range' => implode(", ", $regs_grouped),
                'count' => count($regs)
            );
        }

        $seatingData[] = array(
            'hall' => $row['hall_no'],
            'date' => $row['exam_date'],
            'session' => $row['session'],
            'total' => $totalInHall,
            'subjects' => $formattedSubjects
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Seating Arrangement</title>
    <link rel="icon" href="https://res.cloudinary.com/de1tywvqm/image/upload/v1758813951/logo_eq52wb.png" type="image/png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Print Styles */
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background-color: white; }
            .card, .table-container { box-shadow: none; border: 1px solid #ccc; }
            /* Force table view on print even if mobile */
            #mobile-view { display: none !important; }
            #desktop-view { display: table !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Header -->
    <div class="bg-blue-900 text-white p-4 shadow-md">
        <div class="container mx-auto">
            <h2 class="text-xl md:text-2xl font-bold text-center">
                🎓 Anna University Examination - Seating
            </h2>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6">

        <!-- Controls / Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6 no-print">
            <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Exam Date</label>
                    <input type="date" name="exam_date" value="<?php echo htmlspecialchars($filter_date); ?>" 
                           class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                    <select name="session" class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">All Sessions</option>
                        <option value="FN" <?php if ($filter_session == 'FN') echo 'selected'; ?>>Forenoon (FN)</option>
                        <option value="AN" <?php if ($filter_session == 'AN') echo 'selected'; ?>>Afternoon (AN)</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        Filter
                    </button>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="window.print()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition flex justify-center items-center gap-2">
                        <!-- Printer Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/></svg>
                        Print
                    </button>
                    <a href="seat.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition text-center flex items-center justify-center">
                        Back
                    </a>
                </div>
            </form>
        </div>

        <?php if (empty($seatingData)): ?>
            <div class="p-8 text-center bg-white rounded shadow text-gray-500">
                No seating arrangements found for the selected criteria.
            </div>
        <?php else: ?>

            <!-- DESKTOP VIEW: Traditional Table -->
            <div id="desktop-view" class="hidden md:block overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="bg-gray-100 text-gray-800 uppercase text-sm font-bold">
                        <tr>
                            <th class="px-4 py-3 border text-left">Hall No</th>
                            <th class="px-4 py-3 border text-left">Date</th>
                            <th class="px-4 py-3 border text-left">Session</th>
                            <th class="px-4 py-3 border text-left">Subject</th>
                            <th class="px-4 py-3 border text-left w-1/3">Register Numbers</th>
                            <th class="px-4 py-3 border text-center">Count</th>
                            <th class="px-4 py-3 border text-center">Hall Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        <?php foreach ($seatingData as $hallData): ?>
                            <?php 
                                $rowSpan = count($hallData['subjects']);
                                foreach ($hallData['subjects'] as $index => $subject): 
                                    $isLast = ($index === $rowSpan - 1);
                                    $borderClass = $isLast ? "border-b-2 border-gray-200" : "";
                            ?>
                            <tr class="bg-white hover:bg-gray-50 <?php echo $borderClass; ?>">
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?php echo $rowSpan; ?>" class="px-4 py-3 border-r align-top font-bold text-blue-900 bg-gray-50">
                                        <?php echo htmlspecialchars($hallData['hall']); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowSpan; ?>" class="px-4 py-3 border-r align-top">
                                        <?php echo htmlspecialchars($hallData['date']); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowSpan; ?>" class="px-4 py-3 border-r align-top text-center">
                                        <?php echo htmlspecialchars($hallData['session']); ?>
                                    </td>
                                <?php endif; ?>

                                <td class="px-4 py-2 border-r text-gray-800 font-medium">
                                    <?php echo htmlspecialchars($subject['code']); ?>
                                </td>
                                <td class="px-4 py-2 border-r text-gray-600 break-words">
                                    <?php echo htmlspecialchars($subject['range']); ?>
                                </td>
                                <td class="px-4 py-2 border-r text-center font-bold">
                                    <?php echo $subject['count']; ?>
                                </td>

                                <?php if ($index === 0): ?>
                                    <td rowspan="<?php echo $rowSpan; ?>" class="px-4 py-3 align-middle text-center font-bold text-lg bg-gray-50">
                                        <?php echo $hallData['total']; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE VIEW: Stacked Cards -->
            <div id="mobile-view" class="md:hidden space-y-4">
                <?php foreach ($seatingData as $hallData): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                        <div class="bg-blue-50 p-3 border-b border-blue-100 flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg text-blue-900"><?php echo htmlspecialchars($hallData['hall']); ?></h3>
                                <p class="text-xs text-gray-500">
                                    <?php echo htmlspecialchars($hallData['date']); ?> (<?php echo htmlspecialchars($hallData['session']); ?>)
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs text-gray-500">Total</span>
                                <span class="font-bold text-xl text-blue-800"><?php echo $hallData['total']; ?></span>
                            </div>
                        </div>
                        <div class="p-3">
                            <?php foreach ($hallData['subjects'] as $subject): ?>
                                <div class="mb-3 last:mb-0 border-b last:border-0 pb-2 last:pb-0 border-gray-100">
                                    <div class="flex justify-between mb-1">
                                        <span class="font-bold text-gray-800"><?php echo htmlspecialchars($subject['code']); ?></span>
                                        <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full font-bold text-gray-700">
                                            <?php echo $subject['count']; ?> Students
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 font-mono leading-tight">
                                        <?php echo htmlspecialchars($subject['range']); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Summary Footer -->
            <div class="mt-4 p-4 bg-white border-t-4 border-blue-900 rounded shadow text-right">
                <span class="text-lg font-bold text-gray-700">Grand Total Students: </span>
                <span class="text-2xl font-bold text-blue-900"><?php echo $grandTotal; ?></span>
            </div>

        <?php endif; ?>

    </div>
</body>
</html>
<?php include 'footer.php'; ?>