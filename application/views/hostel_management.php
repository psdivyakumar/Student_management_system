<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hostel Residency | Studiora Premium</title>
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
        .stat-pill { background: white; padding: 8px 18px; border-radius: 50px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border: 1px solid rgba(184, 149, 82, 0.2); font-size: 0.8rem; font-weight: 600; color: var(--forest-green); }

        /* Main Layout */
        .main-container { flex: 1; padding: 0 40px 30px 40px; overflow-y: auto; display: grid; grid-template-columns: 350px 1fr; gap: 30px; }
        
        /* Cards */
        .glass-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; height: fit-content; }
        .form-label { font-size: 0.65rem; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #eef0f2; padding: 10px; font-size: 0.9rem; margin-bottom: 12px; background: #fbfcfd; }

        /* Table Area */
        .table thead th { background: var(--forest-green); color: var(--gold); padding: 15px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; border: none; }
        .table tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f9f9f9; }
        
        .occupancy-badge { padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; background: rgba(184, 149, 82, 0.1); color: var(--gold); }

        /* Buttons */
        .btn-royal { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 12px; padding: 10px; font-weight: 700; width: 100%; transition: 0.3s; margin-top: 5px; }
        .btn-royal:hover { background: var(--gold); color: white; }

        .btn-action { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; font-size: 0.85rem; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-view:hover { background: var(--forest-green); color: white; }

        /* Modal */
        .modal-content { border-radius: 30px; border: none; background: var(--cream); overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); padding: 25px; border: none; }
        .detail-item { background: white; padding: 15px; border-radius: 15px; margin-bottom: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
    </style>
</head>
<body>

    <!-- Top Header -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle shadow-sm"><i class="fa fa-arrow-left"></i></a>
            <h2>Hostel Residency</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fa fa-search position-absolute" style="left:15px; top:12px; color:var(--gold);"></i>
                <input type="text" id="hostelSearch" class="form-control ps-5 mb-0" placeholder="Search residents..." style="border-radius:50px; width:250px;" onkeyup="filterHostel()">
            </div>
            <button class="btn btn-dark px-4 py-2" style="background: var(--forest-green); color: var(--gold); border-radius: 12px; border: 1px solid var(--gold); font-weight: 600;" data-bs-toggle="modal" data-bs-target="#addRoomModal">+ Add Inventory</button>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="stats-row">
        <div class="stat-pill"><i class="fa fa-building me-2"></i> Buildings: <?= count($hostels) ?></div>
        <div class="stat-pill"><i class="fa fa-bed me-2"></i> Active Residencies: <?= count($allocations) ?></div>
        <div class="stat-pill text-success fw-bold">System Secure</div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        
        <!-- Left Column: Actions -->
        <div class="d-flex flex-column gap-3">
            <!-- Add Building Card -->
            <div class="glass-card">
                <h6 class="fw-bold mb-3" style="color: var(--forest-green);">Register Building</h6>
                <form action="<?= site_url('hostel/add_building') ?>" method="POST">
                    <label class="form-label">Hostel Name</label>
                    <input type="text" name="hostel_name" class="form-control" placeholder="e.g. Royal Oaks Hall" required>
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option>Boys</option>
                        <option>Girls</option>
                    </select>
                    <label class="form-label">Head Warden</label>
                    <input type="text" name="warden_name" class="form-control" placeholder="Full Name">
                    <button class="btn btn-royal shadow-sm">Save Building</button>
                </form>
            </div>

            <!-- Allocation Card -->
            <div class="glass-card">
                <h6 class="fw-bold mb-3" style="color: var(--forest-green);">Allocate Room</h6>
                <form action="<?= site_url('hostel/allocate') ?>" method="POST">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-select">
                        <?php foreach($students as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['first_name'] ?> (ID: #<?= $s['adm_no'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label">Available Room</label>
                    <select name="room_id" class="form-select">
                        <?php foreach($rooms as $r): if($r['available_beds'] > 0): ?>
                            <option value="<?= $r['id'] ?>"><?= $r['hostel_name'] ?> - Rm <?= $r['room_no'] ?></option>
                        <?php endif; endforeach; ?>
                    </select>
                    <button class="btn btn-royal shadow-sm" style="background: var(--gold); border-color: var(--gold); color: white;">Confirm Residence</button>
                </form>
            </div>
        </div>

        <!-- Right Column: Data Table -->
        <div class="glass-card">
            <h6 class="fw-bold mb-4" style="color: var(--forest-green);">Active Resident Ledger</h6>
            <table class="table align-middle" id="hostelTable">
                <thead>
                    <tr>
                        <th>Resident Student</th>
                        <th>Room Location</th>
                        <th>Fiscal Terms (Rent + Food)</th>
                        <th>Status</th>
                        <th class="text-end">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allocations as $a): ?>
                    <tr>
                        <td class="fw-bold" style="color: var(--forest-green);"><?= $a['first_name'] ?></td>
                        <td>
                            <div class="fw-bold small"><?= $a['room_no'] ?></div>
                            <small class="text-muted">Assigned on <?= date('d M, Y', strtotime($a['allocation_date'])) ?></small>
                        </td>
                        <td>
                            <div class="fw-bold">₹<?= number_format($a['rent'] + $a['food_cost']) ?></div>
                            <small class="text-muted small">Per Billing Cycle</small>
                        </td>
                        <td><span class="occupancy-badge">RESIDING</span></td>
                        <td class="text-end">
                            <button class="btn-action btn-view" onclick='viewAllocation(<?= json_encode($a) ?>)'><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Room Inventory Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Add Room Inventory</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= site_url('hostel/add_room') ?>" method="POST" class="p-4">
                    <label class="form-label">Parent Building</label>
                    <select name="hostel_id" class="form-select mb-3">
                        <?php foreach($hostels as $h): ?>
                            <option value="<?= $h['id'] ?>"><?= $h['hostel_name'] ?> (<?= $h['type'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="row">
                        <div class="col-6"><label class="form-label">Room No.</label><input type="text" name="room_no" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">Bed Capacity</label><input type="number" name="total_beds" class="form-control" value="1"></div>
                        <div class="col-6"><label class="form-label">Monthly Rent (₹)</label><input type="number" name="rent" class="form-control" placeholder="0.00"></div>
                        <div class="col-6"><label class="form-label">Food Charges (₹)</label><input type="number" name="food_cost" class="form-control" placeholder="0.00"></div>
                    </div>
                    <button class="btn btn-royal shadow mt-3">Register Room</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Allocation Detail Modal (Eye Icon) -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Residence Information Card</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="detail-item d-flex justify-content-between"><span>Resident Name:</span> <strong id="det_name"></strong></div>
                    <div class="detail-item d-flex justify-content-between"><span>Room Number:</span> <strong id="det_room"></strong></div>
                    <div class="detail-item d-flex justify-content-between"><span>Allocation Date:</span> <strong id="det_date"></strong></div>
                    <hr>
                    <div class="detail-item d-flex justify-content-between text-success"><span>Monthly Rental:</span> <strong id="det_rent"></strong></div>
                    <div class="detail-item d-flex justify-content-between text-primary"><span>Fooding Cost:</span> <strong id="det_food"></strong></div>
                    <div class="detail-item d-flex justify-content-between" style="background: var(--forest-green); color: var(--gold);"><span>Total Monthly Due:</span> <strong id="det_total"></strong></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterHostel() {
            let input = document.getElementById("hostelSearch").value.toUpperCase();
            let rows = document.getElementById("hostelTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = rows[i].innerText.toUpperCase().includes(input) ? "" : "none";
            }
        }
        function viewAllocation(data) {
            document.getElementById('det_name').innerText = data.first_name;
            document.getElementById('det_room').innerText = data.room_no;
            document.getElementById('det_date').innerText = data.allocation_date;
            document.getElementById('det_rent').innerText = '₹' + parseFloat(data.rent).toLocaleString();
            document.getElementById('det_food').innerText = '₹' + parseFloat(data.food_cost).toLocaleString();
            document.getElementById('det_total').innerText = '₹' + (parseFloat(data.rent) + parseFloat(data.food_cost)).toLocaleString();
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    </script>
</body>
</html>