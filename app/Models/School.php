<?php

namespace App\Models;

class School
{
    /**
     * Find a school by its ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        global $con;
        $sql = "SELECT * FROM schools WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $school = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $school;
    }

    /**
     * Get all schools.
     *
     * @return array
     */
    public static function all()
    {
        global $con;
        $sql = "SELECT * FROM schools";
        $result = mysqli_query($con, $sql);
        $schools = [];
        while ($school = mysqli_fetch_object($result)) {
            $schools[] = $school;
        }
        return $schools;
    }
}
