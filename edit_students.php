<?php
    include "config.php";

    // Handle UPDATE on POST
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"]) && is_numeric($_GET["id"])){
        $query = $db->prepare("UPDATE Students SET name = :name, cin = :cin, email = :email, image = :image, address = :address WHERE id = :id");
        $query->bindParam(":name", $_POST["name"]);
        $query->bindParam(":cin", $_POST["cin"]);
        $query->bindParam(":email", $_POST["email"]);
        $query->bindParam(":image", $_POST["image"]);
        $query->bindParam(":address", $_POST["address"]);
        $query->bindParam(":id", $_GET["id"]);
        $query->execute();
        header("location:index.php?success=edit_student");
        exit();
    }

    // Load student data
    if(isset($_GET["id"]) && is_numeric($_GET["id"])){
        $query1 = $db->prepare("SELECT COUNT(*) as nb_student FROM Students WHERE id = :id");
        $query1->bindParam(":id", $_GET["id"]);
        $query1->execute();
        $result = $query1->fetch(PDO::FETCH_ASSOC);
        if($result["nb_student"] < 1){
            header("location:index.php?err=student_not_found");
            exit();
        }
        $query2 = $db->prepare("SELECT * FROM Students WHERE id = :id");
        $query2->bindParam(":id", $_GET["id"]);
        $query2->execute();
        $student = $query2->fetch(PDO::FETCH_ASSOC);
    } else {
        header("location:index.php?err=student_not_found");
        exit();
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0b0f19;
            --bg-card: #131825;
            --border-color: #1e2a45;
            --accent: #6366f1;
            --accent-hover: #818cf8;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --input-bg: #0f1320;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }
        .main-container { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; padding: 40px 20px; }
        .back-link {
            color: var(--text-secondary); text-decoration: none; font-size: 0.9rem;
            display: flex; align-items: center; gap: 6px; margin-bottom: 24px; transition: color 0.2s;
        }
        .back-link:hover { color: var(--accent-hover); }
        .form-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 36px; }
        .form-card h1 {
            font-weight: 700; font-size: 1.6rem; margin-bottom: 8px;
            display: flex; align-items: center; gap: 12px;
        }
        .form-card .subtitle { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 32px; }
        .icon-box {
            width: 40px; height: 40px; background: var(--accent-glow); border: 1px solid rgba(99,102,241,0.3);
            border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: var(--accent-hover);
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-weight: 500; font-size: 0.85rem; color: var(--text-secondary);
            margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .form-group input, .form-group textarea {
            width: 100%; padding: 12px 16px; background: var(--input-bg); border: 1px solid var(--border-color);
            border-radius: 10px; color: var(--text-primary); font-family: 'Outfit', sans-serif; font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .btn-row { display: flex; gap: 12px; margin-top: 28px; }
        .btn-submit {
            flex: 1; background: var(--accent); color: #fff; border: none; padding: 13px 24px;
            border-radius: 10px; font-family: 'Outfit', sans-serif; font-weight: 600; font-size: 0.95rem;
            cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(99,102,241,0.25); }
        .btn-cancel {
            background: transparent; color: var(--text-secondary); border: 1px solid var(--border-color);
            padding: 13px 24px; border-radius: 10px; font-family: 'Outfit', sans-serif; font-weight: 500;
            font-size: 0.95rem; text-decoration: none; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-cancel:hover { border-color: var(--text-secondary); color: var(--text-primary); }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="index.php" class="back-link"><i class="bi bi-arrow-left"></i> Back to students</a>
        <div class="form-card">
            <h1><span class="icon-box"><i class="bi bi-pencil-fill"></i></span> Edit Student</h1>
            <p class="subtitle">Update the student information below.</p>
            <form method="post">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($student["name"]) ?>">
                </div>
                <div class="form-group">
                    <label for="cin">CIN</label>
                    <input type="text" id="cin" name="cin" required value="<?= htmlspecialchars($student["cin"]) ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?= htmlspecialchars($student["email"]) ?>">
                </div>
                <div class="form-group">
                    <label for="image">Image URL</label>
                    <input type="text" id="image" name="image" required value="<?= htmlspecialchars($student["image"]) ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"><?= htmlspecialchars($student["address"]) ?></textarea>
                </div>
                <div class="btn-row">
                    <a href="index.php" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit"><i class="bi bi-check-lg"></i> Update Student</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
