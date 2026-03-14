<?php

namespace App\Models;

class User
{
    /**
     * Find a user by their ID.
     *
     * @param int $id
     * @return object|null
     */
    public static function find($id)
    {
        global $con;
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_object($result);
        mysqli_stmt_close($stmt);
        return $user;
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public static function all()
    {
        global $con;
        $sql = "SELECT * FROM users";
        $result = mysqli_query($con, $sql);
        $users = [];
        while ($user = mysqli_fetch_object($result)) {
            $users[] = $user;
        }
        return $users;
    }

    /**
     * Check if the user is a Super Admin.
     *
     * @param object $user
     * @return bool
     */
    public static function isSuperAdmin($user)
    {
        return isset($user->idusertype) && $user->idusertype == 1;
    }

    /**
     * Check if the user is an Incharge.
     *
     * @param object $user
     * @return bool
     */
    public static function isIncharge($user)
    {
        return isset($user->idusertype) && $user->idusertype == 2;
    }

    /**
     * Check if the user is a Data Entry Operator.
     *
     * @param object $user
     * @return bool
     */
    public static function isDEO($user)
    {
        return isset($user->idusertype) && $user->idusertype == 3;
    }
}
