<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <style>
        #results { padding:10px; border:1px solid #ccc; background:#f8f9fa; min-height: 200px; }
        #results img { max-width: 100%; height: auto; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1 class="m-0 text-dark">Capture Student Photo</h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header"><h3 class="card-title">Photo Capture Interface</h3></div>
                                <div class="card-body">
                                <?php
                                if (isset($_POST['image']) && isset($_POST['cnic'])) {
                                    $img = $_POST['image'];
                                    $cnic = CleanData($_POST['cnic']);
                                    $folderPath = "StudentImages/";

                                    if (!empty($img) && !empty($cnic)) {
                                        $image_parts = explode(";base64,", $img);
                                        $image_base64 = base64_decode($image_parts[1]);
                                        $fileName = $cnic . '.JPG'; // Consistent with display expectations
                                        $file = $folderPath . $fileName;

                                        if (file_put_contents($file, $image_base64)) {
                                            echo "<div class='alert alert-success'>Photo captured and saved successfully for CNIC: $cnic</div>";
                                        } else {
                                            echo "<div class='alert alert-danger'>Error saving photo file. Check directory permissions.</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-warning'>CNIC or Image data missing.</div>";
                                    }
                                    echo "<script>setTimeout(function(){ window.location.href='addPhoto.php'; }, 2000);</script>";
                                } else {
                                    ?>
                                    <form method="POST" action="addPhoto.php">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="my_camera" style="margin: auto;"></div>
                                                <br/>
                                                <button type="button" class="btn btn-info btn-block" onClick="take_snapshot()">Take Snapshot</button>
                                                <input type="hidden" name="image" class="image-tag" required>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="results" class="text-center">Captured image will appear here...</div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3">
                                                <div class="form-group">
                                                    <label>Student CNIC</label>
                                                    <input type="number" name="cnic" class="form-control" placeholder="13 Digits without dash" required autofocus>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-block">Save Photo</button>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include('footer.php') ?>
    </div>
    <?php include('footerPlugins.php') ?>
    <script>
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach( '#my_camera' );

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            } );
        }
    </script>
</body>
</html>