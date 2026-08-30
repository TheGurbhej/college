<?php
include "header.php";
?>
<main class="py-4">
    <div class="container">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-white fw-bold">📅 Time Table</h2>
                <p class="text-white-50 mb-0">Manage class schedules</p>
            </div>

            <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#timeTableModal">
                <i class="bi bi-plus-circle me-2"></i>
                Add Time Table
            </button>
        </div>

        <!-- Card -->
        <div class="card border-0 shadow">

            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Weekly Time Table</h5>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover text-center align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th>Day</th>
                                <th>9:00 - 10:00</th>
                                <th>10:00 - 11:00</th>
                                <th>11:00 - 12:00</th>
                                <th>12:00 - 1:00</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <th>Monday</th>
                                <td>Math</td>
                                <td>English</td>
                                <td>Physics</td>
                                <td>Chemistry</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <th>Tuesday</th>
                                <td colspan="5" class="text-muted">
                                    No Schedule
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="timeTableModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Time Table</h5>

                    <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Day</label>

                                <select class="form-select" name="day">
                                    <option>Monday</option>
                                    <option>Tuesday</option>
                                    <option>Wednesday</option>
                                    <option>Thursday</option>
                                    <option>Friday</option>
                                    <option>Saturday</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subject</label>

                                <select class="form-select" name="subject">
                                    <option>Select Subject</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control" name="end_time">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teacher</label>

                                <select class="form-select" name="teacher">
                                    <option>Select Teacher</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Room No.</label>
                                <input type="text" class="form-control" name="room">
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button class="btn btn-primary"
                            type="submit"
                            name="addTimeTable">
                            Save
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


</main>
<?php
include "footer.php";
?>