<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authorize Payment | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; }
        .page-header { background: white; padding: 20px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; margin-bottom: 40px; }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; margin-right: 15px; }
        .back-circle:hover { background: var(--gold); color: white; }
        
        .payment-card { background: white; border-radius: 30px; box-shadow: 0 15px 50px rgba(0,0,0,0.03); border: none; overflow: hidden; max-width: 600px; margin: 0 auto; }
        .checkout-header { background: var(--forest-green); color: var(--gold); padding: 30px; text-align: center; }
        .payment-body { padding: 40px; }
        
        .amount-display { background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 20px; padding: 20px; text-align: center; margin-bottom: 30px; }
        .amount-display h2 { color: var(--forest-green); font-weight: 800; font-size: 2.5rem; margin-top: 5px; }
        
        .form-label { font-size: 0.7rem; font-weight: 800; color: var(--gold); text-transform: uppercase; margin-bottom: 5px; }
        .form-control { border-radius: 12px; border: 2px solid #f0f0f0; padding: 12px; font-weight: 700; font-size: 1.1rem; text-align: center; color: var(--forest-green); }
        .form-control:focus { border-color: var(--gold); outline: none; background: #fffcf8; }

        .btn-confirm { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 15px; padding: 15px; width: 100%; font-weight: 700; font-size: 1rem; transition: 0.3s; margin-top: 20px; }
        .btn-confirm:hover { background: var(--gold); color: white; transform: scale(1.02); }
    </style>
</head>
<body>

    <div class="page-header">
        <a href="<?= site_url('fees') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
        <h2 style="font-family: 'Playfair Display'; color: var(--forest-green); margin:0;">Payment Authorization</h2>
    </div>

    <div class="container">
        <div class="payment-card">
            <div class="checkout-header">
                <i class="fa fa-building-columns fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">Studiora Treasury</h5>
                <small class="opacity-75">Secure Transaction Portal</small>
            </div>
            
            <div class="payment-body">
                <div class="amount-display">
                    <p class="small text-muted text-uppercase fw-bold mb-0">Total Outstanding Balance</p>
                    <h2>₹<?= number_format($inv['total_amount'] - $inv['paid_amount']) ?></h2>
                </div>

                <form action="<?= site_url('fees/collect/'.$inv['id']) ?>" method="POST">
                    <div class="mb-4">
                        <label class="form-label">Student Name</label>
                        <div class="fw-bold border-bottom pb-2"><?= $inv['first_name'] ?> <?= $inv['last_name'] ?></div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Payment Amount</label>
                        <input type="number" name="amount_to_pay" class="form-control" placeholder="Enter amount to receive" required>
                    </div>

                    <div class="mb-4 text-center">
                        <small class="text-muted"><i class="fa fa-lock me-2"></i>This payment will be recorded in the permanent ledger.</small>
                    </div>

                    <button type="submit" class="btn-confirm shadow">
                        Authorize Transaction
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>