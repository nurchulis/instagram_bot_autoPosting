
<div class="container">
  <h3>Add Accounts</h3>
  <p>Pastikan Menonakfitfkan Two Factor Authentifiaction Di instagram</p>
  <form  method="POST" enctype="multipart/form-data" id="slider_input_s">
    <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      <input id="text" type="text" class="form-control" name="username" placeholder="Username instagram">
    </div>
    <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      <input id="password" type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <br>
    <div class="input-group">

      <button type="submit" class="btn btn-primary" name="msg" placeholder="Additional Info" id="btnsliderSubmit_input">Simpan</button>
    </div>
  </form>
  <br>
</div>


   
    <div class="container">
  <h2>Daftar User</h2>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Akses User</th>
        <th>Password User</th>
        <th>Username IG</th>
        <th>Status Account</th>
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

$sql = "SELECT * FROM account ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
?>
      <tr>
        <td><?php echo $row["id_account"] ?></td>
        <td><?php echo $row["username"] ?></td>
        <td>**********</td>
        <td>
        	<?php if($row['status']=='1'){?>
        		<button id="<?php echo $row["id_account"] ?>"  type="button" onClick="reply_clicks(<?php echo $row["id_account"] ?>)" class="btn btn-danger">NonAktifkan</button>
        	<?php } else { ?>
        		<button id="<?php echo $row["id_account"] ?>"  type="button" onClick="reply_clicks(<?php echo $row["id_account"] ?>)" class="btn btn-success">Aktifkan</button>
        	<?php } ?>

          <button id="<?php echo $row["id_account"] ?>" class="btn btn-danger notika-btn-danger hapus" onClick="reply_click(<?php echo $row["id_account"] ?>)">Hapus</button>

        </td>
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




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


<script type="text/javascript">
  $(document).ready(function () {
    $("#btnsliderSubmit_input").click(function (event) {
        //stop submit the form, we will post it manually.
        event.preventDefault();
        // Get form
        var form = $('#slider_input_s')[0];
    // Create an FormData object 
        var data = new FormData(form);
    // If you want to add an extra field for the FormData
        data.append("CustomField", "This is some extra data, testing");
    // disabled the submit button
        $("#btnsliderSubmit_input").prop("disabled", true);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "http://127.0.0.1:5000/login",
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
                $("#btnsliderSubmit_input").prop("disabled", false);
            },
            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnsliderSubmit_input").prop("disabled", false);
            }
        });
    });
});
</script>


<script>
    
   function reply_click(clicked_id) {

      Swal.fire({
            title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
           })
          .then((result) => {
      if (result.value) {
        $.get("http://127.0.0.1:5000/hapus_account?id_account="+clicked_id, function(data, status){
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

<script>
    
   function reply_clicks(clicked_id) {

      Swal.fire({
            title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Ganti Status'
           })
          .then((result) => {
      if (result.value) {
        $.get("http://127.0.0.1:5000/aktifandnon?id_account="+clicked_id, function(data, status){
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
