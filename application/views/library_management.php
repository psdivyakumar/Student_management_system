<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Knowledge Treasury | Studiora Premium</title>
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
        .main-container { flex: 1; padding: 0 40px 30px 40px; overflow-y: auto; display: grid; grid-template-columns: 320px 1fr; gap: 25px; }
        
        /* Cards */
        .glass-card { background: white; border-radius: 25px; padding: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: none; height: fit-content; }
        .form-label { font-size: 0.65rem; font-weight: 800; color: var(--gold); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .form-control, .form-select { border-radius: 10px; border: 1px solid #eef0f2; padding: 8px 12px; font-size: 0.85rem; margin-bottom: 10px; background: #fbfcfd; }

        /* Table Area */
        .table thead th { background: var(--forest-green); color: var(--gold); padding: 12px 15px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; border: none; }
        .table tbody td { padding: 12px 15px; vertical-align: middle; border-bottom: 1px solid #f9f9f9; font-size: 0.85rem; }
        
        .stock-badge { padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; }
        .bg-instock { background: rgba(25, 135, 84, 0.1); color: #198754; }
        .bg-outstock { background: rgba(220, 53, 69, 0.1); color: #dc3545; }

        /* Buttons */
        .btn-royal { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); border-radius: 10px; padding: 8px; font-weight: 700; width: 100%; transition: 0.3s; font-size: 0.85rem; }
        .btn-royal:hover { background: var(--gold); color: white; }

        .btn-action { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: none; font-size: 0.8rem; }
        .btn-view { background: rgba(6, 30, 25, 0.1); color: var(--forest-green); }
        .btn-view:hover { background: var(--forest-green); color: white; }

        /* Book Detail Modal */
        .modal-content { border-radius: 30px; border: none; background: var(--cream); overflow: hidden; }
        .modal-header { background: var(--forest-green); color: var(--gold); padding: 20px; border: none; }
        .book-archive-card { background: white; border-radius: 20px; padding: 25px; border-left: 5px solid var(--gold); }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <a href="<?= site_url('dashboard') ?>" class="back-circle shadow-sm"><i class="fa fa-arrow-left"></i></a>
            <h2>Knowledge Treasury</h2>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fa fa-search position-absolute" style="left:15px; top:12px; color:var(--gold); font-size: 0.8rem;"></i>
                <input type="text" id="librarySearch" class="form-control ps-5 mb-0" placeholder="Search catalog..." style="border-radius:50px; width:220px; height: 38px;" onkeyup="filterLibrary()">
            </div>
            <div class="stat-pill border-0 bg-dark text-white py-2 shadow-sm">
                <i class="fa fa-book-open me-2 text-gold"></i>Librarian Console
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-pill"><i class="fa fa-bookmark me-2 text-gold"></i> Total Volumes: <?= count($books) ?></div>
        <div class="stat-pill"><i class="fa fa-exchange-alt me-2 text-gold"></i> Active Loans: <?= count($issued) ?></div>
    </div>

    <!-- Layout -->
    <div class="main-container">
        
        <!-- Side Actions -->
        <div class="d-flex flex-column gap-3">
            <div class="glass-card">
                <h6 class="fw-bold mb-3 small" style="color: var(--forest-green);"><i class="fa fa-plus-circle me-2"></i>New Accession</h6>
                <form action="<?= site_url('library/add_book') ?>" method="POST">
                    <label class="form-label">Book Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Entry title" required>
                    <label class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Full name">
                    <label class="form-label">Classification</label>
                    <select name="category" class="form-select">
                        <option>Academic</option><option>Fiction</option><option>Reference</option>
                    </select>
                    <label class="form-label">Rack Location</label>
                    <input type="text" name="rack_no" class="form-control" placeholder="e.g. Shelf-B1">
                    <button class="btn btn-royal shadow-sm">Catalog Volume</button>
                </form>
            </div>

            <div class="glass-card">
                <h6 class="fw-bold mb-3 small" style="color: var(--forest-green);"><i class="fa fa-hand-holding me-2"></i>Issue Desk</h6>
                <form action="<?= site_url('library/issue') ?>" method="POST">
                    <label class="form-label">Select Volume</label>
                    <select name="book_id" class="form-select">
                        <?php foreach($books as $b): if($b['available_qty'] > 0): ?>
                            <option value="<?= $b['id'] ?>"><?= $b['title'] ?></option>
                        <?php endif; endforeach; ?>
                    </select>
                    <label class="form-label">Recipient Student</label>
                    <select name="student_id" class="form-select">
                        <?php foreach($students as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['first_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control">
                    <button class="btn btn-royal shadow-sm" style="background: var(--gold); border-color: var(--gold); color: white;">Authorize Issue</button>
                </form>
            </div>
        </div>

        <!-- Master Tables -->
        <div class="d-flex flex-column gap-3">
            <div class="glass-card">
                <h6 class="fw-bold mb-3 small" style="color: var(--forest-green);">Accession Catalog</h6>
                <table class="table align-middle" id="catalogTable">
                    <thead>
                        <tr>
                            <th>Book Particulars</th>
                            <th>Author</th>
                            <th>Loc.</th>
                            <th>Status</th>
                            <th class="text-end">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($books as $b): ?>
                        <tr>
                            <td class="fw-bold" style="color: var(--forest-green);"><?= $b['title'] ?></td>
                            <td class="text-muted small"><?= $b['author'] ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $b['rack_no'] ?></span></td>
                            <td>
                                <span class="stock-badge <?= ($b['available_qty']>0)?'bg-instock':'bg-outstock' ?>">
                                    <?= $b['available_qty'] ?> / <?= $b['quantity'] ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn-action btn-view" onclick='viewBook(<?= json_encode($b) ?>)'><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="glass-card">
                <h6 class="fw-bold mb-3 small" style="color: var(--forest-green);">Circulation Register</h6>
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Borrowed Volume</th>
                            <th>Return Due</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($issued as $i): if($i['status'] == 'Issued'): ?>
                        <tr>
                            <td class="fw-bold small"><?= $i['first_name'] ?></td>
                            <td class="small"><?= $i['book_title'] ?></td>
                            <td class="text-danger fw-bold small"><?= date('d M', strtotime($i['due_date'])) ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('library/return_item/'.$i['id'].'/'.$i['book_id']) ?>" class="btn btn-sm btn-outline-dark" style="font-size: 0.65rem; border-radius: 6px;">Return</a>
                            </td>
                        </tr>
                        <?php endif; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Eye Icon Detail Modal -->
    <div class="modal fade" id="bookModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title font-serif">Volume Archive Card</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="book-archive-card">
                        <div class="mb-3">
                            <label class="form-label">Classification</label>
                            <div id="det_cat" class="badge bg-dark"></div>
                        </div>
                        <h4 id="det_title" class="fw-bold mb-1" style="color: var(--forest-green);"></h4>
                        <p id="det_author" class="text-gold fw-bold small mb-4"></p>
                        <div class="row">
                            <div class="col-6 border-end">
                                <label class="form-label">Rack Location</label>
                                <div id="det_rack" class="fw-bold"></div>
                            </div>
                            <div class="col-6 ps-4">
                                <label class="form-label">Stock Status</label>
                                <div id="det_stock" class="fw-bold text-success"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterLibrary() {
            let input = document.getElementById("librarySearch").value.toUpperCase();
            let rows = document.getElementById("catalogTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = rows[i].innerText.toUpperCase().includes(input) ? "" : "none";
            }
        }
        function viewBook(data) {
            document.getElementById('det_title').innerText = data.title;
            document.getElementById('det_author').innerText = 'By ' + data.author;
            document.getElementById('det_cat').innerText = data.category;
            document.getElementById('det_rack').innerText = data.rack_no;
            document.getElementById('det_stock').innerText = data.available_qty + ' units available';
            new bootstrap.Modal(document.getElementById('bookModal')).show();
        }
    </script>
</body>
</html>