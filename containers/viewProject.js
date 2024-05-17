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
                $('#viewTaskName').text(taskDetails.task_name);
                $('#viewTaskDescription').html(atob(taskDetails.task_description));
                $('#viewTaskDueDate').text(taskDetails.deadline);
                $('#viewTaskPriority').text(taskDetails.priority);
                $('#viewTaskStatus').text(taskDetails.task_status);
                $('#viewTaskCreator').text(taskDetails.creator_name);
                $('#viewTaskModal').modal('show');
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

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.deletebtn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            var prodId = this.getAttribute('data-tracking-id');
            if (confirm('Are you sure you want to delete this productivity entry?')) {
                var formData = new FormData();
                formData.append('tracking_id', prodId);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'dbdeleteprod.php', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        console.log('Server response: ' + xhr.responseText);
                        if (xhr.responseText.includes('Productivity entry deleted successfully')) {
                            alert('Productivity entry deleted successfully');
                            location.reload();
                            document.getElementById('prod-entry-' + prodId).remove();
                            
                        } else {
                            alert('An error occurred while deleting the productivity entry. Response: ' + xhr.responseText);
                        }
                    } else {
                        alert('An error occurred while deleting the productivity entry. Status: ' + xhr.status);
                        console.log('Error status: ' + xhr.status + ' - ' + xhr.statusText);
                    }
                };
                xhr.onerror = function () {
                    alert('An error occurred while sending the request.');
                    console.log('Request error: ' + xhr.statusText);
                };
                xhr.send(formData);
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.table').addEventListener('click', function(event) {
        if (event.target.classList.contains('taskdeletebtn')) {
            var taskId = event.target.getAttribute('data-task-id');

            if (confirm('Are you sure you want to delete this task?')) {
                fetch('dbdeleteTask.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ task_id: taskId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Task deleted successfully');
                        location.reload();
                    } else {
                        alert('Error deleting task: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the task.');
                });
            }
        }
    });
});
