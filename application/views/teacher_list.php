<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Directory | Studiora Premium</title>
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
        .search-container input { border-radius: 50px; padding: 10px 20px 10px 40px; border: 1px solid #eee; }
        .search-container i { position: absolute; left: 15px; top: 13px; color: var(--gold); }

        .main-content { flex: 1; padding: 25px 40px; overflow-y: auto; }
        .glass-table-card { background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
        
        .table thead th { background: var(--forest-green); color: var(--gold); padding: 15px; font-size: 0.7rem; text-transform: uppercase; border: none; }
        .teacher-img { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); }
        .subject-badge { background: rgba(184, 149, 82, 0.1); color: var(--gold); padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }

        .btn-action { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; transition: 0.2s; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-edit { background: rgba(184, 149, 82, 0.1); color: var(--gold); }

        .modal-content { border-radius: 30px; border: none; overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); padding: 20px 30px; }
        .detail-label { font-size: 0.65rem; font-weight: 800; color: var(--gold); text-transform: uppercase; }
        .detail-val { font-weight: 600; color: var(--forest-green); margin-bottom: 12px; }
    </style>
</head>
<body>

    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
            <h2>Faculty Directory</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="search-container me-3">
                <i class="fa fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search Faculty..." onkeyup="searchTable()">
            </div>
            <a href="<?= site_url('teachers/add') ?>" class="btn px-4" style="background: var(--forest-green); color: var(--gold); border-radius: 12px; font-weight: 600; border: 1px solid var(--gold);">+ Add Faculty</a>
        </div>
    </div>

    <div class="main-content">
        <div class="glass-table-card">
            <table class="table align-middle" id="dataTable">
                <thead>
                    <tr>
                        <th>Faculty Member</th>
                        <th>Emp ID</th>
                        <th>Specialization</th>
                        <th>Contact</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($teachers as $t): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?= $t['photo'] ? base_url('uploads/teachers/'.$t['photo']) : 'https://ui-avatars.com/api/?name='.$t['first_name'] ?>" class="teacher-img me-3">
                                <div><div class="fw-bold"><?= $t['first_name'].' '.$t['last_name'] ?></div><small class="text-muted"><?= $t['email'] ?></small></div>
                            </div>
                        </td>
                        <td>#<?= $t['emp_id'] ?></td>
                        <td><span class="subject-badge"><?= $t['subject'] ?></span></td>
                        <td><?= $t['phone'] ?></td>
                        <td class="text-end">
                            <button class="btn-action btn-view me-1" onclick='viewTeacher(<?= json_encode($t) ?>)'><i class="fa fa-eye"></i></button>
                            <a href="<?= site_url('teachers/edit/'.$t['id']) ?>" class="btn-action btn-edit me-1"><i class="fa fa-pen-nib"></i></a>
                            <a href="<?= site_url('teachers/delete/'.$t['id']) ?>" class="btn-action bg-danger bg-opacity-10 text-danger" onclick="return confirm('Remove record?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Teacher Detail Modal -->
    <div class="modal fade" id="teacherModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: 'Playfair Display';">Faculty Full Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" style="background: var(--cream);">
                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <img id="t_photo" src="" class="rounded-circle border border-4 border-white shadow mb-3" style="width:150px; height:150px; object-fit:cover;">
                            <h4 id="t_name" class="fw-bold mb-0"></h4>
                            <p id="t_sub_text" class="fw-bold small" style="color: var(--gold);"></p>
                        </div>
                        <div class="col-md-8 ps-4">
                            <div class="row">
                                <div class="col-6"><div class="detail-label">Employee ID</div><div id="t_id" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Qualification</div><div id="t_qual" class="detail-val"></div></div>
                                <div class="col-6"><div class="detail-label">Salary</div><div id="t_sal" class="detail-val text-success"></div></div>
                                <div class="col-6"><div class="detail-label">Joined On</div><div id="t_join" class="detail-val"></div></div>
                                <div class="col-12"><div class="detail-label">Address</div><div id="t_addr" class="detail-val small"></div></div>
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
        function viewTeacher(data) {
            document.getElementById('t_name').innerText = data.first_name + ' ' + data.last_name;
            document.getElementById('t_sub_text').innerText = data.subject;
            document.getElementById('t_id').innerText = '#' + data.emp_id;
            document.getElementById('t_qual').innerText = data.qualification;
            document.getElementById('t_sal').innerText = '₹' + data.salary;
            document.getElementById('t_join').innerText = data.joining_date;
            document.getElementById('t_addr').innerText = data.address;
            document.getElementById('t_photo').src = data.photo ? '<?= base_url('uploads/teachers/') ?>' + data.photo : 'https://ui-avatars.com/api/?name='+data.first_name;
            new bootstrap.Modal(document.getElementById('teacherModal')).show();
        }
    </script>
</body>
</html>