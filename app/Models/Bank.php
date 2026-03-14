<?php

namespace App\Models;

class Bank
{
    /**
     * Find a bank by its ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        global $con;
        $sql = "SELECT * FROM banks WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $bank = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $bank;
    }

    /**
     * Get all banks.
     *
     * @return array
     */
    public static function all()
    {
        global $con;
        $sql = "SELECT * FROM banks";
        $result = mysqli_query($con, $sql);
        $banks = [];
        while ($bank = mysqli_fetch_object($result)) {
            $banks[] = $bank;
        }
        return $banks;
    }
}
