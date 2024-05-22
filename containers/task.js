$(document).ready(function () {
    $('.taskviewbtn').click(function () {
        var taskId = $(this).data('task-id');
        viewTask(taskId);
    });

    function viewTask(taskId) {
        $.ajax({
            url: 'dbgetTaskDetails.php',
            type: 'GET',
            data: { taskId: taskId },
            success: function (response) {
                var taskDetails = JSON.parse(response);
                $('#viewTaskName2').text(taskDetails.task_name);
                $('#viewTaskDescription2').html(atob(taskDetails.task_description));
                $('#viewTaskDueDate2').text(taskDetails.deadline);
                $('#viewTaskPriority2').text(taskDetails.priority);
                $('#viewTaskStatus2').text(taskDetails.task_status);
                $('#viewTaskCreator2').text(taskDetails.creator_name);
                $('#viewTaskModal2').modal('show');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while fetching task details.');
            }
        });
    }
});

$(document).ready(function () {
    $('.taskeditbtn').click(function () {
        var taskId = $(this).data('task-id');
        console.log(taskId);

        $.ajax({
            url: 'dbgetTaskDetails.php',
            type: 'GET',
            data: { taskId: taskId },
            success: function (response) {
                var taskDetails = JSON.parse(response);

                $('#uptaskName').val(taskDetails.task_name);
                $('#uptaskPriority').val(taskDetails.priority);
                $('#uptaskDeadline').val(taskDetails.deadline);
                $('#uptaskStatus').val(taskDetails.task_status);
                $('#upprojcontent').html(atob(taskDetails.task_description));

                $('#upedittaskId').val(taskId);

                $('#editTaskModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while fetching task details.');
            }
        });
    });

    $('#updateTaskButton').click(function () {
        var taskId = $('#upedittaskId').val();
        var taskName = $('#uptaskName').val();
        var taskPriority = $('#uptaskPriority').val();
        var taskDeadline = $('#uptaskDeadline').val();
        var taskStatus = $('#uptaskStatus').val();
        var taskDescription = btoa($('#upprojcontent').html());

        var formData = {
            taskId: taskId,
            taskName: taskName,
            taskPriority: taskPriority,
            taskDeadline: taskDeadline,
            taskStatus: taskStatus,
            taskDescription: taskDescription
        };

        $.ajax({
            url: 'dbupdateTask.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.trim() === 'Task updated successfully') {
                    alert('Task updated successfully');
                    $('#editTaskModal').modal('hide');
                    location.reload();
                } else {
                    alert('Failed to update task. Server response: ' + response);
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred while updating the task. Error: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});

function populateTaskDropdown(tasks) {
    const taskDropdown = document.getElementById('taskDropdown');
    taskDropdown.innerHTML = '';
    tasks.forEach(task => {
        const option = document.createElement('option');
        option.value = task.task_id;
        option.textContent = task.task_name;
        taskDropdown.appendChild(option);
    });

    const modal = new bootstrap.Modal(document.getElementById('addProductivityModal'));
    modal.show();
}