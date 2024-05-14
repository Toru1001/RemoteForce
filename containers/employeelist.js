$(document).ready(function () {
    $('.delbtn').click(function () {
        var empId = $(this).data('empid');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                type: 'POST',
                url: 'dbuserDelete.php',
                data: { emp_id: empId },
                success: function (response) {
                    $('.toast-body').html('You removed an Employee');
                    $('.toast').toast('show');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

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
                $('#editPosition').val(data.position);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('#editModal').modal('show');
    });

    $('#updateBtn').click(function () {
        var empId = $('#editEmpId').val();
        var firstname = $('#editFirstname').val();
        var lastname = $('#editLastname').val();
        var email = $('#editEmail').val();
        var position = $('#editPosition').val();
        var department = $('#editDepartment').val();
        var password = $('#editPassword').val();

        $.ajax({
            type: 'POST',
            url: 'dbuserUpdate.php',
            data: {
                emp_id: empId,
                firstname: firstname,
                lastname: lastname,
                email: email,
                position: position,
                department: department,
                password: password
            },
            success: function (response) {
                $('.toast-body').html('User Updated!');
            $('.toast').toast('show');
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});