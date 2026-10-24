<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students MGT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0b0f19;
            --bg-card: #131825;
            --bg-card-hover: #1a2035;
            --border-color: #1e2a45;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --success: #22c55e;
            --danger: #ef4444;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }
        .main-container { position: relative; z-index: 1; max-width: 1100px; margin: 0 auto; padding: 40px 20px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; }
        .page-header h1 { font-weight: 700; font-size: 2rem; letter-spacing: -0.5px; margin: 0; display: flex; align-items: center; gap: 12px; }
        .icon-box {
            width: 44px; height: 44px; background: var(--accent-glow); border: 1px solid rgba(99,102,241,0.3);
            border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--accent-hover);
        }
        .btn-add {
            background: var(--accent); color: #fff; border: none; padding: 10px 24px; border-radius: 10px;
            font-family: 'Outfit', sans-serif; font-weight: 500; font-size: 0.95rem; text-decoration: none;
            display: flex; align-items: center; gap: 8px; transition: all 0.2s ease;
        }
        .btn-add:hover { background: var(--accent-hover); color: #fff; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(99,102,241,0.25); }
        .alert-toast {
            border: none; border-radius: 12px; padding: 14px 20px; font-weight: 500; font-size: 0.9rem;
            margin-bottom: 24px; display: flex; align-items: center; gap: 10px; animation: slideDown 0.4s ease;
        }
        .alert-toast.alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: var(--success); }
        .alert-toast.alert-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: var(--danger); }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .table-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; }
        .student-table { width: 100%; border-collapse: collapse; margin: 0; }
        .student-table thead th {
            background: rgba(99,102,241,0.05); padding: 16px 20px; font-weight: 600; font-size: 0.8rem;
            text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); border-bottom: 1px solid var(--border-color); text-align: left;
        }
        .student-table tbody tr { transition: background 0.15s ease; }
        .student-table tbody tr:hover { background: var(--bg-card-hover); }
        .student-table tbody td { padding: 14px 20px; border-bottom: 1px solid rgba(30,42,69,0.5); vertical-align: middle; }
        .student-table tbody tr:last-child td { border-bottom: none; }
        .student-avatar { width: 42px; height: 42px; border-radius: 10px; object-fit: cover; border: 2px solid var(--border-color); }
        .student-name { font-weight: 600; }
        .student-cin { font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--text-secondary); background: rgba(99,102,241,0.08); padding: 4px 10px; border-radius: 6px; }
        .student-email { color: var(--accent-hover); font-size: 0.9rem; }
        .actions-cell { display: flex; gap: 8px; }
        .btn-action {
            padding: 7px 14px; border-radius: 8px; font-size: 0.82rem; font-family: 'Outfit', sans-serif;
            font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 5px; transition: all 0.2s ease; border: none;
        }
        .btn-edit { background: rgba(99,102,241,0.1); color: var(--accent-hover); border: 1px solid rgba(99,102,241,0.2); }
        .btn-edit:hover { background: rgba(99,102,241,0.2); color: var(--accent-hover); }
        .btn-delete { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
        .btn-delete:hover { background: rgba(239,68,68,0.2); color: var(--danger); }
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-secondary); }
        .empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.4; display: block; }
        .student-count { font-size: 0.85rem; color: var(--text-secondary); padding: 12px 20px; border-top: 1px solid var(--border-color); display: flex; align-items: center; gap: 6px; }
    </style>
</head>
<body>
    <?php
        include "config.php";
        $query = $db->prepare("SELECT * FROM Students");
        $query->execute();
        $students = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="main-container">
        <div class="page-header">
            <h1><span class="icon-box"><i class="bi bi-mortarboard-fill"></i></span> Students</h1>
            <a href="add_student.php" class="btn-add"><i class="bi bi-plus-lg"></i> Add Student</a>
        </div>

        <?php if(isset($_GET["err"])): ?>
            <div class="alert-toast alert-danger"><i class="bi bi-exclamation-circle-fill"></i> Student not found!</div>
        <?php endif; ?>
        <?php if(isset($_GET["success"])): ?>
            <div class="alert-toast alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <?php
                    if($_GET["success"] == "delete_student") echo "Student deleted successfully!";
                    if($_GET["success"] == "add_student") echo "Student added successfully!";
                    if($_GET["success"] == "edit_student") echo "Student updated successfully!";
                ?>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <?php if(count($students) > 0): ?>
            <table class="student-table">
                <thead>
                    <tr><th>Image</th><th>Name</th><th>CIN</th><th>Email</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach($students as $student): ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($student["image"]) ?>" alt="" class="student-avatar"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($student["name"]) ?>&background=6366f1&color=fff&size=42'">
                        </td>
                        <td><span class="student-name"><?= htmlspecialchars($student["name"]) ?></span></td>
                        <td><span class="student-cin"><?= htmlspecialchars($student["cin"]) ?></span></td>
                        <td><span class="student-email"><?= htmlspecialchars($student["email"]) ?></span></td>
                        <td>
                            <div class="actions-cell">
                                <a href="edit_students.php?id=<?= $student["id"] ?>" class="btn-action btn-edit"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="delete_students.php?id=<?= $student["id"] ?>" class="btn-action btn-delete"
                                   onclick="return confirm('Delete this student?')"><i class="bi bi-trash3"></i> Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="student-count"><i class="bi bi-people-fill"></i> <?= count($students) ?> student<?= count($students) > 1 ? 's' : '' ?> total</div>
            <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>No students yet. Click <strong>"Add Student"</strong> to get started.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
