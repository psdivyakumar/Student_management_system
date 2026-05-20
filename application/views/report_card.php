<!DOCTYPE html>
<html>
<head>
    <style>
        .report-box { border: 2px solid #000; padding: 20px; width: 600px; margin: auto; font-family: Arial; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <div class="report-box">
        <div class="header">
            <h2>SCHOOL ERP HIGH SCHOOL</h2>
            <p>REPORT CARD - <?= $results[0]['exam_name'] ?></p>
        </div>
        <p><strong>Name:</strong> <?= $student['first_name'] ?> <?= $student['last_name'] ?> <span style="float:right"><strong>Class:</strong> <?= $student['class'] ?></span></p>
        <p><strong>Adm No:</strong> <?= $student['adm_no'] ?></p>
        
        <table>
            <thead><tr><th>Subject</th><th>Max Marks</th><th>Marks Obtained</th><th>Grade</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach($results as $r): $total += $r['marks_obtained']; ?>
                <tr>
                    <td><?= $r['subject_name'] ?></td>
                    <td>100</td>
                    <td><?= $r['marks_obtained'] ?></td>
                    <td><?= $r['grade'] ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="font-weight:bold"><td>TOTAL</td><td><?= count($results)*100 ?></td><td><?= $total ?></td><td></td></tr>
            </tbody>
        </table>
        <br>
        <button onclick="window.print()">Print Report Card</button>
    </div>
</body>
</html>