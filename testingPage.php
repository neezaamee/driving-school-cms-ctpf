<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>jQuery UI Button - Radios</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script>
        $(function() {
            $("#radio").buttonset();
        });
        $(function() {
            $("#radi").buttonset();
        });

    </script>
</head>

<body>
    <!--<form>
    <div id="radio">
        <input type="radio" id="radio1" name="radio">
        <label for="radio1"><img src="image1.gif" /></label>
        <input type="radio" id="radio2" name="radio">
        <label for="radio2"><img src="image2.gif" /></label>
        <input type="radio" id="radio3" name="radio">
        <label for="radio3"><img src="image3.gif" /></label>
    </div>
</form>-->
    <form>
        <div id="radi">
            <tr>
                <td>
                    <input type="radio" name="ans" value="opt1" id="radio1">
                    <label for="radio1"><img src="<?php echo $row[2] ?>" alt="" class="ansImg"></label>
                </td>
                <td>
                    <input type="radio" name="ans" value="opt2" id="radio2">
                    <label for="radio2"><img src="<?php echo $row[3] ?>" alt="" class="ansImg"></label>
                </td>
                <td>
                    <input type="radio" name="ans" value="opt3" id="radio3">
                    <label for="radio3"><img src="<?php echo $row[4] ?>" alt="" class="ansImg"></label>
                </td>
                <td>
                    <input type="radio" name="ans" value="opt4" id="radio4">
                    <label for="radio4"><img src="<?php echo $row[5] ?>" alt="" class="ansImg"></label>
                </td>
            </tr>
        </div>
    </form>
</body>

</html>
