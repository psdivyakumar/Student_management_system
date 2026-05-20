<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Academic Structure | Studiora Premium</title>
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

        .search-container { position: relative; width: 300px; }
        .search-container input { border-radius: 50px; padding: 10px 20px 10px 40px; border: 1px solid #eee; background: #fafafa; font-size: 0.85rem; }
        .search-container i { position: absolute; left: 15px; top: 13px; color: var(--gold); }

        .main-content { flex: 1; padding: 25px 40px; overflow-y: auto; display: grid; grid-template-columns: 350px 1fr; gap: 30px; }
        
        /* Side Form Styling */
        .glass-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; height: fit-content; }
        .form-label { font-size: 0.75rem; font-weight: 700; color: var(--gold); text-transform: uppercase; margin-bottom: 5px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #eef0f2; padding: 10px; font-size: 0.9rem; margin-bottom: 15px; }

        /* Table Area */
        .table thead th { background: var(--forest-green); color: var(--gold); padding: 15px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; border: none; }
        .badge-capacity { background: rgba(184, 149, 82, 0.1); color: var(--gold); padding: 5px 12px; border-radius: 50px; font-weight: 700; font-size: 0.75rem; }

        .btn-royal { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 12px; padding: 10px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-royal:hover { background: var(--gold); color: white; }

        .btn-action { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; transition: 0.2s; font-size: 0.8rem; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-schedule { background: rgba(184, 149, 82, 0.1); color: var(--gold); }
        .btn-view:hover, .btn-schedule:hover { background: var(--forest-green); color: white; }

        .modal-content { border-radius: 30px; border: none; overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); padding: 20px 30px; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Academic Structure</h2>
        </div>
        <div class="search-container">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search classes or teachers..." onkeyup="searchTable()">
        </div>
    </div>

    <div class="main-content">
        <!-- Add Class Form (Left Sidebar style) -->
        <div class="glass-card">
            <h5 class="fw-bold mb-4" style="color: var(--forest-green);">Assign New Class</h5>
            <form action="<?= site_url('academic/classes') ?>" method="POST">
                <label class="form-label">Class Title</label>
                <input type="text" name="class_name" class="form-control" placeholder="e.g. Class 10" required>
                
                <label class="form-label">Section Name</label>
                <input type="text" name="section_name" class="form-control" placeholder="e.g. A" required>
                
                <label class="form-label">Assign Class Teacher</label>
                <select name="teacher_id" class="form-select">
                    <?php foreach($teachers as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= $t['first_name'].' '.$t['last_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label class="form-label">Seating Capacity</label>
                <input type="number" name="capacity" class="form-control" value="40">
                
                <button class="btn btn-royal mt-2 shadow-sm">Save Academic Class</button>
            </form>
        </div>

        <!-- Class List (Right side) -->
        <div class="glass-card">
            <table class="table align-middle" id="dataTable">
                <thead>
                    <tr>
                        <th>Class & Section</th>
                        <th>Class Teacher</th>
                        <th>Capacity</th>
                        <th class="text-end">Management</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($classes as $c): ?>
                    <tr>
                        <td class="fw-bold" style="color: var(--forest-green);"><?= $c['class_name'] ?> - <?= $c['section_name'] ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?= $c['first_name'] ?>&background=b89552&color=fff" class="rounded-circle me-2" width="30">
                                <span><?= $c['first_name'].' '.$c['last_name'] ?></span>
                            </div>
                        </td>
                        <td><span class="badge-capacity"><?= $c['capacity'] ?> Students</span></td>
                        <td class="text-end">
                            <!-- EYE ICON FOR DETAILS -->
                            <button class="btn-action btn-view me-1" title="View Details" onclick='viewClass(<?= json_encode($c) ?>)'><i class="fa fa-eye"></i></button>
                            <!-- SCHEDULE ICON -->
                            <a href="<?= site_url('academic/timetable/'.$c['id']) ?>" class="btn-action btn-schedule me-1" title="Weekly Timetable"><i class="fa fa-calendar-alt"></i></a>
                            <!-- DELETE -->
                            <button class="btn-action bg-danger bg-opacity-10 text-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Class Details Modal -->
    <div class="modal fade" id="classModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Class Information Card</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" style="background: var(--cream);">
                    <div class="text-center mb-4">
                        <div class="display-4 fw-bold" id="det_title" style="color: var(--forest-green);"></div>
                        <p class="text-muted">Academic Session 2024-25</p>
                    </div>
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <label class="form-label">Class Teacher</label>
                            <div id="det_teacher" class="fw-bold"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total Capacity</label>
                            <div id="det_capacity" class="fw-bold"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toUpperCase();
            let rows = document.getElementById("dataTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = rows[i].innerText.toUpperCase().includes(input) ? "" : "none";
            }
        }
        function viewClass(data) {
            document.getElementById('det_title').innerText = data.class_name + ' (' + data.section_name + ')';
            document.getElementById('det_teacher').innerText = data.first_name + ' ' + data.last_name;
            document.getElementById('det_capacity').innerText = data.capacity + ' Seats';
            new bootstrap.Modal(document.getElementById('classModal')).show();
        }
    </script>
</body>
</html>