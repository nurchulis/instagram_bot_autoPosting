<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>



    	<div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab">Home</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Manage Account</a></li>
                            <!--
                            <li><a href="#tab3default" data-toggle="tab">Settings</a></li>
                            !-->
                            <li><a href="#tab4default" data-toggle="tab">Daftar Content</a></li>
                         
                        </ul>
                </div>

                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
                        	<?php include "Home.php" ?>
                        </div>
                        <div class="tab-pane fade" id="tab2default">
                        	<?php include "Manage_account.php" ?>
                        </div>

                        <div class="tab-pane fade" id="tab3default">Default 3</div>

                         <div class="tab-pane fade" id="tab4default">
                        	<?php include "Daftar_posting.php" ?>
                        </div>


 
                    </div>
                </div>
            </div>
        </div>






</body>
</html>

