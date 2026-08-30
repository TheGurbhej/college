<?php
include "conn.php";

// ================= FORM SUBMISSION =================
$successMessage = "";
if (isset($_POST['addEvent'])) {
    $sql = "INSERT INTO college_events (event_name, event_type, event_date, start_time, end_time, location, organizer, description) 
            VALUES (:name, :type, :edate, :stime, :etime, :location, :organizer, :description)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name'        => $_POST['event_name'],
        ':type'        => $_POST['event_type'],
        ':edate'       => $_POST['event_date'],
        ':stime'       => !empty($_POST['start_time']) ? $_POST['start_time'] : null,
        ':etime'       => !empty($_POST['end_time']) ? $_POST['end_time'] : null,
        ':location'    => $_POST['location'],
        ':organizer'   => $_POST['organizer'],
        ':description' => $_POST['description']
    ]);
    $successMessage = "Event added successfully!";
}

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-calendar-event-fill me-2"></i> Event Management</h2>
            <button class="btn btn-info fw-semibold shadow-sm text-dark" data-bs-toggle="modal" data-bs-target="#addEventModal">
                <i class="bi bi-plus-circle me-1"></i> Add New Event
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">Upcoming & Past Events</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th>Event Date</th>
                                <th>Event Name</th>
                                <th>Type</th>
                                <th>Timing</th>
                                <th>Location</th>
                                <th>Organizer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT * FROM college_events ORDER BY event_date DESC");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                    // Set badge color based on Event Type
                                    $badgeColor = 'secondary';
                                    if ($row['event_type'] == 'Seminar') $badgeColor = 'primary';
                                    if ($row['event_type'] == 'Cultural') $badgeColor = 'warning text-dark';
                                    if ($row['event_type'] == 'Sports') $badgeColor = 'success';
                                    if ($row['event_type'] == 'Holiday') $badgeColor = 'danger';
                                    if ($row['event_type'] == 'Workshop') $badgeColor = 'info text-dark';

                                    // Format Timing
                                    $timing = "All Day";
                                    if (!empty($row['start_time']) && !empty($row['end_time'])) {
                                        $timing = date("h:i A", strtotime($row['start_time'])) . ' - ' . date("h:i A", strtotime($row['end_time']));
                                    }
                            ?>
                                    <tr>
                                        <td class="text-warning fw-bold"><?= date("d M Y", strtotime($row['event_date'])); ?></td>
                                        <td class="fw-bold fs-6 text-light"><?= htmlspecialchars($row['event_name']); ?></td>
                                        <td><span class="badge bg-<?= $badgeColor; ?>"><?= htmlspecialchars($row['event_type']); ?></span></td>
                                        <td><small><?= $timing; ?></small></td>
                                        <td><i class="bi bi-geo-alt-fill text-danger me-1"></i><?= htmlspecialchars($row['location']); ?></td>
                                        <td><?= htmlspecialchars($row['organizer'] ?? 'N/A'); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="7" class="text-center py-4 text-white-50">No events found.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL: ADD EVENT -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-plus me-2"></i>Create New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Event Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="event_name" placeholder="e.g. Annual Tech Fest 2026" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Event Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="event_type" required>
                            <option value="Seminar">Seminar</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Cultural">Cultural Fest</option>
                            <option value="Sports">Sports Meet</option>
                            <option value="Holiday">Holiday</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">Event Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="event_date" required>
                    </div>

                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">Start Time</label>
                        <input type="time" class="form-control" name="start_time">
                        <small class="text-muted">Leave empty for All-Day event</small>
                    </div>

                    <div class="col-md-4 mt-4">
                        <label class="form-label fw-bold">End Time</label>
                        <input type="time" class="form-control" name="end_time">
                    </div>

                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Location / Venue <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="location" placeholder="e.g. Main Auditorium" required>
                    </div>

                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-bold">Organizer / Department</label>
                        <input type="text" class="form-control" name="organizer" placeholder="e.g. Computer Science Dept.">
                    </div>

                    <div class="col-12 mt-4">
                        <label class="form-label fw-bold">Description Details</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Write event details or agenda here..."></textarea>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="addEvent" class="btn btn-info fw-bold">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<?php include "footer.php"; ?>