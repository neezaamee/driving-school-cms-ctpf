<?php
require_once 'connection.php';
mysqli_select_db($con, 'ds_ctpfsd_merged');

echo "--- Starting School Deduplication ---\n";

// Find duplicates
$duplicates = $con->query("SELECT location, count(*) as c FROM schools GROUP BY location HAVING c > 1");

while ($row = $duplicates->fetch_assoc()) {
    $location = $con->real_escape_string($row['location']);
    echo "Processing Location: $location\n";
    
    // Get all variants for this location
    // We prefer the one with idcity != 0
    $variantsRes = $con->query("SELECT id, idcity FROM schools WHERE location = '$location' ORDER BY idcity DESC, id ASC");
    
    $master = $variantsRes->fetch_assoc();
    $masterId = $master['id'];
    
    while ($sub = $variantsRes->fetch_assoc()) {
        $subId = $sub['id'];
        echo "  Merging duplicate ID $subId into master ID $masterId\n";
        
        // Update all referencing tables
        $tables = [
            'admissions', 'expenses', 'fee_payments', 'school_counters', 
            'staff', 'staff_transfer_history', 'users', 'vehicles', 'vouchers'
        ];
        
        foreach ($tables as $table) {
            $con->query("UPDATE `$table` SET idschool = $masterId WHERE idschool = $subId");
        }
        
        // Delete the duplicate school record
        $con->query("DELETE FROM schools WHERE id = $subId");
    }
}

echo "--- Deduplication Complete ---\n";
?>
