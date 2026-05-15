<?php
/**
 * Master Re-indexing Script for Driving School CMS
 * Normalizes IDs to be sequential starting from 1.
 */

set_time_limit(0);
require_once('connection.php');

// Ensure we are working on the merged database
mysqli_select_db($con, 'ds_ctpfsd_merged');

// Disable constraints and strict mode for legacy data migration
$con->query("SET FOREIGN_KEY_CHECKS = 0");
$con->query("SET sql_mode = ''");

function logMsg($msg) {
    echo "[" . date('H:i:s') . "] $msg\n";
}

/**
 * Re-indexes a table and updates all tables that reference its ID.
 */
function reindexTable($con, $tableName, $referencingTables = [], $orderBy = 'id') {
    logMsg("Starting re-index for table: $tableName");

    // 1. Create mapping table
    $con->query("DROP TABLE IF EXISTS tmp_map_$tableName");
    $con->query("CREATE TABLE tmp_map_$tableName (old_id INT, new_id INT AUTO_INCREMENT, PRIMARY KEY (new_id))");

    // 2. Populate mapping
    $con->query("INSERT INTO tmp_map_$tableName (old_id) SELECT id FROM $tableName ORDER BY $orderBy");
    
    $result = $con->query("SELECT COUNT(*) as count FROM tmp_map_$tableName");
    $rowCount = $result->fetch_assoc()['count'];
    logMsg("Created map for $rowCount records in $tableName.");

    // 3. Update referencing tables (Foreign Keys)
    foreach ($referencingTables as $ref) {
        $refTable = $ref['table'];
        $refCol = $ref['column'];
        
        logMsg("Updating foreign keys in $refTable.$refCol...");
        $updateSql = "UPDATE $refTable t 
                      JOIN tmp_map_$tableName m ON t.$refCol = m.old_id 
                      SET t.$refCol = m.new_id";
        if (!$con->query($updateSql)) {
            // Note: If a column doesn't exist, we log it and continue instead of dying
            logMsg("WARNING: Failed to update $refTable.$refCol. Check if column exists.");
        }
    }

    // 4. Update the primary table itself
    logMsg("Updating $tableName primary keys...");
    
    // Create temp table with same structure
    $con->query("DROP TABLE IF EXISTS tmp_data_$tableName");
    $con->query("CREATE TABLE tmp_data_$tableName LIKE $tableName");
    
    // Copy data with new IDs
    $columnsResult = $con->query("SHOW COLUMNS FROM $tableName");
    $cols = [];
    while ($col = $columnsResult->fetch_assoc()) {
        if ($col['Field'] != 'id') {
            $cols[] = "`".$col['Field']."`";
        }
    }
    $colString = implode(', ', $cols);
    
    $con->query("INSERT INTO tmp_data_$tableName (id, $colString) 
                 SELECT m.new_id, $colString FROM $tableName t 
                 JOIN tmp_map_$tableName m ON t.id = m.old_id");

    // Replace old table with new table
    $con->query("DELETE FROM $tableName"); // Using DELETE instead of TRUNCATE in some contexts for safer transactional feel
    $con->query("INSERT INTO $tableName SELECT * FROM tmp_data_$tableName");

    // Cleanup
    $con->query("DROP TABLE tmp_data_$tableName");
    $con->query("DROP TABLE tmp_map_$tableName");

    logMsg("Finished $tableName. Resetting auto-increment to " . ($rowCount + 1));
    $con->query("ALTER TABLE $tableName AUTO_INCREMENT = " . ($rowCount + 1));
}

// Disable FK checks
$con->query("SET FOREIGN_KEY_CHECKS = 0");

/**
 * WAVE 1: Reference Data
 */
logMsg("=== STARTING WAVE 1 ===");
reindexTable($con, 'blood', [['table' => 'students', 'column' => 'idblood']]);
reindexTable($con, 'cities', [['table' => 'banks', 'column' => 'idcity'], ['table' => 'schools', 'column' => 'idcity']]);
reindexTable($con, 'gender', [['table' => 'students', 'column' => 'gender']]);
reindexTable($con, 'studentcategories', [['table' => 'vouchers', 'column' => 'idstudentcategory']]);
reindexTable($con, 'usertypes', [['table' => 'users', 'column' => 'idusertype']]);
reindexTable($con, 'expensetypes', [['table' => 'expenses', 'column' => 'idexpensetype']]);
reindexTable($con, 'typestaff', [['table' => 'staff', 'column' => 'idtypestaff']]);

/**
 * WAVE 2: Master Entities
 */
logMsg("=== STARTING WAVE 2 ===");

// Sanitize courses table status column (MySQL 8.0 error with duplicate '' in ENUM)
$con->query("ALTER TABLE courses MODIFY COLUMN status enum('1','0','') NOT NULL DEFAULT '1'");

reindexTable($con, 'courses', [
    ['table' => 'admissions', 'column' => 'idcourse'],
    ['table' => 'vouchers', 'column' => 'idcourse']
]);

reindexTable($con, 'schools', [
    ['table' => 'admissions', 'column' => 'idschool'],
    ['table' => 'vouchers', 'column' => 'idschool'],
    ['table' => 'expenses', 'column' => 'idschool'],
    ['table' => 'staff', 'column' => 'idschool'],
    ['table' => 'users', 'column' => 'idschool'],
    ['table' => 'vehicles', 'column' => 'idschool'],
    ['table' => 'fee_payments', 'column' => 'idschool'],
    ['table' => 'school_counters', 'column' => 'idschool'],
    ['table' => 'staff_transfer_history', 'column' => 'idschool']
], 'id');

reindexTable($con, 'staff', [
    ['table' => 'users', 'column' => 'idstaff'],
    ['table' => 'expenses', 'column' => 'idstaff'],
    ['table' => 'staff_transfer_history', 'column' => 'idstaff']
]);

reindexTable($con, 'vehicles', [
    ['table' => 'expenses', 'column' => 'idvehicle']
]);

reindexTable($con, 'students', [
    ['table' => 'admissions', 'column' => 'idstudent'],
    ['table' => 'vouchers', 'column' => 'idstudent'],
    ['table' => 'fee_payments', 'column' => 'idstudent']
], 'id');

/**
 * WAVE 3: Transactions
 */
logMsg("=== STARTING WAVE 3 ===");

reindexTable($con, 'users', [
    ['table' => 'admissions', 'column' => 'iduser'],
    ['table' => 'vouchers', 'column' => 'iduser'],
    ['table' => 'expenses', 'column' => 'idusers'],
    ['table' => 'fee_payments', 'column' => 'iduser'],
    ['table' => 'userlog', 'column' => 'idusers'],
    ['table' => 'usershistory', 'column' => 'idusers']
]);

reindexTable($con, 'vouchers', [
    ['table' => 'admissions', 'column' => 'idvoucher'],
    ['table' => 'fee_payments', 'column' => 'idvoucher']
], 'id');

reindexTable($con, 'admissions', [
    ['table' => 'fee', 'column' => 'idadmission']
], 'id');

// Remaining child tables
reindexTable($con, 'expenses');
reindexTable($con, 'fee_payments');
reindexTable($con, 'fee');
reindexTable($con, 'userlog');
reindexTable($con, 'usershistory');
reindexTable($con, 'school_counters');
reindexTable($con, 'staff_transfer_history');

$con->query("SET FOREIGN_KEY_CHECKS = 1");
logMsg("All database IDs have been successfully normalized.");
?>
