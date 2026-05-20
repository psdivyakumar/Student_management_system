<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Registration | Studiora Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest-green: #061e19; --gold: #b89552; --cream: #f8f7f2; }
        body { background-color: var(--cream); font-family: 'Inter', sans-serif; padding-bottom: 50px; }
        
        .page-header { background: white; padding: 20px 40px; box-shadow: 0 2px 15px rgba(0,0,0,0.02); display: flex; align-items: center; margin-bottom: 40px; }
        .back-circle { width: 40px; height: 40px; background: var(--forest-green); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; margin-right: 15px; }
        .back-circle:hover { background: var(--gold); color: white; }
        h2 { font-family: 'Playfair Display', serif; color: var(--forest-green); margin: 0; }

        .admission-card { background: white; border-radius: 30px; box-shadow: 0 15px 50px rgba(0,0,0,0.03); border: none; padding: 40px; }
        .form-section-title { font-family: 'Playfair Display', serif; color: var(--gold); font-size: 1.3rem; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 25px; margin-top: 30px; display: flex; align-items: center; }
        .form-section-title i { font-size: 1rem; margin-right: 12px; opacity: 0.7; }
        
        .form-label { font-weight: 600; font-size: 0.85rem; color: #555; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #eef0f2; padding: 12px 15px; background: #fbfcfd; transition: 0.3s; }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(184, 149, 82, 0.1); }
        
        .photo-upload-box { width: 140px; height: 140px; background: #f8f9fa; border: 2px dashed #ddd; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #888; cursor: pointer; transition: 0.3s; overflow: hidden; margin: 0 auto; }
        .photo-upload-box:hover { border-color: var(--gold); color: var(--gold); }
        
        .btn-submit { background: var(--forest-green); color: var(--gold); border: 1px solid var(--gold); padding: 15px 50px; border-radius: 15px; font-weight: 700; transition: 0.3s; }
        .btn-submit:hover { background: var(--gold); color: white; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(184, 149, 82, 0.2); }
    </style>
</head>
<body>

    <div class="page-header">
        <a href="<?= site_url('teachers') ?>" class="back-circle"><i class="fa fa-arrow-left"></i></a>
        <h2>Faculty Registration</h2>
    </div>

    <div class="container">
        <div class="admission-card">
            <form action="<?= site_url('teachers/add') ?>" method="POST" enctype="multipart/form-data">
                
                <div class="text-center mb-5">
                    <div class="photo-upload-box" onclick="document.getElementById('photoInput').click();">
                        <i class="fa fa-user-plus fa-2x mb-1"></i>
                        <span style="font-size: 0.65rem;">Profile Photo</span>
                        <input type="file" name="teacher_photo" id="photoInput" hidden>
                    </div>
                </div>

                <div class="form-section-title" style="margin-top: 0;"><i class="fa fa-briefcase"></i> Professional Credentials</div>
                <div class="row g-4 mb-4">
                    <div class="col-md-3"><label class="form-label">Employee ID</label><input type="text" name="emp_id" class="form-control" placeholder="e.g. TCH-001" required></div>
                    <div class="col-md-3"><label class="form-label">Specialization</label><input type="text" name="subject" class="form-control" placeholder="e.g. Mathematics"></div>
                    <div class="col-md-3"><label class="form-label">Qualification</label><input type="text" name="qualification" class="form-control" placeholder="e.g. M.Sc, B.Ed"></div>
                    <div class="col-md-3"><label class="form-label">Joining Date</label><input type="date" name="joining_date" class="form-control"></div>
                </div>

                <div class="form-section-title"><i class="fa fa-id-card"></i> Personal Profile</div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4"><label class="form-label">First Name</label><input type="text" name="first_name" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Last Name</label><input type="text" name="last_name" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Salary (Monthly)</label><input type="number" name="salary" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Email Address</label><input type="email" name="email" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Phone Number</label><input type="text" name="phone" class="form-control"></div>
                    <div class="col-md-12"><label class="form-label">Residential Address</label><textarea name="address" class="form-control" rows="3"></textarea></div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn-submit">Register Faculty Member</button>
                    <div class="mt-3"><a href="<?= site_url('teachers') ?>" class="text-muted text-decoration-none small">Cancel and return to list</a></div>
                </div>

            </form>
        </div>
    </div>

</body>
</html>