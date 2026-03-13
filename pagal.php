<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
?>
<!--Token Table-->
<div class="printToken" style="width: 400px; height: 400px; margin: auto;">
    <table class="table table-bordered">
        <th colspan="2" class="text-center">
            <h2>Result</h2>
        </th>
        <tr>
            <th>Total Questions</th>
            <td>
                <?php echo $totalQuestion; ?>
            </td>
        </tr>
        <tr>
            <th>True</th>
            <td>
                <?php echo $totalTrue; ?>
            </td>
        </tr>
        <tr>
            <th>Not Answered</th>
            <td>
                <?php echo $notAnswered; ?>
            </td>
        </tr>
        <tr>
            <th>Total Wrong</th>
            <td>
                <?php echo $wrong; ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">
                <h2>
                    <?php echo "You are ".$signTestResult; ?>
                </h2>
            </th>
        </tr>
        <tr>
            <th colspan="2" class="text-center">Developed by: IT Branch CTPF</th>
        </tr>
    </table>
    <!-- <a href="index.php">Back</a>-->
</div>
<!--/Token Table-->echo "
<h1 align=center><a href=review.php> Review Question</a> </h1>"; echo "
<h1 align=center><a href=printSignTestResult.php> Print Token</a> </h1>";
