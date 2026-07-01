<?php

function ensureColumnExists($conn, $table, $column, $definition){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);

    $check_sql = "SHOW COLUMNS FROM `$table` LIKE '$column'";
    $check_result = mysqli_query($conn, $check_sql);

    if($check_result && mysqli_num_rows($check_result) == 0){
        mysqli_query($conn, "ALTER TABLE `$table` ADD COLUMN `$column` $definition");
    }
}

function ensureTrainingLogColumns($conn){
    ensureColumnExists($conn, "training_log", "muscle_group", "VARCHAR(50) NULL");
    ensureColumnExists($conn, "training_log", "workout_type", "VARCHAR(100) NULL");
    ensureColumnExists($conn, "training_log", "exercise_done", "TEXT NULL");
    ensureColumnExists($conn, "training_log", "training_guidance", "TEXT NULL");
}

?>
