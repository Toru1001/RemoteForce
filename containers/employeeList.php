<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
    <div class="body p-3">
        <section class="pageTitle1 p-3">
            <h2>Employees</h2>
        </section>
        <div class="separator"></div>

        <nav class="navbar bg-body-tertiary p-3">
            <div class="container-fluid d-flex align-items-center">
                <button class="adbtn btn btn-outline-success p-2" type="button"
                    onclick="window.location.href='main.php?page=newUser'">Add New Employee</button>
            </div>
        </nav>


        <section class="p-4">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Email</th>
                            <th scope="col">Position</th>
                            <th scope="col">Department</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="addData">
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
                                echo "<td>
                                <button type='button' class='editbtn btn btn-outline-secondary' data-empid='" . $row['emp_id'] . "'><i class='bx bxs-edit'></i></button>
                                <button type='button' class='delbtn btn btn-outline-danger' data-empid='" . $row['emp_id'] . "'><i class='bx bx-trash'></i></button>
                              </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No users found</td></tr>";
                        }

                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        </section>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editEmpId" name="emp_id">
                        <div class="mb-3">
                            <label for="editFirstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstname" name="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="editLastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastname" name="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="editPosition" class="form-label">Position</label>
                                <select class="form-select" id="editPosition" name="position">
                                    <option value="0" disabled selected>Select Position</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Project Manager">Project Manager</option>
                                    <option value="Employee">Employee</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editDepartment" class="form-label">Department</label>
                                <select class="form-select" id="editDepartment" name="department">
                                    <option value="0" selected>Select Department</option>
                                    <option value="1">Bussiness Development</option>
                                    <option value="2">Development</option>
                                    <option value="3">Design</option>
                                    <option value="4">Marketing</option>
                                    <option value="5">Customer Support</option>
                                    <option value="6">Cybersecurity</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="containers/employeelist.js"></script>
</body>

</html>