<?php include('header.php');?>
<?php include('sidemenu.php');?>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 20px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0px;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 20px;
  left: 2px;
  bottom: 1px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Manage Google Adsence</h1>
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
      <div class="tab-pane active in" id="home" >
                  <?php if(isset($edit_add) && $edit_add[0]['id']!=''){
                          $form=array('class'=>'form-element','role'=>'form');echo form_open('admin/editGoogleAdsence', $form);
                        }else{
                          $form=array('class'=>'form-element','role'=>'form');echo form_open('admin/googleAdsence', $form);
                        } ?>
          <div class="form-group" align="center" >
            <select class="form-control" name="page" id="page" required onchange="show_position();">
              <option value="" >Select Page</option>
              <option value="home" <?php echo (isset($edit_add) && $edit_add[0]['page']=='home')?'selected':'';?> >Home Page</option>
              <option value="listing" <?php echo (isset($edit_add) && $edit_add[0]['page']=='listing')?'selected':'';?> >Disease Listing Page</option>
              <option value="detail" <?php echo (isset($edit_add) && $edit_add[0]['page']=='detail')?'selected':'';?> >Disease Detail Page</option>
            </select>
          </div>


          <div class="form-group" align="center" >
            <select class="form-control position" name="position" id="position">
              <option value="" >Select Position</option>
            </select>
          </div>
          
          <div class="form-group" align="center" >       
            <textarea class="form-control" name="add_script"  required><?php echo (isset($edit_add) && $edit_add[0]['add_script']!='')?html_entity_decode($edit_add[0]['add_script']):'';?></textarea>
          </div>
          <div class="form-group" align="center" >
            <select class="form-control" name="publish_status" required>
                <option value="1" <?php echo (isset($edit_add) && $edit_add[0]['publish_status']=='1')?'selected':'';?> >Published</option>
                <option value="0" <?php echo (isset($edit_add) && $edit_add[0]['publish_status']=='1')?'selected':'';?> >Not Published</option>
            </select>
          </div>
          <div class="form-group" align="center" >
            <input type="hidden" name="add_id" value="<?php echo (isset($edit_add) && $edit_add[0]['id']!='')?$edit_add[0]['id']:''; ?>">
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


<p class="block-heading">Google Add Listing</p>
  <div class="well">
    <table class="table">
      <thead>
      <tr>
                  <th width="10%">S No.</th>
                  <th width="10%">Pages</th>
                  <th width="10%">Position</th>
                  <th width="20%">Script</th>
                  <th width="10%">Publish Status</th>
                  <th width="10%" style="text-align: center;">Publish Action</th>
                  <th width="10%">Created on</th>
                  <th width="20%" style="text-align: center;">Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  
                  <?php if(sizeof($dataArr)>0){  
                    $i=0;
                    foreach($dataArr as $data){ ?>
                      <tr>
                      <td width="10%"><?php echo ++$i;?></td>
                      <td width="20%"><?php echo $data['page'];?></td>
                      <td width="20%"><?php echo $data['position'];?></td>
                      <td width="20%"><?php echo $data['add_script'];?></td>
                      <td width="15%" id="checkbox_status_<?php echo $data['id'];?>"><?php echo ($data['publish_status']==0)?'Not Published':'Published';?></td>
                      <td width="15%" style="text-align: center;">
                        <label class="switch">
                          <input type="checkbox" id="checkbox_<?php echo $data['id'];?>"  value="<?php echo $data['publish_status'];?>" <?php echo ($data['publish_status']==1)?'checked':'';?> onclick="Status(<?php echo $data['id'];?>);">
                          <span class="slider round"></span>
                        </label>
                      </td>
                      <td width="20%"><?php echo $data['created_on'];?></td>
                      <td width="15%" style="text-align: center;"><a href="<?php echo base_url('admin/editGoogleAdsence/'.$data['id']); ?>" title="Edit" ><i class="fa fa-edit" style="font-size:14px;"></i></a>
                        <a href="<?php echo base_url('admin/deleteGoogleAdsence/'.$data['id']); ?>" title="Delete" onclick="return confirm('Are you want to delete!');"><i class="fa fa-trash" style="font-size:14px; margin-left:10px;"></i></a>
                      </td>

                      </tr>
                    <?php } } else{
                   echo "<tr><td colspan='8'><h4 align='center'>No Record Found</h4></td></tr>";
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

        function Status(id){ 
            var publish_val = $("#checkbox_"+id).val();
            publish_val = (publish_val==1)?0:1;
            $("#checkbox_"+id).val(publish_val);
            var publish_status = (publish_val==1)?'Published':'Not Published';
            $("#checkbox_status_"+id).text(publish_status);
            var url = "<?php echo base_url('/admin/update_publish_status');?>";
            $.ajax({
                  url : url,
                  type : 'POST',
                  data : {publish_status:publish_val,id:id,table:'google_adsence'},
                 
              success: function(data){
              }
            });
            }

function show_position()
{
  page = $("#page").val();
  if(page=='home')
  {
    var option = "<option value='center'>Center</option>";
    $("#position").html(option);
  }
  else
  {
    var option = "<option value='top'>Top</option>";
    option += "<option value='side'>Side</option>";
    option += "<option value='bottom'>Bottom</option>";
    $("#position").html(option);
  }
}

    </script>
    
  </body>
</html>