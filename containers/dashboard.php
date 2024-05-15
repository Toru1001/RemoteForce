<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/styles/dashboard.css">
</head>

<body>
    <div class="body p-3">
        <section class="pageTitle p-3">
            <h1>Dashboard</h1>
        </section>

        <div class="separator"></div>

        <section class="subh">
            <h5 class="p-3">Welcome Administrator!</h5>
        </section>

        <section class="summary p-3">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Projects</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">4</div>
                                </div>
                                <div class="col-auto">
                                    <i class="lni lni-folder" id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Annual) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Employees</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                                </div>
                                <div class="col-auto">
                                    <i class='bx bxs-user' id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Tasks</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                                </div>
                                <div class="col-auto">
                                    <i class='bx bx-list-ul' id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Completed Projects</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class='bx bxs-check-square' id="icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="projects">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body font-weight-bold p-3">
                    Project Progress
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Project</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Create Mods</td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-primary" style="width: 50%">50%</div>
                                </div>
                            </td>
                            <td>05/13/2024</td>
                            <td>In-Progress</td>
                            <td><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>Create Mods</td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-primary" style="width: 50%">50%</div>
                                </div>
                            </td>
                            <td>05/13/2024</td>
                            <td>In-Progress</td>
                            <td><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>Create Mods</td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-primary" style="width: 50%">50%</div>
                                </div>
                            </td>
                            <td>05/13/2024</td>
                            <td>In-Progress</td>
                            <td><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>Create Mods</td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-primary" style="width: 50%">50%</div>
                                </div>
                            </td>
                            <td>05/13/2024</td>
                            <td>In-Progress</td>
                            <td><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>Create Mods</td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-primary" style="width: 50%">50%</div>
                                </div>
                            </td>
                            <td>05/13/2024</td>
                            <td>In-Progress</td>
                            <td><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>

</html>