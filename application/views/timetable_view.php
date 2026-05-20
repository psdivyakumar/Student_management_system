<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Timetable | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; }
        
        .page-header { background: white; padding: 15px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between; }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .back-circle:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; margin-left: 15px; }

        .timetable-card { background: white; border-radius: 30px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); margin: 30px auto; max-width: 1100px; border: none; }
        
        .table-timetable { border-collapse: separate; border-spacing: 8px; }
        .table-timetable th { background: var(--forest-green); color: var(--gold); border-radius: 10px; padding: 15px; text-transform: uppercase; font-size: 0.75rem; text-align: center; }
        .table-timetable td { background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 12px; height: 100px; width: 150px; vertical-align: top; padding: 10px; transition: 0.2s; }
        .table-timetable td:hover { border-color: var(--gold); background: #fffcf8; }

        .subject-slot { background: var(--forest-green); color: var(--gold); border-radius: 8px; padding: 5px 8px; font-size: 0.75rem; font-weight: 700; margin-bottom: 5px; }
        .time-text { font-size: 0.65rem; color: #888; display: block; }
        .teacher-text { font-size: 0.7rem; color: var(--forest-green); font-weight: 500; }

        .day-label { background: var(--gold) !important; color: white !important; font-weight: 800; }
        .btn-add-slot { background: var(--gold); color: white; border-radius: 50px; padding: 8px 20px; font-weight: 600; border: none; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('academic/classes') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Weekly Schedule</h2>
        </div>
        <button class="btn-add-slot shadow-sm" data-bs-toggle="modal" data-bs-target="#addSlot"><i class="fa fa-plus me-2"></i>Add Time Slot</button>
    </div>

    <div class="container-fluid">
        <div class="timetable-card">
            <table class="table table-borderless table-timetable">
                <thead>
                    <tr>
                        <th style="width: 100px;">Day</th>
                        <th>Morning (09-11)</th>
                        <th>Mid-Day (11-01)</th>
                        <th>Afternoon (02-04)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    foreach($days as $day): ?>
                    <tr>
                        <th class="day-label align-middle"><?= $day ?></th>
                        <?php for($i=0; $i<3; $i++): ?>
                        <td>
                            <?php foreach($schedule as $s): ?>
                                <?php if($s['day'] == $day): ?>
                                    <div class="subject-slot text-truncate"><?= $s['subject_name'] ?></div>
                                    <span class="time-text"><i class="fa fa-clock me-1"></i><?= date('h:i A', strtotime($s['start_time'])) ?></span>
                                    <span class="teacher-text"><?= $s['first_name'] ?></span>
                                <?php endif; break; endforeach; ?>
                        </td>
                        <?php endfor; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for adding slot (Themed) -->
    <div class="modal fade" id="addSlot" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header" style="background: var(--forest-green); color: var(--gold);">
                    <h5 class="modal-title">Schedule New Period</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= site_url('academic/timetable/'.$class_id) ?>" method="POST" class="p-4" style="background: var(--cream);">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="small fw-bold text-uppercase" style="color: var(--gold);">Day</label>
                            <select name="day" class="form-select border-0 shadow-sm" style="border-radius: 10px;">
                                <option>Monday</option><option>Tuesday</option><option>Wednesday</option><option>Thursday</option><option>Friday</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="small fw-bold text-uppercase" style="color: var(--gold);">Subject</label>
                            <input type="text" name="subject_name" class="form-control border-0 shadow-sm" style="border-radius: 10px;" placeholder="e.g. Maths" required>
                        </div>
                    </div>
                    <label class="small fw-bold text-uppercase" style="color: var(--gold);">Assigned Teacher</label>
                    <select name="teacher_id" class="form-select border-0 shadow-sm mb-3" style="border-radius: 10px;">
                        <?php foreach($teachers as $t): ?>
                            <option value="<?= $t['id'] ?>"><?= $t['first_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="row">
                        <div class="col-6">
                            <label class="small fw-bold text-uppercase" style="color: var(--gold);">Start Time</label>
                            <input type="time" name="start_time" class="form-control border-0 shadow-sm" style="border-radius: 10px;">
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold text-uppercase" style="color: var(--gold);">End Time</label>
                            <input type="time" name="end_time" class="form-control border-0 shadow-sm" style="border-radius: 10px;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-royal mt-4 shadow">Add to Weekly Calendar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>