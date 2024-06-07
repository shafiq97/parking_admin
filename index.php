<?php
require_once 'conn.php';
$sql_parking = "SELECT id, plate_number, extracted_characters, check_in_time, check_out_time, other_fields FROM parking_records";
$result_parking = $conn->query($sql_parking);

$sql_payment = "SELECT id, email, vehical_number, slot_id, slot_name, parking_time_in_minutes, amount, floor FROM payments"; // replace 'payments' with your actual payment table name
$result_payment = $conn->query($sql_payment);

$sql_users = "SELECT id, user_id, email, student_id, license_number, license_plate FROM users"; // replace 'users' with your actual users table name
$result_users = $conn->query($sql_users);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="my-4">Admin Page</h2>

    <!-- Parking Records Table -->
    <h3>Parking Records</h3>
    <table id="parkingTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Plate Number</th>
                <th>Extracted Characters</th>
                <th>Check-in Time</th>
                <th>Check-out Time</th>
                <th>Other Fields</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_parking->num_rows > 0) {
                while($row = $result_parking->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["plate_number"]. "</td>
                            <td>" . $row["extracted_characters"]. "</td>
                            <td>" . $row["check_in_time"]. "</td>
                            <td>" . $row["check_out_time"]. "</td>
                            <td>" . $row["other_fields"]. "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Payment Records Table -->
    <h3>Payment Records</h3>
    <table id="paymentTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Vehical Number</th>
                <th>Slot Id</th>
                <th>Slot Name</th>
                <th>Parking Time (Minutes)</th>
                <th>Amount</th>
                <th>Floor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_payment->num_rows > 0) {
                while($row = $result_payment->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["email"]. "</td>
                            <td>" . $row["vehical_number"]. "</td>
                            <td>" . $row["slot_id"]. "</td>
                            <td>" . $row["slot_name"]. "</td>
                            <td>" . $row["parking_time_in_minutes"]. "</td>
                            <td>" . $row["amount"]. "</td>
                            <td>" . $row["floor"]. "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>0 results</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- User Records Table -->
    <h3>User Records</h3>
    <table id="userTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>User ID</th>
                <th>Email</th>
                <th>Student ID</th>
                <th>License Number</th>
                <th>License Plate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_users->num_rows > 0) {
                while($row = $result_users->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["user_id"]. "</td>
                            <td>" . $row["email"]. "</td>
                            <td>" . $row["student_id"]. "</td>
                            <td>" . $row["license_number"]. "</td>
                            <td>" . $row["license_plate"]. "</td>
                            <td>
                                <button class='btn btn-primary editBtn' data-id='" . $row["id"]. "'>Edit</button>
                                <button class='btn btn-danger deleteBtn' data-id='" . $row["id"]. "'>Delete</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>0 results</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm">
        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">
          <div class="form-group">
            <label for="user_id">User ID</label>
            <input readonly type="text" class="form-control" id="edit_user_id" name="user_id" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="edit_email" name="email" required>
          </div>
          <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="edit_student_id" name="student_id" required>
          </div>
          <div class="form-group">
            <label for="license_number">License Number</label>
            <input type="text" class="form-control" id="edit_license_number" name="license_number" required>
          </div>
          <div class="form-group">
            <label for="license_plate">License Plate</label>
            <input type="text" class="form-control" id="edit_license_plate" name="license_plate" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#parkingTable').DataTable();
    $('#paymentTable').DataTable();
    $('#userTable').DataTable();

    // Edit button click
    $('.editBtn').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'fetch_user.php', // replace with your fetch user script
            type: 'post',
            data: {id: id},
            success: function(response) {
                var user = JSON.parse(response);
                $('#edit_id').val(user.id);
                $('#edit_user_id').val(user.user_id);
                $('#edit_email').val(user.email);
                $('#edit_student_id').val(user.student_id);
                $('#edit_license_number').val(user.license_number);
                $('#edit_license_plate').val(user.license_plate);
                $('#editModal').modal('show');
            }
        });
    });

    // Delete button click
    $('.deleteBtn').on('click', function() {
        if (confirm('Are you sure you want to delete this record?')) {
            var id = $(this).data('id');
            $.ajax({
                url: 'delete_user.php', // replace with your delete user script
                type: 'post',
                data: {id: id},
                success: function(response) {
                    location.reload();
                }
            });
        }
    });

    // Edit form submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'update_user.php', // replace with your update user script
            type: 'post',
            data: $(this).serialize(),
            success: function(response) {
                $('#editModal').modal('hide');
                location.reload();
            }
        });
    });
});
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
