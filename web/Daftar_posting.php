
<div class="container">
  <h3>Tambah Posting Content</h3>
  <form  method="POST" enctype="multipart/form-data" id="slider_input_posting">
  <div class="form-group">
    <label for="exampleInputEmail1">Photo</label>
    <input type="file" name="image" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">Chose your photo.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Caption</label>
    <input type="hidden" name="status" value="1">
    <input type="hidden" name="kategori" value="posting">
 <textarea class="form-control" name="caption" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
<button type="submit" class="btn btn-primary" name="msg" placeholder="Additional Info" id="btnsliderSubmit_input_posting">Tambahkan</button>
</form>



  <br>
</div>


   
    <div class="container">
  <h2>Daftar Posting</h2>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Id Posting</th>
        <th>Caption</th>
        <th>Photo</th>
        <th>Edit</th>

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

$sql = "SELECT * FROM posting ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
?>
      <tr>
        <td><?php echo $row["id_posting"] ?></td>
        <td><?php echo $row["caption"] ?></td>
        <td><img src="http://localhost/cron/insta/photo/<?php echo $row['photo']; ?>" style="width: 200px;"></td>
        <td>
          <button class="btn btn-primary">Edit</button>
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
    $("#btnsliderSubmit_input_posting").click(function (event) {
        //stop submit the form, we will post it manually.
        event.preventDefault();
        // Get form
        var form = $('#slider_input_posting')[0];
    // Create an FormData object 
        var data = new FormData(form);
    // If you want to add an extra field for the FormData
        data.append("CustomField", "This is some extra data, testing");
    // disabled the submit button
        $("#btnsliderSubmit_input_posting").prop("disabled", true);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "http://127.0.0.1:5000/posting_data",
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
                $("#btnsliderSubmit_input_posting").prop("disabled", false);
            },
            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnsliderSubmit_input_posting").prop("disabled", false);
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
        $.get("http://127.0.0.1:5000/hapus_posting?id_account="+clicked_id, function(data, status){
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
