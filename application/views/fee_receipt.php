<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital Receipt | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background: #555; padding: 50px; font-family: 'Inter', sans-serif; }
        
        /* The Actual Paper */
        .receipt-container { 
            background: white; width: 600px; margin: 0 auto; padding: 40px; 
            border-top: 10px solid #061e19; position: relative;
            box-shadow: 0 0 50px rgba(0,0,0,0.5);
        }

        .header-logo { text-align: center; margin-bottom: 30px; }
        .header-logo h2 { font-family: 'Playfair Display', serif; color: #061e19; letter-spacing: 2px; text-transform: uppercase; margin: 0; }
        .header-logo p { font-size: 0.7rem; color: #b89552; font-weight: 700; letter-spacing: 3px; }

        .receipt-info { display: flex; justify-content: space-between; margin-bottom: 40px; font-size: 0.85rem; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        
        .table-receipt { width: 100%; margin-bottom: 30px; }
        .table-receipt th { background: #f8f7f2; padding: 12px; font-size: 0.75rem; text-transform: uppercase; color: #061e19; }
        .table-receipt td { padding: 15px 12px; border-bottom: 1px solid #f8f8f8; }

        .total-box { background: #061e19; color: #b89552; padding: 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; }

        .stamp-paid { 
            position: absolute; top: 150px; right: 50px; width: 120px; height: 120px; 
            border: 4px solid #198754; color: #198754; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 1.5rem; transform: rotate(-20deg);
            opacity: 0.2; text-transform: uppercase;
        }

        .no-print-btn { 
            position: fixed; bottom: 30px; right: 30px; 
            background: #b89552; color: white; border: none; padding: 15px 30px; 
            border-radius: 50px; font-weight: 700; box-shadow: 0 10px 20px rgba(0,0,0,0.2); 
        }

        @media print {
            .no-print-btn { display: none; }
            body { background: white; padding: 0; }
            .receipt-container { box-shadow: none; width: 100%; border: 1px solid #eee; }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="stamp-paid">PAID</div>
        
        <div class="header-logo">
            <h2>Studiora</h2>
            <p>Institutional Excellence</p>
        </div>

        <div class="receipt-info">
            <div>
                <span class="text-muted">BILL TO:</span><br>
                <strong><?= $inv['first_name'].' '.$inv['last_name'] ?></strong><br>
                <span>Class: <?= $inv['class'] ?></span><br>
                <span>Student ID: #<?= $inv['student_id'] ?></span>
            </div>
            <div class="text-end">
                <span class="text-muted">RECEIPT NO:</span><br>
                <strong style="color: #061e19;"><?= $inv['invoice_no'] ?></strong><br>
                <span class="text-muted">DATE:</span><br>
                <span><?= date('d M, Y', strtotime($inv['created_at'])) ?></span>
            </div>
        </div>

        <table class="table-receipt">
            <thead>
                <tr>
                    <th>Description of Service</th>
                    <th class="text-end">Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong><?= $inv['title'] ?></strong><br>
                        <small class="text-muted">Academic session charges and laboratory fees</small>
                    </td>
                    <td class="text-end fw-bold">₹<?= number_format($inv['total_amount']) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="row mb-4">
            <div class="col-7">
                <p class="small text-muted"><strong>Terms:</strong> This is a computer-generated document. No signature required. Payments are non-refundable after processing.</p>
            </div>
            <div class="col-5">
                <div class="d-flex justify-content-between mb-1 small"><span>Subtotal:</span> <span>₹<?= number_format($inv['total_amount']) ?></span></div>
                <div class="d-flex justify-content-between mb-3 small text-success"><span>Amount Paid:</span> <span>- ₹<?= number_format($inv['paid_amount']) ?></span></div>
                <div class="total-box">
                    <span class="fw-bold small">BALANCE DUE:</span>
                    <h4 class="mb-0">₹<?= number_format($inv['total_amount'] - $inv['paid_amount']) ?></h4>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="small fw-bold" style="color: #b89552;">Thank you for your contribution to the Studiora Academic Community.</p>
        </div>
    </div>

    <button class="no-print-btn shadow" onclick="window.print()">
        <i class="fa fa-print me-2"></i>Print Official Receipt
    </button>

</body>
</html>