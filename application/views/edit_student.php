<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student | Studiora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; }
        .top-header { display: flex; align-items: center; margin-bottom: 30px; padding-top: 20px; }
        .back-btn { background: white; color: var(--forest-green); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s; border: 1px solid #eee; margin-right: 20px; }
        .back-btn:hover { background: var(--gold); color: white; transform: translateX(-5px); }
        
        .glass-card { background: white; border-radius: 25px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); padding: 40px; }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); }
        .form-label { font-weight: 600; color: var(--forest-green); font-size: 0.9rem; }
        .form-control { border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px; }
        .section-title { color: var(--gold); border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; }
        .btn-update { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); padding: 12px 30px; border-radius: 12px; font-weight: 700; }
        .btn-update:hover { background: var(--gold); color: white; }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="top-header">
            <!-- BACK ARROW TO STUDENT LIST -->
            <a href="<?= site_url('students') ?>" class="back-btn"><i class="fa fa-arrow-left"></i></a>
            <h2>Edit Record: <?= $student['first_name'] ?></h2>
        </div>

        <div class="glass-card">
            <form action="<?= site_url('students/edit/'.$student['id']); ?>" method="POST" enctype="multipart/form-data">
                <div class="section-title">Academic Details</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-3"><label class="form-label">Admission No</label><input type="text" name="adm_no" class="form-control" value="<?= $student['adm_no'] ?>" required></div>
                    <div class="col-md-3"><label class="form-label">Class</label><input type="text" name="class" class="form-control" value="<?= $student['class'] ?>"></div>
                    <div class="col-md-3"><label class="form-label">Section</label><input type="text" name="section" class="form-control" value="<?= $student['section'] ?>"></div>
                    <div class="col-md-3"><label class="form-label">Roll No</label><input type="text" name="roll_no" class="form-control" value="<?= $student['roll_no'] ?>"></div>
                </div>

                <div class="section-title">Profile Update</div>
                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="<?= base_url('uploads/students/'.$student['photo']); ?>" class="img-fluid rounded-3 border" style="max-height: 120px;">
                    </div>
                    <div class="col-md-5"><label class="form-label">First Name</label><input type="text" name="first_name" class="form-control" value="<?= $student['first_name'] ?>" required></div>
                    <div class="col-md-5"><label class="form-label">Last Name</label><input type="text" name="last_name" class="form-control" value="<?= $student['last_name'] ?>"></div>
                </div>

                <div class="row g-3 mb-5">
                    <div class="col-md-4"><label class="form-label">Date of Birth</label><input type="date" name="dob" class="form-control" value="<?= $student['dob'] ?>"></div>
                    <div class="col-md-4"><label class="form-label">Change Photo</label><input type="file" name="student_photo" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Father's Name</label><input type="text" name="father_name" class="form-control" value="<?= $student['father_name'] ?>"></div>
                </div>

                <div class="text-end">
                    <a href="<?= site_url('students'); ?>" class="btn btn-light px-4 me-2">Go Back</a>
                    <button type="submit" class="btn btn-update shadow-sm">Update Student Record</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>