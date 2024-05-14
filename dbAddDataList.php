<?php
include "dbConnect.php";

$sql = "SELECT e.emp_id, e.empl_firstname, e.empl_lastname, e.email, e.position, d.department_name 
        FROM employees e
        INNER JOIN departments d ON e.department_id = d.department_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['emp_id'] . "</td>";
        echo "<td>" . $row['empl_firstname'] . "</td>";
        echo "<td>" . $row['empl_lastname'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['position'] . "</td>";
        echo "<td>" . $row['department_name'] . "</td>";
        echo "<td> <button type='button' class='editbtn btn btn-outline-secondary'><i class='bx bxs-edit'></i></button>
         <button type='button' class='delbtn btn btn-outline-danger' data-empid='" . $row['emp_id'] . "'><i class='bx bx-trash'></i></button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No users found</td></tr>";
}

mysqli_close($conn);
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.delbtn').click(function () {
            var empId = $(this).data('empid');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    type: 'POST',
                    url: 'dbuserDelete.php',
                    data: { emp_id: empId },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.editbtn').click(function () {
            var empId = $(this).data('empid');
            $('#editEmpId').val(empId);
            console.log(empId);
            $.ajax({
                type: 'POST',
                url: 'dbfetch_userData.php',
                data: { emp_id: empId },
                dataType: 'json',
                success: function (data) {
                    $('#editFirstname').val(data.empl_firstname);
                    $('#editLastname').val(data.empl_lastname);
                    $('#editEmail').val(data.email);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            $('#editModal').modal('show');
        });
    });
</script>