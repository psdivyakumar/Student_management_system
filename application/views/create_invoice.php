<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Invoice | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; min-height: 100vh; }
        
        /* Premium Header */
        .page-header { background: white; padding: 15px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(184, 149, 82, 0.2); }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .back-circle:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; margin-left: 15px; font-size: 1.6rem; }

        .form-container { max-width: 700px; margin: 50px auto; }
        .billing-card { background: white; border-radius: 35px; box-shadow: 0 20px 60px rgba(0,0,0,0.04); border: none; padding: 45px; overflow: hidden; position: relative; }
        
        /* Decorative corner element */
        .billing-card::before { content: ""; position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, transparent 50%, rgba(184, 149, 82, 0.1) 50%); }

        .form-section-header { font-family: 'Playfair Display', serif; color: var(--gold); font-size: 1.2rem; margin-bottom: 25px; display: flex; align-items: center; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; }
        .form-section-header i { margin-right: 12px; font-size: 1rem; }

        .form-label { font-size: 0.7rem; font-weight: 800; color: #555; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #eef0f2; padding: 12px 18px; font-size: 0.95rem; background: #fbfcfd; transition: 0.3s; }
        .form-control:focus, .form-select:focus { border-color: var(--gold); background: white; box-shadow: 0 5px 15px rgba(184, 149, 82, 0.08); outline: none; }

        .amount-highlight { background: #f8f7f2; border: 2px solid var(--gold); border-radius: 15px; padding: 20px; text-align: center; margin-top: 20px; }
        .amount-highlight h3 { color: var(--forest-green); font-weight: 800; margin: 0; }

        .btn-generate { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 15px; padding: 16px; width: 100%; font-weight: 700; font-size: 1.1rem; transition: 0.3s; letter-spacing: 1px; }
        .btn-generate:hover { background: var(--gold); color: white; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(184, 149, 82, 0.2); }
        
        .helper-text { font-size: 0.75rem; color: #999; margin-top: 15px; text-align: center; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('fees') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Issue New Bill</h2>
        </div>
        <div class="small fw-bold" style="color: var(--gold); letter-spacing: 1px;">FINANCIAL HUB</div>
    </div>

    <div class="container">
        <div class="form-container">
            <div class="billing-card">
                <form action="<?= site_url('fees/create_invoice') ?>" method="POST">
                    
                    <!-- Section 1: Recipient -->
                    <div class="form-section-header">
                        <i class="fa fa-user-graduate"></i> Recipient Information
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Select Student</label>
                        <select name="student_id" class="form-select shadow-sm" required>
                            <option value="">-- Choose student from directory --</option>
                            <?php foreach($students as $s): ?>
                                <option value="<?= $s['id'] ?>">
                                    <?= $s['first_name'] ?> <?= $s['last_name'] ?> (ID: #<?= $s['adm_no'] ?>) - Class <?= $s['class'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Section 2: Bill Details -->
                    <div class="form-section-header">
                        <i class="fa fa-file-invoice"></i> Billing Particulars
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Invoice Title / Description</label>
                            <input type="text" name="title" class="form-control shadow-sm" placeholder="e.g. Second Quarter Tuition & Library Fees" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Fixed Billed Amount (INR)</label>
                            <div class="amount-highlight">
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-transparent fs-4 fw-bold text-gold">₹</span>
                                    <input type="number" name="total_amount" class="form-control border-0 bg-transparent fs-3 fw-bold p-0" placeholder="0.00" style="box-shadow: none;" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-generate shadow">
                            Authorize & Dispatch Invoice
                        </button>
                        <p class="helper-text">
                            <i class="fa fa-lock me-2"></i> This action will generate a unique Invoice ID and notify the parent.
                        </p>
                    </div>

                </form>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?= site_url('fees') ?>" class="text-muted text-decoration-none small fw-medium">
                    <i class="fa fa-times me-1"></i> Discard and return to ledger
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>