<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Register | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        
        /* Header & Navigation */
        .page-header { background: white; padding: 15px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; flex: 0 0 auto; }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .back-circle:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; margin-left: 15px; font-size: 1.8rem; }

        .main-content { flex: 1; padding: 25px 40px; overflow-y: auto; }
        
        /* Selection Filter Card */
        .filter-card { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.02); margin-bottom: 25px; border: 1px solid rgba(184, 149, 82, 0.1); }
        .form-label { font-size: 0.7rem; font-weight: 800; color: var(--gold); text-transform: uppercase; margin-bottom: 5px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #eef0f2; padding: 10px; font-size: 0.9rem; }

        /* Attendance Table Card */
        .glass-table-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; }
        .table thead th { background: var(--forest-green); color: var(--gold); padding: 15px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; border: none; }
        
        /* Custom Attendance Pills (Radio Replacement) */
        .attendance-opt { display: none; }
        .attendance-label { 
            padding: 8px 20px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; 
            cursor: pointer; transition: 0.3s; border: 1px solid #eee; margin-right: 5px; color: #888;
        }
        
        /* Present - Green */
        .opt-p:checked + .label-p { background: #d1e7dd; color: #0f5132; border-color: #badbcc; }
        /* Absent - Red */
        .opt-a:checked + .label-a { background: #f8d7da; color: #842029; border-color: #f5c2c7; }
        /* Late - Yellow */
        .opt-l:checked + .label-l { background: #fff3cd; color: #664d03; border-color: #ffecb5; }

        .btn-save-attendance { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 15px; padding: 12px 40px; font-weight: 700; transition: 0.3s; }
        .btn-save-attendance:hover { background: var(--gold); color: white; box-shadow: 0 10px 20px rgba(184, 149, 82, 0.2); }

        .empty-state { text-align: center; padding: 50px; color: #aaa; }
        .empty-state i { font-size: 4rem; color: var(--cream); margin-bottom: 15px; text-shadow: 1px 1px 0 #eee; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Attendance Register</h2>
        </div>
        <div class="text-muted small fw-medium">
            <i class="fa fa-calendar-alt me-2 text-gold"></i> <?= date('l, d F Y') ?>
        </div>
    </div>

    <div class="main-content">
        <!-- Step 1: Selection Filter -->
        <div class="filter-card">
            <form action="<?= site_url('attendance') ?>" method="GET" class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label">Select Date</label>
                    <input type="date" name="date" class="form-control" value="<?= isset($selected_date) ? $selected_date : date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Academic Class</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- Choose Class --</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= (isset($selected_class) && $selected_class == $c['id']) ? 'selected' : '' ?>>
                                <?= $c['class_name'] ?> - Section <?= $c['section_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 py-2" style="background: var(--forest-green); border-radius: 12px; border: 1px solid var(--gold); color: var(--gold); font-weight: 600;">
                        Fetch List
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 2: Marking Table -->
        <?php if($students): ?>
        <div class="glass-table-card">
            <form action="<?= site_url('attendance/save') ?>" method="POST">
                <input type="hidden" name="attendance_date" value="<?= $selected_date ?>">
                <input type="hidden" name="class_id" value="<?= $selected_class ?>">

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th width="100">Adm ID</th>
                            <th>Student Name</th>
                            <th class="text-center">Attendance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $s): ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?= $s['adm_no'] ?></td>
                            <td>
                                <div class="fw-bold" style="color: var(--forest-green);"><?= $s['first_name'] ?> <?= $s['last_name'] ?></div>
                                <small class="text-muted">Roll No: <?= $s['roll_no'] ?></small>
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="student_id[]" value="<?= $s['id'] ?>">
                                
                                <input type="radio" class="attendance-opt opt-p" name="status[<?= $s['id'] ?>]" id="p<?= $s['id'] ?>" value="Present" checked>
                                <label class="attendance-label label-p" for="p<?= $s['id'] ?>">Present</label>

                                <input type="radio" class="attendance-opt opt-a" name="status[<?= $s['id'] ?>]" id="a<?= $s['id'] ?>" value="Absent">
                                <label class="attendance-label label-a" for="a<?= $s['id'] ?>">Absent</label>

                                <input type="radio" class="attendance-opt opt-l" name="status[<?= $s['id'] ?>]" id="l<?= $s['id'] ?>" value="Late">
                                <label class="attendance-label label-l" for="l<?= $s['id'] ?>">Late</label>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-save-attendance shadow">Submit Daily Register</button>
                </div>
            </form>
        </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa fa-clipboard-check"></i>
                <h5>Select a class to begin</h5>
                <p class="small">Choose an academic class and date above to load the student list.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>