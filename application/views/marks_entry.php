<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Evaluation Desk | Studiora Premium</title>
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

        /* Dark Selection Panel */
        .filter-panel { background: var(--forest-green); padding: 25px 40px; color: white; flex: 0 0 auto; }
        .filter-label { font-size: 0.65rem; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px; display: block; }
        .filter-select { background: rgba(255,255,255,0.05); border: 1px solid rgba(184, 149, 82, 0.4); color: white; border-radius: 12px; padding: 10px 15px; width: 100%; outline: none; transition: 0.3s; font-size: 0.9rem; }
        .filter-select:focus { border-color: var(--gold); background: rgba(255,255,255,0.1); }
        .filter-select option { background: #061e19; color: white; }

        /* Main Table Container */
        .main-container { flex: 1; padding: 30px 40px; overflow-y: auto; display: flex; flex-direction: column; }
        .evaluation-card { background: white; border-radius: 30px; box-shadow: 0 15px 50px rgba(0,0,0,0.03); border: none; padding: 0; overflow: hidden; display: flex; flex-direction: column; }
        
        /* Table Internal Styling */
        .table-header-tool { padding: 20px 30px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fff; }
        .search-inner { position: relative; width: 250px; }
        .search-inner i { position: absolute; left: 15px; top: 12px; color: var(--gold); font-size: 0.8rem; }
        .search-inner input { border-radius: 50px; padding: 8px 15px 8px 35px; border: 1px solid #eee; font-size: 0.8rem; width: 100%; }

        .table thead th { background: #fafafa; color: #888; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 30px; border: none; }
        .table tbody td { padding: 15px 30px; vertical-align: middle; border-bottom: 1px solid #f9f9f9; }

        /* Score Input Styling */
        .score-input { 
            width: 80px; height: 45px; border-radius: 12px; border: 2px solid #eee; 
            text-align: center; font-weight: 800; font-size: 1.1rem; color: var(--forest-green);
            transition: 0.3s; background: #fdfdfd;
        }
        .score-input:focus { border-color: var(--gold); background: #fffcf0; outline: none; box-shadow: 0 5px 15px rgba(184, 149, 82, 0.1); transform: scale(1.05); }

        .btn-authorize { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 15px; padding: 15px 60px; font-weight: 700; font-size: 1rem; transition: 0.3s; letter-spacing: 1px; }
        .btn-authorize:hover { background: var(--gold); color: white; transform: translateY(-3px); box-shadow: 0 10px 30px rgba(184, 149, 82, 0.3); }

        /* Empty State */
        .empty-state { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #ccc; }
        .empty-state i { font-size: 5rem; margin-bottom: 20px; opacity: 0.3; color: var(--gold); }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('exams') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Evaluation Desk</h2>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge" style="background: rgba(184, 149, 82, 0.1); color: var(--gold); padding: 10px 15px; border-radius: 10px;">
                <i class="fa fa-shield-halved me-2"></i>Secure Entry Mode
            </span>
        </div>
    </div>

    <!-- Dark Filter Panel -->
    <div class="filter-panel shadow-lg">
        <form action="<?= site_url('exams/marks_entry') ?>" method="GET" class="row g-4">
            <div class="col-md-3">
                <label class="filter-label">Examination Name</label>
                <select name="exam_id" class="filter-select">
                    <?php foreach($exams as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= (isset($_GET['exam_id']) && $_GET['exam_id'] == $e['id']) ? 'selected' : '' ?>><?= $e['exam_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="filter-label">Target Class</label>
                <select name="class_id" class="filter-select">
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (isset($_GET['class_id']) && $_GET['class_id'] == $c['id']) ? 'selected' : '' ?>><?= $c['class_name'] ?> - <?= $c['section_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="filter-label">Subject Portal</label>
                <select name="subject_id" class="filter-select">
                    <?php foreach($subjects as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= (isset($_GET['subject_id']) && $_GET['subject_id'] == $s['id']) ? 'selected' : '' ?>><?= $s['subject_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn w-100 py-2 fw-bold" style="background: var(--gold); color: var(--forest-green); border-radius: 12px; border: none;">
                    Access Student Batch
                </button>
            </div>
        </form>
    </div>

    <!-- Main Content Area -->
    <div class="main-container">
        <?php if(isset($students)): ?>
            <div class="evaluation-card">
                <div class="table-header-tool">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: var(--forest-green);">Student Batch List</h5>
                        <small class="text-muted">Recording scores for max 100 points</small>
                    </div>
                    <div class="search-inner">
                        <i class="fa fa-search"></i>
                        <input type="text" id="batchSearch" placeholder="Find student..." onkeyup="filterBatch()">
                    </div>
                </div>

                <form action="<?= site_url('exams/save_marks') ?>" method="POST">
                    <input type="hidden" name="exam_id" value="<?= $_GET['exam_id'] ?>">
                    <input type="hidden" name="subject_id" value="<?= $_GET['subject_id'] ?>">
                    
                    <div style="max-height: 400px; overflow-y: auto;">
                        <table class="table align-middle" id="batchTable">
                            <thead>
                                <tr>
                                    <th>Adm ID</th>
                                    <th>Full Name</th>
                                    <th>Enrollment Status</th>
                                    <th class="text-center">Academic Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($students as $s): ?>
                                <tr>
                                    <td class="fw-bold text-muted">#<?= $s['adm_no'] ?></td>
                                    <td>
                                        <div class="fw-bold" style="color: var(--forest-green);"><?= $s['first_name'] ?> <?= $s['last_name'] ?></div>
                                    </td>
                                    <td><span class="badge bg-light text-success border border-success border-opacity-25 px-3">Active</span></td>
                                    <td class="text-center">
                                        <input type="hidden" name="student_id[]" value="<?= $s['id'] ?>">
                                        <input type="number" name="marks[<?= $s['id'] ?>]" class="score-input" placeholder="--" min="0" max="100" required>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center py-4 border-top bg-light bg-opacity-50">
                        <button type="submit" class="btn btn-authorize shadow">
                            <i class="fa fa-check-double me-2"></i>Authorize & Save Scores
                        </button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa fa-feather-pointed"></i>
                <h4 class="fw-bold" style="color: var(--forest-green);">Ready to Evaluate?</h4>
                <p>Please select the Examination, Class, and Subject above to begin marking.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Real-time table search
        function filterBatch() {
            let input = document.getElementById("batchSearch").value.toUpperCase();
            let rows = document.getElementById("batchTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                let text = rows[i].innerText.toUpperCase();
                rows[i].style.display = text.includes(input) ? "" : "none";
            }
        }
    </script>
</body>
</html>