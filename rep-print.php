><body>
<body onload="self.print()">
<?php  $id=0; if(isset($_REQUEST['start'])) { $strt=$_REQUEST['start']; $end=$_REQUEST['end']; $todayDate = date("d-m-Y"); $repo_time = date("h:i:s"); echo "Date... : " , $todayDate, ".....................Report Time... : ", $repo_time; ?>
<table class="hovertable">
<tr>

<th>Sr # </th>
<th>Token No </th>
<th>Name         </th>
<th>Father/Husband Name      </th>
<th>Applied for    </th>
<th>Ticket Cost    </th>
<th>Signs Test   </th>
<th>Road Test   </th>
<th>Result  </th>

</tr>
<?php  $rec_limit = 200; $sql = "SELECT count(id) FROM candata "; $retval = mysql_query( $sql ); $row = mysql_fetch_array($retval, MYSQL_NUM ); $rec_count = $row[0]; if( isset($_GET['page'] ) ) { $page = $_GET['page']; $offset = $rec_limit * $page ; } else { $page = 0; $offset = 0; } $left_rec = $rec_count - ($page * $rec_limit); $sql="SELECT * from candata where date BETWEEN '".$strt."' AND '".$end."' ORDER BY token ASC "; $abs=mysql_query($sql); while($asp=mysql_fetch_array($abs)) { $id = $id+1; $tkno=$asp['token']; $nme=$asp['name']; $fhnam=$asp['fwdname']; $lic_cat=$asp['liccat']; $tkts=$asp['tktcost']; $sgn_tst=$asp['sgntst']; $rd_tst=$asp['rdtest']; $f_res =$asp['fnlres'] ?>
<tr>
<td><?php echo $id?></td>
<td><?php echo $tkno?></td>
<td><?php echo $nme?></td>
<td><?php echo $fhnam?></td>
<td><?php echo $lic_cat?></td>
<td>&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $tkts?></td>
<td><?php echo $sgn_tst?></td>
<td><?php echo $rd_tst?></td>
<td><?php echo $f_res?></td>

</tr>


<?php } ?>

</table>


<div class="pagi">
<?php  if($rec_count > $rec_limit) { if($page > 0) { if($left_rec <= $rec_limit) { $last = $page - 1; echo "<a href=\"?page=$last\">Previous Records</a>"; } else { $last = $page - 1; $page=$page+1; echo "<a href=\"?page=$last\">Previous Records</a> "; echo "<a href=\"?page=$page\">Next  Records</a>"; } } else if($page == 0) { $page=$page+1; echo "<a href=\"?page=$page\">Next  Records</a>"; } } } ?>
</div>
</div>
</body>