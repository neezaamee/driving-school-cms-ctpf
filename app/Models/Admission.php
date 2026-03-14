<?php

namespace App\Models;

class Admission
{
    /**
     * Find an admission by its ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        global $con;
        $sql = "SELECT * FROM admissions WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admission = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $admission;
    }

    /**
     * Find an admission by its registration number.
     *
     * @param string $registration
     * @return object|null
     */
    public static function findByRegistration($registration)
    {
        global $con;
        $sql = "SELECT * FROM admissions WHERE registration = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $registration);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admission = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $admission;
    }

    /**
     * Find an admission by its student ID.
     *
     * @param int $studentID
     * @return object|null
     */
    public static function findByStudent($studentID)
    {
        global $con;
        $sql = "SELECT * FROM admissions WHERE idstudent = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $studentID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admission = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $admission;
    }

    /**
     * Get the latest admissions with a limit.
     *
     * @param int $limit
     * @return array
     */
    public static function latest($limit = 10)
    {
        global $con;
        $sql = "SELECT * FROM admissions ORDER BY id DESC LIMIT ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admissions = [];
        while ($admission = mysqli_fetch_object($result)) {
            $admissions[] = $admission;
        }
        mysqli_stmt_close($stmt);
        return $admissions;
    }
}
