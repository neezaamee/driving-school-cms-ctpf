<?php

namespace App\Models;

class Voucher
{
    /**
     * Find a voucher by its ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        global $con;
        $sql = "SELECT * FROM vouchers WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $voucher = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $voucher;
    }

    /**
     * Find a voucher by its number.
     *
     * @param string $voucherNo
     * @return object|null
     */
    public static function findByNo($voucherNo)
    {
        global $con;
        $sql = "SELECT * FROM vouchers WHERE vouchernumber = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $voucherNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $voucher = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $voucher;
    }

    /**
     * Find the latest paid voucher for a student.
     *
     * @param int $studentID
     * @return object|null
     */
    public static function findByStudent($studentID)
    {
        global $con;
        $sql = "SELECT * FROM vouchers WHERE idstudent = ? AND status = 1 ORDER BY id DESC LIMIT 1";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $studentID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $voucher = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $voucher;
    }
}
