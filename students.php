<?php
    session_start();

    if(isset($_SESSION['name']) ||($_SESSION['id'])){
    //    header('Lcation:index.php');
    
?>

<!doctype html>
<html>
    <head>
        <title>Students</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="style.css" rel="stylesheet">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script rel="javascript" type="text/javascript" src="jquery/jquery.min.js"></script>
		<!-- JavaScript -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="user_data">
            
            <div class="container">
                <center><h1>welcome <?php echo $_SESSION['name'];?></h1></center>
                <div class="user">
                    <div class="row">
                        <div class="add-btn col-md-6">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addproductmodal">Add Subject</button>
                        </div>
                        <div class="logout-btn col-md-6" style="text-align:end">
                            <a class="btn btn-danger" href="logout.php">Log Out</a>
                        </div>
                    </div>
                    <!-- Add Product Form Model---->
                    <div class="product-modal">
                        <!-- Modal -->
                        <div id="addproductmodal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content my-modal-class">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="color: deepskyblue;">Add New Subject</h4>
                                        <span id="login_error" class="text-danger error"></span>
                                        <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="registration-form">
                                            <form class="form-horizontal" id='Product_form'>
                                                <div class="form-group">
                                                    <label for="product">Subject Name</label>
                                                    <input type="text" class="form-control" name="product" id="product">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Course</label>
                                                    <input type="text" name="description" class="form-control" id="desc">
                                                </div>
                                                <input type="hidden" name="id" id="id" value="<?php echo $_SESSION['id'];?>">
                                                <button type="submit" name="add" class="btn btn-success" id="add">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End-->
                    <center><h2>Subjects</h2></center>
                    <div class="products-list">
                        <table class="table dataTable">
                            <thead class="thead-dark">
                                <th>Sr. No</th>
                                <th>Subject_name</th>
                                <th>Course</th>
                                <th>Oprations</th>
                            </thead>
                            <tbody id="tbl_body">
                            
                            </tbody>
                        </table>
                    </div>
                    
                    <!---======== Product Update Modal ========-->
                    <div class="update-product-modal">
                        <!-- Modal -->
                        <div id="updateproductmodal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content my-modal-class">
                                    <div class="modal-header">
                                        <h4 class="modal-title" style="color: deepskyblue;">Update Subject</h4>
                                        <span class="err-msg text-danger" id="err_msg"></span>
                                        <span class="success-msg text-success" id="success_msg"></span>
                                        <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="registration-form">
                                            <form class="form-horizontal" id='Product_form'>
                                                <div class="form-group">
                                                    <label for="product">Subject Name</label>
                                                    <input type="text" class="form-control product" name="prod" id="product" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Course</label>
                                                    <input type="text" name="description" class="form-control description" id="desc" value="">
                                                </div>
                                                <input type="hidden" name="id" id="update_id" class="product-id" value="<?php echo $_SESSION['id'];?>">
                                                <button type="submit" name="update" class="btn btn-success" id="update">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
            $("document").ready(function(){
            //========= Get subjects Data =======
                var id = $('#id').val();
                var action = 'getdata';
                //alert(id);
                $.ajax({
                    url : 'functions.php',
                    dataType : 'JSON',
                    method : 'POST',
                    async: false,
                    data : 'id='+id+ '&action='+action,
                    success : function(result){
                        console.log(result);
                        $.each(result, function(key, value){
                            var srNo = '';
                                srNo += '<tr><td>'+value.id+'</td>';
                                srNo +='<td>'+value.product_name+'</td>';
                                srNo +='<td>'+value.description+'</td>';
                                srNo +='<td>';
                                srNo +='<button class="btn btn-success edite-btn" style="margin-right:5px" id="'+value.id+'" data-target="#updateproductmodal" data-toggle="modal">Edit</button>';
                                srNo +='<button class="btn btn-danger delete-btn" id="'+value.id+'">delete</button>';
                                srNo +='</td></tr>';
                            $('#tbl_body').append(srNo);
                        });
                    },
                    error : function(result){
                        console.log('something went wrong');
                        console.log(result);
                    },
                });

            //===== Add Subjects ========
               var formdata = $("#addproductmodal");
                formdata.submit(function(e){
                    var product = $("#product").val();
                    var desc = $('#desc').val();
                    var id = $('#id').val();
                    var action = 'add';
                    e.preventDefault();
                    $.ajax({
                        url : 'functions.php',
                        method : 'POST',
                        type : 'json',
                        data : 'id='+id+ '&action='+action+ '&product='+product+ '&desc='+desc ,
                        success : function(result){
                            $('#success_msg').text(result);
                            window.location.href=window.location.href; 
                            console.log(result);
                        },
                        error : function(){
                            console.log(result);
                        },
                    });
                });

                //======== retrive data for update ===========

                $(".edite-btn").on('click', function(){
                    var idAttr = $(this).attr('id');
                    var action = 'edite';
                    $.ajax({
                        url : 'functions.php',
                        method : 'POST',
                        data : 'id=' +idAttr+'&action='+action,
                        success : function(result){
                            //console.log(result);
                            const json = result;
                            const obj = JSON.parse(json);
                            $('.product').val(obj.product_name);
                            $('.description').val(obj.description);
                            $('#update_id').val(obj.id);
                            //console.log(obj.id);
                        },
                        error : function(result){
                            console.log('result');
                        },
                    });
                });

                //=========== Update =========
                var updateData = $('#update');                
					updateData.on('click',function(e){
						e.preventDefault();
                        var product = $('.product').val();
                        var description = $('.description').val();
                        var id = $('.product-id').val();
                        var action = 'update';
                        $.ajax({
                            url : 'functions.php',
                            method : 'POST',
                            data : 'product='+product+'&desc='+description+'&id='+id+'&action='+action,
                            success : function(data){
                                window.location.href=window.location.href; 
                                $('#success_msg').text(data);
                                //console.log(data);
                            },
                            error : function(data){
                                console.log('error ocuured');
                                console.log(data);
                            },
                        });
					});

                //======== delete ======
                
                $(".delete-btn").on('click',function(){
                    var attr = $(this).attr('id');
                    var action = 'delete';
                    $.ajax({
                        url : 'functions.php',
                        method : 'POST',
                        data : 'id='+attr+'&action='+action,
                        success : function(result){
                            alert(result);
                            window.location.href=window.location.href; 
                            //console.log(result);
                        },
                    });
                });

            });
        </script>
    </body>
</html>

<?php 
   }else{
        header('Location:index.php');
    }
?>