<?php
/**
 * Core PHP + MySQL Backup with Dropbox Upload
 * Author: Nizami (with ChatGPT tweaking 😎)
 */

date_default_timezone_set('Asia/Karachi');
ini_set('max_execution_time', 900);
ini_set('memory_limit', '-1');

// Database config
define("DB_USER", 'root');
define("DB_PASSWORD", '');
define("DB_NAME", 'school_ctpfsd_new');
define("DB_HOST", 'localhost');
define("BACKUP_DIR", 'db-backup-files');
define("TABLES", '*');
define("CHARSET", 'utf8');

// Dropbox Access Token (App Console se generate karo)
$DROPBOX_ACCESS_TOKEN = "sl.u.AF9oK2ValODfdWc9vhsCOJ1sMpi-OVWryIEMRuHD3ZdT17Yc4urUT_rbS0RGe0_LI79hFM9CJpgUekciFH2R18VIYeZQChDWT9a-QkA9dBCipLb59RDE9CEHblSpkJTbGT9aAf4POMa03kEwh8IbAAbf1FLdUGKR4nRP3_zMcldmbrEN-Telt2UL13QYpZ3idg_HfDt3P-4rot-GfN_YggxbNYombpsXJW-JC0wcwXwY1slyDQb3xuSrniX15mOvhUuS6LAGZQfefK97cfcpKSSPb6teaHt5UFj4vCKiqavek6-8dFsw0OH8Mg0ohepofPiYyObfxcWvszjGKwiUHi0o16C7fAypgyD-IsvVqU_pNlqbNbIUneV1-KnPhm3_balVECFrAagYG8llECoOSlhoZqs3uBUwOyx26dWN2Yt8VcqkU6HzjFu5BHpLHRJ4pDlbfsSA98EAF1Yx415wQhAwFRu5XLsX2sDOS0e1v0I06wwXFJLnRjLqowGmEcoPXYg93A44w91LMIAuQQRQONeXmpQTPn7bw-DmRejGHUmZYjQymp8OCxwbDG4qVq06YA89ptKyTxgH0q1KTUpg6nX0lBNO1234YEMNlLL_Mt_u6AY6ljugNtjbSDoisQIV_xzK-3rmDU302eQZkIkQTyah01Yk2Gqy-Dl0GwHfdbIgTZF24LEZGfhvVz4XRENZfNUCJVaLgnigxZ9aLBmAm6DG4hK4hhz17QbD0VEVnMVT6BkybZTm3o6fsB8IwO33_VKHcghOxgLwmsB2Wud51VGk0BfcWYruNQzEHJ46hF30FIXQBFn98Ze_RcpCpFt_4mcsZGFmYeVRB1Oo3mGUSYBoUMR7pvDJvH5FkVIHoXsPzFsrcfw5TzpBVogXjVcifSQjqXrxpm-MiuXGIo9ckBirbOJtLpx1shfv8J48QEAdvr7IJAcaU474IW7gSDYRSA-QzCK4ojJOJ2P7PRyK32zaYL3NDPl6ad7s5UIbk5-bO_QmijNVzzzUq8DX30YrBcanpIGyLY_S3CaIrrdAOgVlmccs43jb3zRMjx1zJA_1d1FmxrOClUXo0hxj21MeCicDQIdhD9BYxJtMayHbWGnv6TuuD9Qi-F371bK_LHO8YOPQbRAL9_GDIy39WeFZfo_3tcFJOKUp2NGAJZjt219YrvncfRldnFuO56pG2yfbwTMJD6bRMqB5Y1gB6_pPXT13BNKobP92wC7rUv_qIvab2jUiVg22L1CUhk2Q0U5eMf27X-rzCN2RVWZaI4hvEBLRrRRxOhPicvajA3SJip13RRlBqnET4uEK8DCFGAdKEliJe2ZKGudWrt62EOf1874JAfdf0n2KomVYBoDlzpMJ0XbuHtK40VMQUxJy3L9Omp9Fs3ivpCmLoZWo2yJryvmO-nPwkAJDN0WPqDetKkvBGB5UEewCb8_ChsOpwF_8zw";

class Backup_Database {
    var $user;
    var $password;
    var $dbname;
    var $host;
    var $charset;
    var $conn;
    var $backupFile;

    function __construct($host, $user, $password, $dbname, $charset = 'utf8') {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->charset = $charset;

        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Error connecting to database: " . $this->conn->connect_error);
        }
        $this->conn->set_charset($this->charset);
    }

    public function backupTables($tables = '*', $backupDir = '.') {
        $this->backupFile = 'db-backup-' . $this->dbname . '-' . date("d-m-Y_h-iA") . '.sql';
        $sqlScript = '';

        if ($tables == '*') {
            $tables = [];
            $result = $this->conn->query('SHOW TABLES');
            while ($row = $result->fetch_row()) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        foreach ($tables as $table) {
            $result = $this->conn->query("SELECT * FROM $table");
            $numFields = $result->field_count;

            $sqlScript .= "DROP TABLE IF EXISTS $table;";
            $row2 = $this->conn->query("SHOW CREATE TABLE $table")->fetch_row();
            $sqlScript .= "\n\n" . $row2[1] . ";\n\n";

            while ($row = $result->fetch_row()) {
                $sqlScript .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $numFields; $j++) {
                    $row[$j] = isset($row[$j]) ? addslashes($row[$j]) : '';
                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                    $sqlScript .= '"' . $row[$j] . '"';
                    if ($j < ($numFields - 1)) {
                        $sqlScript .= ',';
                    }
                }
                $sqlScript .= ");\n";
            }
            $sqlScript .= "\n";
        }

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $filePath = $backupDir . '/' . $this->backupFile;
        $gzFile = $filePath . '.gz';

        if (file_put_contents($filePath, $sqlScript)) {
            $gz = gzopen($gzFile, 'w9');
            gzwrite($gz, file_get_contents($filePath));
            gzclose($gz);
            unlink($filePath); // remove .sql, keep only .gz
            return true;
        }
        return false;
    }

    public function obfPrint($msg, $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        $msg = str_repeat(PHP_EOL, $lineBreaksBefore) . $msg . str_repeat(PHP_EOL, $lineBreaksAfter);
        echo $msg;
    }
}

// Run backup
$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, CHARSET);
$result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? 'OK' : 'KO';
$backupDatabase->obfPrint('Backup result: ' . $result, 1);

// Local backup file path (.gz)
$backupFilePath = BACKUP_DIR . '/' . $backupDatabase->backupFile . '.gz';

// Upload to Dropbox
if (file_exists($backupFilePath)) {
    $fp = fopen($backupFilePath, 'rb');
    $size = filesize($backupFilePath);

    $ch = curl_init("https://content.dropboxapi.com/2/files/upload");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $DROPBOX_ACCESS_TOKEN,
        "Content-Type: application/octet-stream",
        "Dropbox-API-Arg: " . json_encode([
            "path" => "/db-backups/" . basename($backupFilePath),
            "mode" => "add",
            "autorename" => true,
            "mute" => false
        ])
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $size));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // ⚠️ Local Wamp testing ke liye SSL verify disable
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "<br>❌ Dropbox Upload Error: " . curl_error($ch);
    } else {
        //echo "<br>✅ Backup uploaded to Dropbox successfully!";
        //echo "Dropbox API Response: " . $response; // Debugging line
    }

    curl_close($ch);
    fclose($fp);
} else {
    echo "<br>❌ Backup file not found!";
}
?>
<a href="index.php">Back</a>
