<?php 
include('Head.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Toaster Testing</title>
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>

<body>

    <!--javascript-->
    <button class="btn btn-success" onclick="success_toastr()">Success</button>

    <script src="plugins/toastr/toastr.min.js"></script>
    <script>
        function success_toastr() {
            toastr.success("Success Message");
        }

    </script>
</body>

</html>
