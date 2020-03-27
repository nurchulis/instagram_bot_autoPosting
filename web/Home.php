<?php
$servername = "localhost";
$username = "nurchulis";
$password = "lina@maulana";
$dbname = "robot_ig";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>
<div class="container" style="margin-bottom: 20px;">

  <form  method="POST" enctype="multipart/form-data" id="form_start_s">
	 <div class="form-group">
      <label for="sel1">Select Content Posting:</label>
      <select class="form-control" name="id_posting" id="sel1">
        <?php 
        $sql = "SELECT * FROM posting ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
        ?>
		<option value="<?php echo $row['id_posting']; ?>"><?php echo $row['id_posting'] ?></option>
        <?php 
    	}
    	}
        ?>
      </select>
      <br>
 	 </div>

	<center>

<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM settings_bot ";
$result = $conn->query($sql);
$count_sql = "SELECT COUNT(*) AS jumlah_account FROM account";
$count_result = $conn->query($count_sql);
$low = $count_result->fetch_assoc();

$count_sql_sudah = "SELECT COUNT(*) AS jumlah_done FROM job_list WHERE status='selesai'";
$count_result_sudah = $conn->query($count_sql_sudah);
$done = $count_result_sudah->fetch_assoc();

$count_sql_belum = "SELECT COUNT(*) AS jumlah_wait FROM job_list WHERE status='belum'";
$count_result_belum = $conn->query($count_sql_belum);
$wait = $count_result_belum->fetch_assoc();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
?>
	<?php if($row['status']=='berhenti'){ ?>

	<button type="submit" style="font-size: 30px;" id="form_start" class="btn btn-primary">Run Posting</button> 
	<p><b><?php echo $low['jumlah_account'] ?></b> Jumlah Account Yang Akan Dijalankan.</p>
	<p>Proses Posting Akan Selesai dalam waktu <b><?php echo $low['jumlah_account'] ?> Menit</b></p>
<?php }else{ ?>
	<button type="button" style="font-size: 30px;" onclick="run_click()" class="btn btn-danger">Stop Posting</button>
	<p>Auto Posting Sedang Berjalan</p>
	<p>Anda Bisa Membantalkan nya Sebelum 1 Menit</p>

	<center><b><?php echo $done['jumlah_done'] ?> Selesai / <?php echo $wait['jumlah_wait'] ?> Jumlah Postingan</b></center>
	<p>Proses Akan Selesai Dalam Waktu <?php echo round($wait['jumlah_wait']*60/3600) ?> Jam</p>
<?php } ?>
<?php
    }
} else {
    echo "0 results";
}

$conn->close();
?>
	</center>
</form>

    <div class="container">
  <h2>Log Activity</h2>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Id_log</th>
        <th>Id_account</th>
        <th>Activity</th>
        <th>status</th>
        <th>tgl</th>

      </tr>
    </thead>
    <tbody>
    
<?php
$servername = "localhost";
$username = "nurchulis";
$password = "lina@maulana";
$dbname = "robot_ig";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM log_job ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
?>
      <tr>
        <td><?php echo $row["id_log_job"] ?></td>
        <td><?php echo $row["id_account"] ?></td>
       	<td>Posting</td>
       	<td style="color:#2ecc71"><b><?php echo $row["status"] ?></b></td>
       	<td><?php echo $row["created_at"] ?></td>
      </tr>
<?php
    }
} else {
    echo "0 results";
}

$conn->close();
?>
</tbody>
</table>
</div>



<script type="text/javascript">
  $(document).ready(function () {
    $("#form_start").click(function (event) {
        //stop submit the form, we will post it manually.
        event.preventDefault();
        // Get form
        var form = $('#form_start_s')[0];
    // Create an FormData object 
        var data = new FormData(form);
    // If you want to add an extra field for the FormData
        data.append("CustomField", "This is some extra data, testing");
    // disabled the submit button
        $("#form_start").prop("disabled", true);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "http://127.0.0.1:5000/run_start_form",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {  
                $("#result").text(data);
                console.log("SUCCESS : ", data);
                if(data.status == 'success'){
                Swal.fire({
                  title: 'Success!',
                  text: 'Update berhasil',
                  icon: 'success',
                  confirmButtonText: 'Okey'}).then(okay=>{
                  if(okay){
                    location.reload();
                  }
                });
                } else {
                  Swal.fire({
                  title: 'Gagal!',
                  text: 'Opps produk gagal diupload',
                  icon: 'error',
                  confirmButtonText: 'Okey'
                });
                }
                $("#form_start").prop("disabled", false);
            },
            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#form_start").prop("disabled", false);
            }
        });
    });
});
</script>





	<script>
    
   function run_click() {

      Swal.fire({
            title: 'Are you sure?',
  text: "Saat Proses Posting Jangan Dihentikan Sebelum Selesai!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Ganti Status'
           })
          .then((result) => {
      if (result.value) {
        $.get("http://127.0.0.1:5000/runstop", function(data, status){
                  if(data.status == 'success'){
                Swal.fire({
                  title: 'Success!',
                  text: 'Update berhasil',
                  icon: 'success',
                  confirmButtonText: 'Okey'}).then(okay=>{
                  if(okay){
                    location.reload();
                  }
                });
                } else {
                  Swal.fire({
                  title: 'Gagal!',
                  text: 'Opps produk gagal diupload',
                  icon: 'error',
                  confirmButtonText: 'Okey'
                });
                }
            });
            

               } else {
                      swal("Your imaginary file is safe!");
           }
        });
}
    
</script>

</div>


