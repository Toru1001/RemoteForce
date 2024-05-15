$('.projeditbtn').click(function () {
    var projId = $(this).data('projid');
    $('#editprojId').val(projId);
    console.log('projId:', projId);

    $.ajax({
        type: 'POST',
        url: 'dbfetch_projectData.php',
        data: { proj_id: projId },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#editProjectName').val(data.project_name);
            $('#editProjectStatus').val(data.project_status);
            $('#editStartDate').val(data.start_date);
            $('#editEndDate').val(data.end_date);
            $('#projcontent').html(atob(data.proj_description));
            $('#hiddenDescription').val(atob(data.proj_description));

            $.ajax({
                type: 'POST',
                url: 'dbgetprojectManagers.php',
                dataType: 'json',
                success: function (managers) {
                    $('#projectmanager').empty();
                    $.each(managers, function (key, value) {
                        $('#projectmanager').append('<option value="' + value.emp_id + '">' + value.empl_firstname + ' ' + value.empl_lastname + '</option>');
                    });
                    $('#projectmanager').val(data.project_manager);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    $('#projeditModal').modal('show');
});

$('#updateBtn').click(function () {
    var projId = $('#editprojId').val();
    var projectName = $('#editProjectName').val();
    var projectStatus = $('#editProjectStatus').val();
    var startDate = $('#editStartDate').val();
    var endDate = $('#editEndDate').val();
    var projectManager = $('#projectmanager').val();
    var projectDescription = $('#projcontent').html();
    $('#hiddenDescription').val(projectDescription);


    $.ajax({
        type: 'POST',
        url: 'dbUpdateProject.php',
        data: {
            proj_id: projId,
            project_name: projectName,
            project_status: projectStatus,
            start_date: startDate,
            end_date: endDate,
            project_manager: projectManager,
            proj_description: projectDescription
        },
        success: function (response) {
            alert('Project updated successfully.');
            $('#projeditModal').modal('hide');
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
