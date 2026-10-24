<?php
    if(isset($_GET["id"]) && is_numeric($_GET["id"])){
        include "config.php";
        // Check if student exists
        $query1 = $db->prepare("SELECT COUNT(*) as nb_student FROM Students WHERE id = :id");
        $query1->bindParam(":id", $_GET["id"]);
        $query1->execute();
        $result = $query1->fetch(PDO::FETCH_ASSOC);
        if($result["nb_student"] < 1){
            header("location:index.php?err=student_not_found");
            exit();
        }

        // Delete Student
        $query2 = $db->prepare("DELETE FROM Students WHERE id = :id");
        $query2->bindParam(":id", $_GET["id"]);
        $query2->execute();
        header("location:index.php?success=delete_student");
        exit();
    }
?>
