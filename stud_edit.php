<?php
include 'connection.php';

if (!isset($_GET['reg_no'])) {
    exit('Missing reg_no');
}

$reg_no = mysqli_real_escape_string($conn, $_GET['reg_no']);
$sql = "SELECT reg_no, name, department FROM students
        WHERE reg_no = '$reg_no' LIMIT 1";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) == 0) {
    exit('Student not found');
}
$student = mysqli_fetch_assoc($res);
?>
<form id="editForm" onsubmit="return submitEditForm();">
    <input type="hidden" name="original_reg"
        value="<?php echo htmlspecialchars($student['reg_no']); ?>">

    <div class="form-group">
        <label>Register Number</label>
        <input type="text" name="reg_no" class="form-control"
            value="<?php echo htmlspecialchars($student['reg_no']); ?>" required>
    </div>

    <div class="form-group">
        <label>Student Name</label>
        <input type="text" name="name" class="form-control"
            value="<?php echo htmlspecialchars($student['name']); ?>" required>
    </div>

    <div class="form-group">
        <label>Department</label>
        <input type="text" name="department" class="form-control"
            value="<?php echo htmlspecialchars($student['department']); ?>" required>
    </div>

    <div id="editMsg" class="text-danger mb-2"></div>

    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary"
        data-dismiss="modal">Cancel</button>
</form>

<script>
    function submitEditForm() {
        var form = $('#editForm');
        $.post('update_student.php', form.serialize(), function(resp) {
            if (resp === 'OK') {
                studentUpdated(); // defined in main page
            } else {
                $('#editMsg').text(resp);
            }
        });
        return false; // prevent normal submit
    }
</script>