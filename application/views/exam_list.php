<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Scheduling | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        
        .page-header { background: white; padding: 15px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex: 0 0 auto; }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .back-circle:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; margin-left: 15px; font-size: 1.8rem; }

        .main-content { flex: 1; padding: 25px 40px; overflow-y: auto; display: grid; grid-template-columns: 350px 1fr; gap: 30px; }
        .glass-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; height: fit-content; }
        
        .form-label { font-size: 0.7rem; font-weight: 800; color: var(--gold); text-transform: uppercase; margin-bottom: 5px; }
        .form-control { border-radius: 12px; border: 1px solid #eef0f2; padding: 12px; font-size: 0.9rem; margin-bottom: 20px; }

        .exam-badge { background: var(--forest-green); color: var(--gold); padding: 8px 15px; border-radius: 10px; font-weight: 700; font-size: 0.8rem; border: 1px solid var(--gold); }
        .btn-royal { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 12px; padding: 12px; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-royal:hover { background: var(--gold); color: white; }

        .table thead th { background: var(--forest-green); color: var(--gold); padding: 18px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Examination Hub</h2>
        </div>
        <div class="text-muted small"><i class="fa fa-medal text-gold me-2"></i>Academic Season 2024-25</div>
    </div>

    <div class="main-content">
        <!-- Add Exam Form -->
        <div class="glass-card">
            <h5 class="fw-bold mb-4" style="color: var(--forest-green);">Create New Exam</h5>
            <form action="<?= site_url('exams') ?>" method="POST">
                <label class="form-label">Exam Name</label>
                <input type="text" name="exam_name" class="form-control" placeholder="e.g. Mid-Term Assessment" required>
                
                <label class="form-label">Commencement Date</label>
                <input type="date" name="start_date" class="form-control" required>
                
                <button type="submit" class="btn btn-royal shadow-sm">Initialize Exam</button>
            </form>
        </div>

        <!-- Scheduled Exams List -->
        <div class="glass-card">
            <h5 class="fw-bold mb-4" style="color: var(--forest-green);">Scheduled Examinations</h5>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Examination Title</th>
                        <th>Start Date</th>
                        <th class="text-end">Management</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($exams as $e): ?>
                    <tr>
                        <td><div class="exam-badge d-inline-block"><?= $e['exam_name'] ?></div></td>
                        <td class="fw-bold text-muted"><?= date('d M, Y', strtotime($e['start_date'])) ?></td>
                        <td class="text-end">
                            <a href="<?= site_url('exams/marks_entry?exam_id='.$e['id']) ?>" class="btn btn-outline-dark btn-sm" style="border-radius: 10px; border-color: var(--gold); color: var(--forest-green); font-weight: 600;">
                                <i class="fa fa-file-signature me-2"></i>Enter Marks
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>