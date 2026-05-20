<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Teacher - STUDIORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Teacher: <?php echo $teacher['first_name'] . ' ' . $teacher['last_name']; ?></h5>
                <span class="badge bg-dark">ID: <?php echo $teacher['emp_id']; ?></span>
            </div>
            <div class="card-body">
                <!-- Form action points back to the edit function in the controller -->
                <form action="<?php echo site_url('teachers/edit/'.$teacher['id']); ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="row g-3">
                        <h6 class="text-primary border-bottom pb-2">Professional Details</h6>
                        <div class="col-md-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" name="emp_id" class="form-control" value="<?php echo $teacher['emp_id']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Specialization (Subject)</label>
                            <input type="text" name="subject" class="form-control" value="<?php echo $teacher['subject']; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control" value="<?php echo $teacher['qualification']; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" class="form-control" value="<?php echo $teacher['salary']; ?>">
                        </div>

                        <h6 class="text-primary border-bottom pb-2 mt-4">Personal Details</h6>
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $teacher['first_name']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $teacher['last_name']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $teacher['email']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $teacher['phone']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Joining Date</label>
                            <input type="date" name="joining_date" class="form-control" value="<?php echo $teacher['joining_date']; ?>">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3"><?php echo $teacher['address']; ?></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Teacher Photo</label>
                            <div class="mb-2">
                                <!-- Shows the current teacher photo -->
                                <img src="<?php echo base_url('uploads/teachers/'.$teacher['photo']); ?>" width="100" class="img-thumbnail rounded">
                            </div>
                            <input type="file" name="teacher_photo" class="form-control">
                            <small class="text-muted">Select a new file only if you want to change the photo.</small>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
                        <a href="<?php echo site_url('teachers'); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Update Teacher Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>