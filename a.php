<!doctype html>
<html>

<head lang="en">
    <?php
    include('Head.php');
    ?>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $("#uploadForm").on('submit', (function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "upload.php"
                        , type: "POST"
                        , data: new FormData(this)
                        , contentType: false
                        , cache: false
                        , processData: false
                        , success: function (data) {
                            $("#targetLayer").html(data);
                        }
                        , error: function () {}
                    });
                }));
            });
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <form id="uploadForm" action="upload.php" method="post">
        <label>Upload Image File:</label>
        <br />
        <input name="userImage" type="file" class="inputFile" />
        <input type="submit" value="Submit" class="btnSubmit" /> </form>
</body>

</html>