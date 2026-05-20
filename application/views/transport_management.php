<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transit & Logistics | Studiora Premium</title>
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
        
        .route-badge { background: rgba(184, 149, 82, 0.1); color: var(--gold); padding: 4px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(184, 149, 82, 0.2); }

        /* Buttons */
        .btn-royal { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 12px; padding: 10px; font-weight: 700; width: 100%; transition: 0.3s; margin-top: 5px; }
        .btn-royal:hover { background: var(--gold); color: white; }

        .btn-action { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; font-size: 0.85rem; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-view:hover { background: var(--forest-green); color: white; }

        /* Digital Transit Pass Modal */
        .modal-content { border-radius: 30px; border: none; background: var(--cream); overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); padding: 25px; border: none; }
        .pass-box { background: white; border-radius: 20px; padding: 25px; border: 2px solid var(--gold); position: relative; }
        .pass-box::after { content: "TRANSIT"; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 4rem; font-weight: 900; color: rgba(0,0,0,0.03); z-index: 0; pointer-events: none; }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle shadow-sm"><i class="fa fa-arrow-left"></i></a>
            <h2>Transit & Logistics</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fa fa-search position-absolute" style="left:15px; top:12px; color:var(--gold);"></i>
                <input type="text" id="transitSearch" class="form-control ps-5 mb-0" placeholder="Search pass holder..." style="border-radius:50px; width:250px;" onkeyup="filterTransit()">
            </div>
            <button class="btn btn-dark px-4 py-2" style="background: var(--forest-green); color: var(--gold); border-radius: 12px; border: 1px solid var(--gold); font-weight: 600;" data-bs-toggle="modal" data-bs-target="#addRouteModal">+ Create Route</button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="stat-pill"><i class="fa fa-bus me-2 text-gold"></i> Fleet Size: <?= count($vehicles) ?></div>
        <div class="stat-pill"><i class="fa fa-route me-2 text-gold"></i> Active Routes: <?= count($routes) ?></div>
        <div class="stat-pill"><i class="fa fa-id-card me-2 text-gold"></i> Total Members: <?= count($members) ?></div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        
        <!-- Left Sidebar: Operations -->
        <div class="d-flex flex-column gap-3">
            <!-- 1. Add Vehicle -->
            <div class="glass-card">
                <h6 class="fw-bold mb-3" style="color: var(--forest-green);"><i class="fa fa-plus-circle me-2"></i>Register Vehicle</h6>
                <form action="<?= site_url('transport/add_vehicle') ?>" method="POST">
                    <label class="form-label">Vehicle Plate No.</label>
                    <input type="text" name="vehicle_no" class="form-control" placeholder="e.g. TN-37-AB-1234" required>
                    <label class="form-label">Assigned Driver</label>
                    <input type="text" name="driver_name" class="form-control" placeholder="Name">
                    <label class="form-label">Seating Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="40">
                    <button class="btn btn-royal shadow-sm">Save to Fleet</button>
                </form>
            </div>

            <!-- 2. Assign Student -->
            <div class="glass-card">
                <h6 class="fw-bold mb-3" style="color: var(--forest-green);"><i class="fa fa-user-tag me-2"></i>Member Assignment</h6>
                <form action="<?= site_url('transport/assign_student') ?>" method="POST">
                    <label class="form-label">Student Name</label>
                    <select name="student_id" class="form-select">
                        <?php foreach($students as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['first_name'] ?> (ID: #<?= $s['adm_no'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label">Operational Route</label>
                    <select name="route_id" class="form-select">
                        <?php foreach($routes as $r): ?>
                            <option value="<?= $r['id'] ?>"><?= $r['route_title'] ?> (₹<?= $r['fare'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-royal shadow-sm" style="background: var(--gold); border-color: var(--gold); color: white;">Authorize Assignment</button>
                </form>
            </div>
        </div>

        <!-- Right Content: Transit Ledger -->
        <div class="glass-card">
            <h6 class="fw-bold mb-4" style="color: var(--forest-green);">Master Transit Ledger</h6>
            <table class="table align-middle" id="transitTable">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        <th>Assigned Route</th>
                        <th>Monthly Fare</th>
                        <th>Status</th>
                        <th class="text-end">Pass View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($members as $m): ?>
                    <tr>
                        <td class="fw-bold" style="color: var(--forest-green);"><?= $m['first_name'] ?></td>
                        <td><span class="route-badge"><?= $m['route_title'] ?></span></td>
                        <td><div class="fw-bold">₹<?= number_format($m['fare']) ?></div></td>
                        <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">AUTHORISED</span></td>
                        <td class="text-end">
                            <button class="btn-action btn-view" onclick='viewPass(<?= json_encode($m) ?>)'><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Route Modal -->
    <div class="modal fade" id="addRouteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Add Transit Route</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= site_url('transport/add_route') ?>" method="POST" class="p-4">
                    <label class="form-label">Route Title</label>
                    <input type="text" name="route_title" class="form-control mb-3" placeholder="e.g. North Coimbatore Express" required>
                    <label class="form-label">Monthly Fare (₹)</label>
                    <input type="number" name="fare" class="form-control mb-4" placeholder="0.00" required>
                    <button class="btn btn-royal shadow">Save Route Config</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Digital Pass Modal (Eye Icon) -->
    <div class="modal fade" id="passModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Digital Transit Pass</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" style="background: var(--cream);">
                    <div class="pass-box">
                        <div class="row align-items-center">
                            <div class="col-4 border-end">
                                <img src="https://ui-avatars.com/api/?name=Member&background=061e19&color=b89552" class="rounded-3 w-100 shadow-sm">
                            </div>
                            <div class="col-8 ps-3" style="position: relative; z-index: 1;">
                                <h5 class="fw-bold mb-1" id="p_name" style="color: var(--forest-green);"></h5>
                                <p class="small text-gold fw-bold mb-3">STUDIORA TRANSIT HOLDER</p>
                                <div class="mb-2"><small class="text-muted text-uppercase fw-bold" style="font-size: 0.6rem;">Route Title</small><div id="p_route" class="fw-bold"></div></div>
                                <div><small class="text-muted text-uppercase fw-bold" style="font-size: 0.6rem;">Monthly Fare Due</small><div id="p_fare" class="fw-bold text-success"></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3 text-muted small">
                        <i class="fa fa-qrcode fa-3x mb-2 d-block opacity-25"></i>
                        Scannable secure transit credential.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterTransit() {
            let input = document.getElementById("transitSearch").value.toUpperCase();
            let rows = document.getElementById("transitTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                let text = rows[i].innerText.toUpperCase();
                rows[i].style.display = text.includes(input) ? "" : "none";
            }
        }
        function viewPass(data) {
            document.getElementById('p_name').innerText = data.first_name;
            document.getElementById('p_route').innerText = data.route_title;
            document.getElementById('p_fare').innerText = '₹' + parseFloat(data.fare).toLocaleString();
            new bootstrap.Modal(document.getElementById('passModal')).show();
        }
    </script>
</body>
</html>