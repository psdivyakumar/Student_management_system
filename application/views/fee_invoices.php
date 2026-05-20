<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance Ledger | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        
        /* Premium Header */
        .page-header { background: white; padding: 15px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex: 0 0 auto; border-bottom: 1px solid rgba(184, 149, 82, 0.2); }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .back-circle:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; margin-left: 15px; font-size: 1.6rem; }

        /* Stats Bar */
        .stats-row { padding: 20px 40px; display: flex; gap: 15px; flex: 0 0 auto; }
        .stat-pill { background: white; padding: 10px 20px; border-radius: 50px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border: 1px solid rgba(184, 149, 82, 0.2); font-size: 0.8rem; font-weight: 600; }

        /* Ledger Table Card */
        .main-container { flex: 1; padding: 0 40px 30px 40px; overflow-y: auto; }
        .ledger-card { background: white; border-radius: 30px; box-shadow: 0 15px 50px rgba(0,0,0,0.03); border: none; padding: 25px; }
        
        .table thead th { background: #fafafa; color: #888; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px; border: none; }
        .table tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f9f9f9; }

        /* Status Badges */
        .badge-paid { background: rgba(25, 135, 84, 0.1); color: #198754; padding: 6px 15px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-unpaid { background: rgba(220, 53, 69, 0.1); color: #dc3545; padding: 6px 15px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        
        .btn-action { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; font-size: 0.85rem; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-collect { background: rgba(184, 149, 82, 0.1); color: var(--gold); }
        .btn-view:hover, .btn-collect:hover { background: var(--forest-green); color: white; }

        /* Premium Buttons */
        .btn-create { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 12px; padding: 10px 25px; font-weight: 700; transition: 0.3s; }
        .btn-create:hover { background: var(--gold); color: white; transform: translateY(-2px); }

        /* Detail Modal */
        .modal-content { border-radius: 30px; border: none; background: var(--cream); overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); padding: 25px; border: none; }
        .invoice-box { background: white; border-radius: 20px; padding: 30px; border: 1px dashed var(--gold); }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Finance & Accounts</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fa fa-search position-absolute" style="left:15px; top:12px; color:var(--gold);"></i>
                <input type="text" id="billSearch" class="form-control ps-5" placeholder="Search invoices..." style="border-radius:50px; width:250px; font-size:0.85rem;" onkeyup="filterLedger()">
            </div>
            <a href="<?= site_url('fees/create_invoice') ?>" class="btn-create shadow-sm">+ Generate Bill</a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-pill">System Date: <span class="text-muted"><?= date('d M Y') ?></span></div>
        <div class="stat-pill">Currency: <span class="text-success">INR (₹)</span></div>
        <a href="<?= site_url('fees/configuration') ?>" class="stat-pill text-decoration-none" style="background: var(--forest-green); color: var(--gold);"><i class="fa fa-cog me-2"></i> Fee Settings</a>
    </div>

    <div class="main-container">
        <div class="ledger-card">
            <table class="table align-middle" id="ledgerTable">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Student Name</th>
                        <th>Bill Date</th>
                        <th>Total Amount</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th class="text-end">Management</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoices as $i): ?>
                    <tr>
                        <td><span class="fw-bold" style="color: var(--forest-green);"><?= $i['invoice_no'] ?></span></td>
                        <td>
                            <div class="fw-bold"><?= $i['first_name'].' '.$i['last_name'] ?></div>
                            <small class="text-muted">ID: #<?= $i['student_id'] ?></small>
                        </td>
                        <td class="text-muted small"><?= date('d M, Y', strtotime($i['created_at'])) ?></td>
                        <td class="fw-bold">₹<?= number_format($i['total_amount']) ?></td>
                        <td class="text-danger fw-bold">₹<?= number_format($i['total_amount'] - $i['paid_amount']) ?></td>
                        <td>
                            <span class="<?= ($i['status'] == 'Paid') ? 'badge-paid' : 'badge-unpaid' ?>">
                                <?= $i['status'] ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn-action btn-view me-1" onclick='viewInvoice(<?= json_encode($i) ?>)'><i class="fa fa-eye"></i></button>
                            <a href="<?= site_url('fees/collect/'.$i['id']) ?>" class="btn-action btn-collect me-1"><i class="fa fa-hand-holding-dollar"></i></a>
                            <a href="<?= site_url('fees/receipt/'.$i['id']) ?>" class="btn-action bg-dark text-white"><i class="fa fa-print"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Invoice Detail Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Digital Invoice Breakdown</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="invoice-box">
                        <div class="text-center mb-4">
                            <i class="fa fa-file-invoice-dollar fa-3x text-gold mb-3"></i>
                            <h4 class="fw-bold mb-0" id="inv_no"></h4>
                            <p class="text-muted small">Generated on <span id="inv_date"></span></p>
                        </div>
                        <div class="d-flex justify-content-between mb-2"><span>Student:</span> <strong id="inv_name"></strong></div>
                        <div class="d-flex justify-content-between mb-2"><span>Bill Title:</span> <strong id="inv_title"></strong></div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2"><span>Billed Amount:</span> <strong class="fs-5">₹<span id="inv_total"></span></strong></div>
                        <div class="d-flex justify-content-between mb-2 text-success"><span>Amount Paid:</span> <strong>₹<span id="inv_paid"></span></strong></div>
                        <div class="d-flex justify-content-between text-danger fw-bold fs-5"><span>Remaining:</span> <span>₹<span id="inv_bal"></span></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterLedger() {
            let input = document.getElementById("billSearch").value.toUpperCase();
            let rows = document.getElementById("ledgerTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = rows[i].innerText.toUpperCase().includes(input) ? "" : "none";
            }
        }
        function viewInvoice(data) {
            document.getElementById('inv_no').innerText = data.invoice_no;
            document.getElementById('inv_date').innerText = data.created_at;
            document.getElementById('inv_name').innerText = data.first_name + ' ' + data.last_name;
            document.getElementById('inv_title').innerText = data.title;
            document.getElementById('inv_total').innerText = parseFloat(data.total_amount).toLocaleString();
            document.getElementById('inv_paid').innerText = parseFloat(data.paid_amount).toLocaleString();
            document.getElementById('inv_bal').innerText = (data.total_amount - data.paid_amount).toLocaleString();
            new bootstrap.Modal(document.getElementById('invoiceModal')).show();
        }
    </script>
</body>
</html>