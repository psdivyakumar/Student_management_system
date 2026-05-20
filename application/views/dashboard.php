<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studiora | Royal Aesthetic Dashboard</title>
    
    <!-- External CSS & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-color: #061e19; /* Royal Forest Green */
            --bg-color: #f8f7f2;      /* Creamy Off-White */
            --accent-gold: #b89552;   /* Muted Gold */
            --text-dark: #1a1a1a;
        }

        /* Force One-Page Layout: No Scrolling */
        body, html { 
            height: 100vh; 
            margin: 0; 
            overflow: hidden; 
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        h1, h2, h3, h4, .logo-text { font-family: 'Playfair Display', serif; }

        .dashboard-wrapper { display: flex; height: 100vh; }

        /* Sidebar Styling */
        .sidebar { 
            width: 250px; 
            background: var(--sidebar-color); 
            color: white; 
            padding: 25px 15px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .sidebar .nav-link { 
            color: rgba(255,255,255,0.6); 
            padding: 9px 15px; 
            font-size: 0.85rem;
            border-radius: 10px; 
            margin-bottom: 2px;
            transition: 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { 
            background: rgba(184, 149, 82, 0.2); 
            color: var(--accent-gold); 
        }
        .sidebar .nav-link i { margin-right: 12px; width: 20px; }

        /* Sidebar Note Box */
        .announcement-box { 
            background: rgba(255,255,255,0.05); 
            color: var(--accent-gold); 
            border-radius: 15px; 
            padding: 15px; 
            font-size: 0.75rem;
            border-left: 3px solid var(--accent-gold);
            margin-top: auto;
        }

        /* Main Content Layout */
        .main-content { flex: 1; padding: 20px 35px; display: flex; flex-direction: column; }

        /* Header Area */
        .header-area { margin-bottom: 20px; flex: 0 0 auto; }
        .search-bar { 
            background: white; border-radius: 12px; padding: 8px 18px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #eee;
        }

        /* Top Stats Row */
        .stats-row { flex: 0 0 auto; margin-bottom: 20px; }
        .stat-card { 
            background: white; border-radius: 18px; padding: 15px 20px; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.02); 
            display: flex; align-items: center;
            border: 1px solid rgba(184, 149, 82, 0.1);
        }
        .icon-circle { 
            width: 48px; height: 48px; background: var(--sidebar-color); 
            color: var(--accent-gold); border-radius: 12px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.3rem; margin-right: 15px; 
        }
        .stat-card p { margin: 0; font-size: 0.7rem; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card h4 { margin: 0; font-weight: 700; color: var(--sidebar-color); }

        /* Grid for Widgets */
        .content-grid { 
            flex: 1; 
            display: grid; 
            grid-template-columns: 1.4fr 1fr 1fr; 
            grid-template-rows: 1fr 1fr; 
            gap: 20px; 
            min-height: 0; 
        }

        .glass-card { 
            background: white; border-radius: 24px; padding: 20px; 
            box-shadow: 0 5px 25px rgba(0,0,0,0.02); 
            display: flex; flex-direction: column; 
            border: 1px solid rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .card-header-custom { 
            font-size: 0.85rem; font-weight: 700; 
            color: var(--sidebar-color); margin-bottom: 15px; 
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #f8f8f8; padding-bottom: 10px;
        }

        .task-item { display: flex; align-items: center; margin-bottom: 10px; font-size: 0.85rem; color: #444; }
        .task-item input { margin-right: 12px; accent-color: var(--accent-gold); width: 16px; height: 16px; }

        .recent-item { display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #fbfbfb; }
        .recent-item img { width: 35px; height: 35px; border-radius: 50%; margin-right: 12px; border: 1.5px solid var(--accent-gold); }

        /* Calendar Widget */
        .calendar-dark { background: #121212; color: white; border-radius: 20px; padding: 15px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-size: 0.75rem; gap: 5px; }
        .cal-day { height: 30px; display: flex; align-items: center; justify-content: center; }
        .today { background: var(--accent-gold); color: black; border-radius: 50%; font-weight: bold; }

        .chart-wrap { flex: 1; position: relative; min-height: 0; }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        <!-- SIDEBAR (Updated with Transport & Hostel) -->
        <div class="sidebar">
            <div class="text-center mb-4">
                <i class="fa fa-crown" style="color: var(--accent-gold); font-size: 2rem;"></i>
                <h3 class="logo-text mt-2 mb-0">studiora</h3>
            </div>
            
            <nav class="nav flex-column">
                <a class="nav-link active" href="<?= site_url('dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
                <a class="nav-link" href="<?= site_url('students') ?>"><i class="fa fa-user-graduate"></i> Students</a>
                <a class="nav-link" href="<?= site_url('teachers') ?>"><i class="fa fa-user-tie"></i> Teachers</a>
                <a class="nav-link" href="<?= site_url('academic/classes') ?>"><i class="fa fa-school"></i> Academic</a>
                <a class="nav-link" href="<?= site_url('attendance') ?>"><i class="fa fa-calendar-check"></i> Attendance</a>
                <a class="nav-link" href="<?= site_url('exams') ?>"><i class="fa fa-file-invoice"></i> Examinations</a>
                <a class="nav-link" href="<?= site_url('fees') ?>"><i class="fa fa-wallet"></i> Fees & Billing</a>
                <a class="nav-link" href="<?= site_url('transport') ?>"><i class="fa fa-bus"></i> Transport</a>
                <a class="nav-link" href="<?= site_url('hostel') ?>"><i class="fa fa-hotel"></i> Hostel</a>
                <a class="nav-link" href="<?= site_url('library') ?>"><i class="fa fa-book"></i> Library</a>
            </nav>

            <div class="announcement-box">
                <p class="mb-1 fw-bold"><i class="fa fa-bullhorn me-2"></i>Note</p>
                <p class="mb-0 opacity-75">
                    <?= !empty($note) ? $note['note_text'] : 'System Operational.' ?>
                </p>
            </div>
        </div>

        <!-- MAIN CONTENT (Untouched) -->
        <div class="main-content">
            
            <!-- Header -->
            <div class="header-area d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0">Welcome Back, Admin</h2>
                    <p class="text-muted small mb-0"><?= date('l, F d, Y') ?></p>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin&background=061e19&color=b89552" class="rounded-circle shadow-sm" width="45">
            </div>

            <!-- Stats Row -->
            <div class="row stats-row g-3">
                <div class="col-3">
                    <div class="stat-card">
                        <div class="icon-circle"><i class="fa fa-user-graduate"></i></div>
                        <div><p>Students</p><h4><?= $total_students ?></h4></div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="stat-card">
                        <div class="icon-circle"><i class="fa fa-user-tie"></i></div>
                        <div><p>Staff</p><h4><?= $total_staff ?></h4></div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="stat-card">
                        <div class="icon-circle"><i class="fa fa-layer-group"></i></div>
                        <div><p>Classes</p><h4><?= $active_classes ?></h4></div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="stat-card">
                        <div class="icon-circle"><i class="fa fa-coins"></i></div>
                        <div><p>Collected</p><h4>₹<?= number_format($revenue['collected'] / 1000, 1) ?>K</h4></div>
                    </div>
                </div>
            </div>

            <!-- Content Grid (Untouched) -->
            <div class="content-grid">
                
                <div class="glass-card">
                    <div class="card-header-custom">Subject Distribution <i class="fa fa-chart-pie text-muted"></i></div>
                    <div class="chart-wrap"><canvas id="subjectPie"></canvas></div>
                </div>

                <div class="glass-card text-center">
                    <div class="card-header-custom">Daily Presence <i class="fa fa-circle-check text-muted"></i></div>
                    <div class="chart-wrap"><canvas id="attendDonut"></canvas></div>
                    <h3 class="mt-2 fw-bold mb-0">92%</h3>
                </div>

                <div class="glass-card">
                    <div class="card-header-custom">Pending Tasks <i class="fa fa-tasks text-muted"></i></div>
                    <div class="task-list">
                        <?php foreach($tasks as $t): ?>
                            <div class="task-item"><input type="checkbox"> <span><?= $t['task_name'] ?></span></div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-header-custom">Recent Admissions <i class="fa fa-history text-muted"></i></div>
                    <div class="recent-list">
                        <?php foreach($recent_students as $rs): ?>
                        <div class="recent-item">
                            <img src="https://ui-avatars.com/api/?name=<?= $rs['first_name'] ?>&background=061e19&color=b89552">
                            <div><span class="fw-bold d-block small"><?= $rs['first_name'] ?></span><small class="text-muted">Class <?= $rs['class'] ?></small></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="glass-card">
                    <div class="card-header-custom">Revenue Progress <i class="fa fa-wallet text-muted"></i></div>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between small mb-2"><span>Progress</span> <strong><?= $revenue['percent'] ?>%</strong></div>
                        <div class="progress mb-2" style="height: 8px; border-radius: 20px;">
                            <div class="progress-bar" style="width: <?= $revenue['percent'] ?>%; background: var(--sidebar-color);"></div>
                        </div>
                        <small class="text-success fw-bold">₹<?= number_format($revenue['collected']) ?></small>
                    </div>
                </div>

                <div class="glass-card calendar-dark">
                    <div class="card-header-custom text-white border-secondary mb-2"><?= date('F Y') ?></div>
                    <div class="calendar-grid opacity-50 mb-1"><div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div></div>
                    <div class="calendar-grid">
                        <?php for($i=1; $i<=28; $i++): ?>
                            <div class="cal-day <?= ($i == date('j')) ? 'today' : '' ?>"><?= $i ?></div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js Engine -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('subjectPie'), {
            type: 'pie',
            data: { labels: ['Maths', 'Science', 'English', 'History'], datasets: [{ data: [30, 25, 25, 20], backgroundColor: ['#061e19', '#b89552', '#1a3c34', '#d4af37'], borderWidth: 0 }] },
            options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } } }
        });
        new Chart(document.getElementById('attendDonut'), {
            type: 'doughnut',
            data: { datasets: [{ data: [92, 8], backgroundColor: ['#b89552', '#222'], borderWidth: 0 }] },
            options: { cutout: '82%', maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    </script>
</body>
</html>