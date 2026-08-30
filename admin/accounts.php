<?php
include "conn.php";

$successMessage = "";
if (isset($_POST['addExpense'])) {
    $sql = "INSERT INTO expenses (title, category, amount, expense_date, description) 
            VALUES (:title, :cat, :amt, :edate, :desc)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':title' => $_POST['title'],
        ':cat' => $_POST['category'],
        ':amt' => $_POST['amount'],
        ':edate' => $_POST['expense_date'],
        ':desc' => $_POST['description']
    ]);
    $successMessage = "Expense recorded successfully!";
}

include "header.php";
?>

<main class="py-4">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white fw-bold"><i class="bi bi-graph-down-arrow me-2"></i> Accounts & Expenses</h2>
            <button class="btn btn-danger fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                <i class="bi bi-plus-circle me-1"></i> Add Expense
            </button>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <!-- EXPENSES TABLE -->
        <div class="card border-0 shadow bg-dark text-white rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3 text-white-50">College Expenses</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-light text-dark">
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <tr>
                                        <td><?= date("d M Y", strtotime($row['expense_date'])); ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['title']); ?></td>
                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['category']); ?></span></td>
                                        <td><small class="text-white-50"><?= htmlspecialchars($row['description']); ?></small></td>
                                        <td class="fw-bold text-danger">- &#8377;<?= number_format($row['amount'], 2); ?></td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="5" class="text-center py-3 text-white-50">No expenses recorded yet.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL: ADD EXPENSE -->
<div class="modal fade" id="addExpenseModal" tabindex="-1">
    <div class="modal-dialog text-dark">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Record Expense</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST">
                    <div class="col-12">
                        <label class="form-label fw-bold">Expense Title</label>
                        <input type="text" class="form-control" name="title" placeholder="e.g. Electricity Bill" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="Utilities">Utilities</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Event">Event</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Misc">Miscellaneous</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Amount (&#8377;)</label>
                        <input type="number" step="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Date</label>
                        <input type="date" class="form-control" name="expense_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Description (Optional)</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="addExpense" class="btn btn-danger">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>