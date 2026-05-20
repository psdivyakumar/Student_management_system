<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fee Structure | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        
        .page-header { background: white; padding: 15px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex: 0 0 auto; }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .back-circle:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; margin-left: 15px; font-size: 1.6rem; }

        .main-content { flex: 1; padding: 30px 40px; overflow-y: auto; display: grid; grid-template-columns: 350px 1fr; gap: 30px; }
        
        .glass-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; height: fit-content; }
        .form-label { font-size: 0.7rem; font-weight: 800; color: var(--gold); text-transform: uppercase; margin-bottom: 5px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #eef0f2; padding: 10px; font-size: 0.9rem; margin-bottom: 15px; }

        .table thead th { background: var(--forest-green); color: var(--gold); padding: 15px; font-size: 0.7rem; text-transform: uppercase; border: none; }
        .fee-type-badge { background: rgba(184, 149, 82, 0.1); color: var(--gold); padding: 5px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; border: 1px solid rgba(184, 149, 82, 0.2); }

        .btn-royal { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 12px; padding: 12px; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-royal:hover { background: var(--gold); color: white; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('fees') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Fee Configuration</h2>
        </div>
        <div class="text-muted small fw-bold"><i class="fa fa-shield-heart text-gold me-2"></i>Secure Fiscal Settings</div>
    </div>

    <div class="main-content">
        <!-- Add Fee Structure Form -->
        <div class="glass-card">
            <h5 class="fw-bold mb-4" style="color: var(--forest-green);">Define New Fee</h5>
            <form action="<?= site_url('fees/configuration') ?>" method="POST">
                <label class="form-label">Academic Class</label>
                <select name="class_id" class="form-select" required>
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['class_name'] ?> - <?= $c['section_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label class="form-label">Fee Head / Type</label>
                <input type="text" name="fee_type" class="form-control" placeholder="e.g. Annual Tuition" required>
                
                <label class="form-label">Defined Amount (₹)</label>
                <input type="number" name="amount" class="form-control" placeholder="0.00" required>
                
                <button type="submit" class="btn btn-royal mt-2 shadow-sm">Save Fee Policy</button>
            </form>
        </div>

        <!-- Master Structure List -->
        <div class="glass-card">
            <h5 class="fw-bold mb-4" style="color: var(--forest-green);">Master Fee Structure</h5>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Fee Component</th>
                        <th>Standard Amount</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Note: This logic assumes you fetched the structure in your controller
                    if(isset($structures)): 
                        foreach($structures as $s): ?>
                        <tr>
                            <td class="fw-bold" style="color: var(--forest-green);">Class <?= $s['class_name'] ?></td>
                            <td><span class="fee-type-badge"><?= $s['fee_type'] ?></span></td>
                            <td class="fw-bold text-dark">₹<?= number_format($s['amount']) ?></td>
                            <td class="text-end">
                                <button class="btn btn-sm text-danger opacity-50"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; 
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>