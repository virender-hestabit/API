<?php include('header.php');?>
<?php include('sidemenu.php');?>
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Manage Disease Category</h1>
        </div>
        
        <div class="container-fluid">
            <div class="row-fluid">

	<div class="row-fluid">
	</div>
<div class="row-fluid">&nbsp;</div>
<div class="well">
  <?php if(isset($msg) && !empty($msg)){ ?>
  <h4 class="alert alert-info" style="text-align: center"><?php echo $msg;?></h4>
  <?php } ?>

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home" align="center" >
                  <?php if(isset($edit_category) && $edit_category[0]['id']!=''){
                          $form=array('class'=>'form-element','role'=>'form');echo form_open('admin/editCategory', $form);
                        }else{
                          $form=array('class'=>'form-element','role'=>'form');echo form_open('admin/addCategory', $form);
                        } ?>
                  <div class="form-group" >       
                  <input type="hidden" name="category_id" value="<?php echo (isset($edit_category) && $edit_category[0]['id']!='')?$edit_category[0]['id']:''; ?>">
                  <input type="text" class="form-control" name="category" placeholder="Enter Disease Category" value="<?php echo (isset($edit_category) && $edit_category[0]['id']!='')?$edit_category[0]['category_name']:''; ?>" >
                  </div>
                  <div class="form-group" align="center" >
                    <select class="form-control" name="cat_status" required>
                        <option value="" >Select Category Status</option>
                        <option value="1" >Active</option>
                        <option value="0" >Inactive</option>
                        
                    </select>
                  </div>
                  <div class="form-group" align="center" >
                  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
              </div>
         <?php echo form_close();?>
          </div>
           <div class="tab-pane fade" id="profile">
      </div>
  </div>

</div>


<p class="block-heading">Disease Cagegory List</p>
  <div class="well">
    <table class="table">
      <thead>
      <tr>
                  <th width="20%">S NO.</th>
                  <th width="20%">Disease Category Name</th>
                  <th width="20%">Created By</th>
                  <th width="20%">Created on</th>
                  <th width="20%" style="text-align: center;">Status</th>
                  <th width="20%" style="text-align: center;">Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  
                  <?php if(sizeof($dataArr)>0){  
                    $i=0;
                    foreach($dataArr as $data){ ?>
                      <tr>
                      <td width="20%"><?php echo ++$i;?></td>
                      <td width="20%"><?php echo $data['category_name'];?></td>
                      <td width="20%"><?php echo $data['username'];?></td>
                      <td width="20%"><?php echo $data['created_on'];?></td>
                      <td width="20%" style="text-align: center;">
                          <?php if($data['status'] == '1'){ ?>

                            <button class="btn btn-success user_status" onclick="Status(0,<?php echo $data['id'];?>);" uid="<?php echo $data['status']; ?>"  ustatus="<?php echo $data['status']; ?>">Active</button>
                                   
                          <?php }else{ ?>

                            <button class="btn btn-primary user_status" onclick="Status(1,<?php echo $data['id'];?>); "uid="<?php   echo $data['status']; ?>"  ustatus="<?php echo $data['status']; ?>">Inactive
                            </button>
                          <?php } ?>
                      </td>
                      <td width="20%" style="text-align: center;"><a href="<?php echo base_url('admin/editCategory/'.$data['id']); ?>" title="Edit" ><i class="fa fa-edit" style="font-size:14px; margin-left:20px;"></i></a>
                        <a href="<?php echo base_url('admin/deleteCategory/'.$data['id']); ?>" title="Delete" onclick="return confirm('Are you want to delete!');"><i class="fa fa-trash" style="font-size:14px; margin-left:20px;"></i></a>
                      </td>
                      
                      </tr>
                    <?php } } else{
                   echo "<tr><td colspan='5'><h4 align='center'>No Record Found</h4></td></tr>";
                  } ?>
      </tbody>
    </table>
  </div>
            </div>
        </div>
    </div>
    
<?php require('footer.php'); ?>

    <script src="<?php echo base_url('application/assests/lib/bootstrap/js/bootstrap.js');?>"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });

        //Status handler
          function Status(statusId,cate_id){ 
              // var statusIds = $('#'+statusId).val();
              if(confirm("What you want to change the status!")){
                var url = "<?php echo base_url('/admin/update_cate_status');?>";
                $.ajax({
                      url : url,
                      type : 'POST',
                      data : {statusId:statusId,cate_id:cate_id},
                  success: function(data){
                    if(data == '1'){
                      location.reload();
                    }else{
                      alert();
                    }
                    
                    
                    // if(data == 1){
                    //   $('#'+data).text('Inactive')
                    // }else{
                    //   $('#'+data).text('active')
                    // }
                    //$("#suggesstion-box").show();
                    // $("#suggesstion-box").html(data);
                    // $("#search-box").css("background","white");
                  }
                });
              }
            }
    </script>
    
  </body>
</html>