<?php

namespace App\Models;

class Student
{
    /**
     * Find a student by their primary key ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        global $con;
        $query = "SELECT * FROM students WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) return null;
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $student = mysqli_fetch_object($result);
        
        mysqli_stmt_close($stmt);
        
        return $student ?: null;
    }
}
