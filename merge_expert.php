<?php
/**
 * Master Database Merge Script - MySQL-Expert Edition
 * Merges Local and Hosting variants into a unified target.
 */

$config = [
    'local' => ['db' => 'ds_ctpfsd', 'host' => 'localhost', 'user' => 'root', 'pass' => ''],
    'hosting' => ['db' => 'school_ctpfsd_new', 'host' => 'localhost', 'user' => 'root', 'pass' => ''],
    'target' => ['db' => 'ds_ctpfsd_merged', 'host' => 'localhost', 'user' => 'root', 'pass' => ''],
    'offset' => 1000000,
];

// Helper to get connection
function getConn($conf) {
    $conn = new mysqli($conf['host'], $conf['user'], $conf['pass'], $conf['db']);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
    return $conn;
}

$local = getConn($config['local']);
$hosting = getConn($config['hosting']);
$target = getConn($config['target']);

echo "--- Initializing Merge ---\n";

// Disable FK checks globally for the session
$target->query("SET FOREIGN_KEY_CHECKS = 0");
$target->query("SET SESSION sql_mode = '' "); // Relax strict mode for zero dates

// 1. Prepare Target Schema (copy from Local)
echo "Recreating tables in target...\n";
$tablesResult = $local->query("SHOW TABLES");
$tables = [];
while ($row = $tablesResult->fetch_row()) {
    $table = $row[0];
    $tables[] = $table;
    $target->query("DROP TABLE IF EXISTS `$table` ");
    $create = $local->query("SHOW CREATE TABLE `$table`")->fetch_row();
    $target->query($create[1]);
}

// 2. Map existing students in Local to prevent duplicates
echo "Mapping local students for deduplication...\n";
$localStudents = [];
$res = $local->query("SELECT id, cnic FROM students WHERE cnic IS NOT NULL AND cnic != 0");
while ($row = $res->fetch_assoc()) {
    $localStudents[$row['cnic']] = $row['id'];
}

// 3. Import Local Data first (as-is)
echo "Importing local data to target...\n";
foreach ($tables as $table) {
    $target->query("INSERT INTO `{$config['target']['db']}`.`$table` SELECT * FROM `{$config['local']['db']}`.`$table` ");
}

// 4. Handle Hosting Data with Offset and Deduplication
echo "Processing hosting data with offset {$config['offset']}...\n";
$idMapping = ['students' => []];

foreach ($tables as $table) {
    echo "Processing table: $table\n";
    
    // Check if table exists in hosting
    $check = $hosting->query("SHOW TABLES LIKE '$table'");
    if ($check->num_rows == 0) {
        echo "  Skipping $table (not in hosting)\n";
        continue;
    }

    // Identify columns
    $colsRes = $hosting->query("DESCRIBE `$table` ");
    $cols = [];
    $pk = null;
    $fkCols = [];
    while ($c = $colsRes->fetch_assoc()) {
        $cols[] = $c['Field'];
        if ($c['Key'] == 'PRI') $pk = $c['Field'];
        if (strpos($c['Field'], 'id') === 0 && $c['Field'] != 'id' && $c['Field'] != 'idusertype' && $c['Field'] != 'idblood' && $c['Field'] != 'idgender') {
            // Potential relationship foreign key (e.g. idstudent, idcourse)
            // Note: excluding internal types like blood/gender/usertype if they are fixed references
            $fkCols[] = $c['Field'];
        }
    }

    $dataRes = $hosting->query("SELECT * FROM `$table` ");
    
    // Get target columns to handle schema mismatches
    $targetColsRes = $target->query("DESCRIBE `$table` ");
    $targetCols = [];
    while ($tc = $targetColsRes->fetch_assoc()) { $targetCols[] = $tc['Field']; }

    while ($row = $dataRes->fetch_assoc()) {
        
        // Special Handling: Students
        if ($table == 'students') {
            $cnic = $row['cnic'];
            if (isset($localStudents[$cnic])) {
                $idMapping['students'][$row['id']] = $localStudents[$cnic];
                continue;
            }
        }

        // Apply Offset to PK
        if ($pk && isset($row[$pk]) && is_numeric($row[$pk])) {
            $originalId = $row[$pk];
            $row[$pk] += $config['offset'];
            $idMapping[$table][$originalId] = $row[$pk];
        }

        // Apply Offset to FKs
        foreach ($fkCols as $fk) {
            if ($row[$fk] && is_numeric($row[$fk])) {
                if ($fk == 'idstudent' && isset($idMapping['students'][$row[$fk]])) {
                    $row[$fk] = $idMapping['students'][$row[$fk]];
                } else {
                    $row[$fk] += $config['offset'];
                }
            }
        }

        // Filter out columns not in target (Handle schema mismatch)
        $rowToInsert = array_intersect_key($row, array_flip($targetCols));

        // Insert into target
        $keys = array_keys($rowToInsert);
        $vals = array_map(function($v) use ($target) {
            if ($v === null) return 'NULL';
            return "'" . $target->real_escape_string($v) . "'";
        }, array_values($rowToInsert));

        $insertQuery = "INSERT IGNORE INTO `$table` (`" . implode("`,`", $keys) . "`) VALUES (" . implode(",", $vals) . ")";
        if (!$target->query($insertQuery)) {
            echo "  Error in $table: " . $target->error . "\n";
        }
    }
}

// Re-enable FK checks
$target->query("SET FOREIGN_KEY_CHECKS = 1");

echo "--- Merge Complete ---\n";
