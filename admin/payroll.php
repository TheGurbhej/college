<?php
include "conn.php";

$successMessage = "";
if (isset($_POST['addPayroll'])) {
    $sql = "INSERT INTO payroll (employee_name, designation, salary_month, net_salary, payment_date, status) 
            VALUES (:emp, :desig, :month, :salary, :pdate, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':emp' => $_POST['employee_name'],
        ':desig' => $_POST['designation'],
        ':month' => $_POST['salary_month'],
        ':salary' => $_POST['net_salary'],
        ':pdate' => $_POST['payment_date'],
        ':status' => $_POST['status']
    ]);
    $successMessage = "Salary processed successfully!";
}

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-people-fill me-2"></i> HR & Payroll</h2>
            <button class="btn btn-primary fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addPayrollModal">
                <i class="bi bi-plus-circle me-1"></i> Process Salary
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <!-- PAYROLL TABLE -->
        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">Staff Payroll & Salary</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th>Payment Date</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Salary Month</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT * FROM payroll ORDER BY id DESC");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td><?= date("d M Y", strtotime($row['payment_date'])); ?></td>
                                        <td class="fw-bold text-light"><?= htmlspecialchars($row['employee_name']); ?></td>
                                        <td><?= htmlspecialchars($row['designation']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['salary_month']); ?></span></td>
                                        <td class="fw-bold text-success">&#8377;<?= number_format($row['net_salary'], 2); ?></td>
                                        <td><span class="badge bg-success"><?= htmlspecialchars($row['status']); ?></span></td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-3 text-white-50">No payroll records found.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL: PROCESS PAYROLL -->
<div class="modal fade" id="addPayrollModal" tabindex="-1">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Process Staff Salary</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Employee Name</label>
                        <input type="text" class="form-control" name="employee_name" placeholder="e.g. Rajesh Kumar" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Designation</label>
                        <input type="text" class="form-control" name="designation" placeholder="e.g. Assistant Professor" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Salary Month</label>
                        <input type="month" class="form-control" name="salary_month" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Net Salary (&#8377;)</label>
                        <input type="number" step="0.01" class="form-control" name="net_salary" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Payment Date</label>
                        <input type="date" class="form-control" name="payment_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="addPayroll" class="btn btn-primary">Process Payroll</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>