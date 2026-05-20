<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Directory | Studiora Premium</title>
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

        .main-content { flex: 1; padding: 25px 40px; overflow-y: auto; }
        .glass-table-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; }
        
        .table thead th { background: var(--forest-green); color: var(--gold); padding: 15px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; border: none; position: sticky; top: 0; }
        .student-img { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; border: 2px solid var(--gold); }

        .btn-action { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s; border: none; font-size: 0.8rem; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-edit { background: rgba(184, 149, 82, 0.1); color: var(--gold); }
        .btn-view:hover, .btn-edit:hover { background: var(--forest-green); color: white; }

        /* Modal Profile Style */
        .modal-content { border-radius: 30px; border: none; overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); border: none; padding: 20px 30px; }
        .detail-label { font-size: 0.65rem; font-weight: 800; color: var(--gold); text-transform: uppercase; margin-bottom: 2px; }
        .detail-val { font-weight: 600; color: var(--forest-green); margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Student Directory</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="search-container me-3">
                <i class="fa fa-search"></i>
                <input type="text" id="searchInput" placeholder="Quick Search..." onkeyup="searchTable()">
            </div>
            <a href="<?= site_url('students/add') ?>" class="btn px-4 py-2" style="background: var(--forest-green); color: var(--gold); border-radius: 12px; font-weight: 600; border: 1px solid var(--gold);">+ New Admission</a>
        </div>
    </div>

    <div class="main-content">
        <div class="glass-table-card">
            <table class="table align-middle" id="dataTable">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Admission ID</th>
                        <th>Class & Section</th>
                        <th>Guardian Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $s): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?= $s['photo'] ? base_url('uploads/students/'.$s['photo']) : 'https://ui-avatars.com/api/?name='.$s['first_name'] ?>" class="student-img me-3">
                                <div class="fw-bold"><?= $s['first_name'].' '.$s['last_name'] ?></div>
                            </div>
                        </td>
                        <td><span class="text-muted">#</span><?= $s['adm_no'] ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $s['class'] ?> - <?= $s['section'] ?></span></td>
                        <td><?= $s['father_name'] ?></td>
                        <td class="text-end">
                            <button class="btn-action btn-view me-1" onclick='viewDetails(<?= json_encode($s) ?>)'><i class="fa fa-eye"></i></button>
                            <a href="<?= site_url('students/edit/'.$s['id']) ?>" class="btn-action btn-edit me-1"><i class="fa fa-pen"></i></a>
                            <a href="<?= site_url('students/delete/'.$s['id']) ?>" class="btn-action bg-danger bg-opacity-10 text-danger" onclick="return confirm('Delete record?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Student Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: 'Playfair Display';">Student Profile Card</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" style="background: var(--cream);">
                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <img id="m_photo" src="" class="rounded-4 border border-4 border-white shadow mb-3" style="width:160px; height:180px; object-fit:cover;">
                            <h4 id="m_name" class="fw-bold mb-0"></h4>
                            <span id="m_id" class="badge bg-dark mt-2"></span>
                        </div>
                        <div class="col-md-8 ps-4">
                            <div class="row">
                                <div class="col-6"><div class="detail-label">Class / Section</div><div id="m_class" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Roll Number</div><div id="m_roll" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Gender</div><div id="m_gender" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Date of Birth</div><div id="m_dob" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Father's Name</div><div id="m_father" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Mother's Name</div><div id="m_mother" class="detail-val"></div></div>
                            </div>
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
        function viewDetails(data) {
            document.getElementById('m_name').innerText = data.first_name + ' ' + data.last_name;
            document.getElementById('m_id').innerText = '#' + data.adm_no;
            document.getElementById('m_class').innerText = data.class + ' (' + data.section + ')';
            document.getElementById('m_roll').innerText = data.roll_no || 'N/A';
            document.getElementById('m_gender').innerText = data.gender;
            document.getElementById('m_dob').innerText = data.dob;
            document.getElementById('m_father').innerText = data.father_name;
            document.getElementById('m_mother').innerText = data.mother_name;
            document.getElementById('m_photo').src = data.photo ? '<?= base_url('uploads/students/') ?>' + data.photo : 'https://ui-avatars.com/api/?name='+data.first_name;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }
    </script>
</body>
</html>