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
                                if (isset($_POST['cnic']) && (!empty($_POST['image']) || !empty($_FILES['upload_image']['tmp_name']))) {
                                    if (!isset($_POST['csrf']) || !verify_csrf_token($_POST['csrf'])) {
                                        die("<div class='alert alert-danger'>Security Error: Invalid CSRF token.</div>");
                                    }
                                    
                                    $cnic = CleanData($_POST['cnic']);
                                    $folderPath = "StudentImages/";

                                    if (!empty($_FILES['upload_image']['tmp_name'])) {
                                        $imgData = file_get_contents($_FILES['upload_image']['tmp_name']);
                                    } else {
                                        $img = $_POST['image'];
                                        $image_parts = explode(";base64,", $img);
                                        $imgData = base64_decode($image_parts[1]);
                                    }

                                    $imgResource = @imagecreatefromstring($imgData);
                                    if ($imgResource) {
                                        $width = imagesx($imgResource);
                                        $height = imagesy($imgResource);
                                        $maxDim = 400; // Resize to max 400px to help compression
                                        
                                        if ($width > $maxDim || $height > $maxDim) {
                                            $ratio = $width / $height;
                                            if ($ratio > 1) {
                                                $newWidth = $maxDim;
                                                $newHeight = $maxDim / $ratio;
                                            } else {
                                                $newHeight = $maxDim;
                                                $newWidth = $maxDim * $ratio;
                                            }
                                            $newImg = imagecreatetruecolor((int)$newWidth, (int)$newHeight);
                                            $bg = imagecolorallocate($newImg, 255, 255, 255);
                                            imagefill($newImg, 0, 0, $bg);
                                            imagecopyresampled($newImg, $imgResource, 0, 0, 0, 0, (int)$newWidth, (int)$newHeight, $width, $height);
                                            imagedestroy($imgResource);
                                            $imgResource = $newImg;
                                        }

                                        $file = $folderPath . $cnic . '.JPG';
                                        $quality = 90;
                                        $tempFile = $file . '.tmp';
                                        
                                        do {
                                            imagejpeg($imgResource, $tempFile, $quality);
                                            $sizeKB = filesize($tempFile) / 1024;
                                            $quality -= 10;
                                        } while ($sizeKB > 50 && $quality >= 10);

                                        rename($tempFile, $file);
                                        imagedestroy($imgResource);
                                        echo "<div class='alert alert-success'>Photo saved successfully for CNIC: ".e($cnic)." (Size: ".number_format($sizeKB, 1)." KB)</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Invalid image format.</div>";
                                    }
                                    echo "<script>setTimeout(function(){ window.location.href='addPhoto.php'; }, 3000);</script>";
                                } else {
                                    ?>
                                    <form method="POST" action="addPhoto.php" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf" value="<?php echo generate_csrf_token(); ?>">
                                        <div class="row">
                                            <div class="col-md-6 text-center border-right">
                                                <h5 class="text-primary mb-3"><i class="fas fa-camera"></i> Option 1: Web Camera</h5>
                                                <div id="my_camera" style="margin: auto;"></div>
                                                <br/>
                                                <button type="button" class="btn btn-info btn-block" onClick="take_snapshot()">Take Snapshot</button>
                                                <input type="hidden" name="image" class="image-tag">
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <h5 class="text-success mb-3"><i class="fas fa-upload"></i> Option 2: Upload File</h5>
                                                <div class="form-group text-left" style="max-width:320px; margin:auto;">
                                                    <label for="upload_image">Select Image from Device</label>
                                                    <input type="file" name="upload_image" id="upload_image" class="form-control-file" accept="image/*" onchange="preview_upload(this)">
                                                    <small class="text-muted text-left d-block mt-2">Image will be automatically compressed to under 50KB.</small>
                                                </div>
                                                <hr>
                                                <h5 class="text-secondary">Preview</h5>
                                                <div id="results" class="text-center d-flex align-items-center justify-content-center" style="min-height: 200px; border: 1px dashed #ccc; background: #f8f9fa;">
                                                    <span class="text-muted">Captured or selected image will appear here...</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3">
                                                <div class="form-group">
                                                    <label>Student CNIC</label>
                                                    <input type="number" name="cnic" class="form-control" placeholder="13 Digits without dash" required autofocus>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Save Photo</button>
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
        if (document.getElementById('my_camera')) {
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach( '#my_camera' );
        }

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('upload_image').value = ''; // clear file input
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
            } );
        }

        function preview_upload(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".image-tag").val(''); // clear webcam input
                    document.getElementById('results').innerHTML = '<img src="'+e.target.result+'"/>';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>