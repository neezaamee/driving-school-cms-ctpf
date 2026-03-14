<?php

namespace App\Models;

class AuditLog
{
    /**
     * Get the latest audit logs with user information.
     *
     * @param int $limit
     * @return array
     */
    public static function latestWithUsers($limit = 500)
    {
        global $con;
        $sql = "SELECT a.*, u.username, u.firstname, u.lastname 
                FROM audit_logs a 
                LEFT JOIN users u ON a.user_id = u.id 
                ORDER BY a.created_at DESC LIMIT ?";
        
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $logs = [];
        while ($row = mysqli_fetch_object($result)) {
            $logs[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $logs;
    }

    /**
     * Create a new audit log entry.
     *
     * @param int $userId
     * @param string $action
     * @param string $table
     * @param string $targetId
     * @param string $details
     * @return bool
     */
    public static function log($userId, $action, $table, $targetId, $details = '')
    {
        global $con;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $sql = "INSERT INTO audit_logs (user_id, action, target_table, target_id, details, ip_address) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "isssss", $userId, $action, $table, $targetId, $details, $ip);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success;
    }
}
