<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subject Management - STUDIORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <!-- Left Side: Add New Subject Form (Matches your Screenshot) -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">+ Add New Subject</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('subjects') ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Select Class</label>
                                <select name="class_id" class="form-select" required>
                                    <option value="">-- Choose Class --</option>
                                    <?php foreach($classes as $c): ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['class_name'] ?> - <?= $c['section_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject Name</label>
                                <input type="text" name="subject_name" class="form-control" placeholder="e.g. Mathematics" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject Code (Optional)</label>
                                <input type="text" name="subject_code" class="form-control" placeholder="e.g. MTH-101">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Syllabus Details</label>
                                <textarea name="syllabus" class="form-control" rows="3" placeholder="Enter topics covered..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save Subject</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Subject List Table -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 text-primary">Subject List</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Class</th>
                                    <th>Subject Name</th>
                                    <th>Code</th>
                                    <th>Syllabus</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($subjects)): ?>
                                    <tr><td colspan="5" class="text-center text-muted">No subjects added yet.</td></tr>
                                <?php endif; ?>

                                <?php foreach($subjects as $s): ?>
                                <tr>
                                    <td><strong><?= $s['class_name'] ?> (<?= $s['section_name'] ?>)</strong></td>
                                    <td><?= $s['subject_name'] ?></td>
                                    <td><span class="badge bg-secondary"><?= $s['subject_code'] ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-link" data-bs-toggle="popover" title="Syllabus" data-bs-content="<?= $s['syllabus'] ?>">View Details</button>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('subjects/delete/'.$s['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this subject?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS for Popover functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
</body>
</html>