
<?php include('header.php');?><?php include('sidemenu.php');?>
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Add WBS</h1>
        </div>
        
        <div class="container-fluid">
            <div class="row-fluid">

	<div class="row-fluid">
	</div>
<div class="row-fluid">&nbsp;</div>
<div class="well">

    <table class="table" width="100%">
    <thead width="100%">
      <tr>
        <th width="33.3%" style="text-align: center">Category Type</th>
        <th width="33.3%" style="text-align: center">Name</th>
        <th width="33.3%" style="text-align: center">Total Price</th>
      </tr>
    </thead>







<?php $i=0;?>

   <!-- for category cost -->
<?php $category_ids = $this->Database_conn2->getallcategory('category_id');?>

<?php if(isset($category_ids))
{
foreach ($category_ids as $cat_id) 
{ 
$cat_cost = $this->Database_conn2->get_total_cost($cat_id['category_id']);
?>
<tr><th style="padding-left:60px;" colspan="3"><strong>S.no <?php echo ++$i;?> <br></strong></th></tr>
<tr>
<td width="33.3%" style="text-align: center">Category Name</td>
<td width="33.3%" style="text-align: center"><?php $cat = $this->Database_conn2->get_subcat_name('wbs_category',$cat_id['category_id']);
         if(isset($cat['0']['category_name']))
        echo $cat['0']['category_name'];
      ?></td>
<td width="33.3%" style="text-align: center"><?php echo $cat_cost['0']['sum(estimated_cost)'];?></td>
</tr>
           











   <!-- for subcat1 cost -->
<?php    
$subcategory1_ids = $this->Database_conn2->getallcategory('subcat_id1',$cat_id['category_id']);
if(isset($subcategory1_ids))
{
foreach ($subcategory1_ids as $subcat1 ) 
{
  if($subcat1['subcat_id1']!='0')
  {
$subcat1_cost = $this->Database_conn2->get_total_cost($cat_id['category_id'],$subcat1['subcat_id1']);
?>
<tr>
<td width="33.3%" style="text-align: center">Subcategory1 Name</td>
<td width="33.3%" style="text-align: center"><?php $cat1 = $this->Database_conn2->get_subcat_name('wbs_sub_category1',$subcat1['subcat_id1']);
       if(isset($cat1['0']['sub_category_name1']))
        echo $cat1['0']['sub_category_name1'];
      ?></td>
<td width="33.3%" style="text-align: center"><?php echo $subcat1_cost['0']['sum(estimated_cost)'];?></td>
</tr>












 <!-- for subcat2 cost -->              
<?php }   
$subcategory2_ids = $this->Database_conn2->getallcategory('subcat_id2',$cat_id['category_id'],$subcat1['subcat_id1']);
if(isset($subcategory2_ids))
{
foreach ($subcategory2_ids as $subcat2 ) 
{
  if($subcat2['subcat_id2']!='0')
  {
$subcat2_cost = $this->Database_conn2->get_total_cost($cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2']);
?>

<tr>
<td width="33.3%" style="text-align: center">Subcategory2 Name</td>
<td width="33.3%" style="text-align: center"><?php $cat2 =  $this->Database_conn2->get_subcat_name('wbs_sub_category2',$subcat2['subcat_id2']);
    if(isset($cat2['0']['sub_category_name2']))
       echo $cat2['0']['sub_category_name2'];
    ?></td>
<td width="33.3%" style="text-align: center"><?php echo $subcat2_cost['0']['sum(estimated_cost)'];?></td>
</tr>                                               
















<!-- for subcat3 cost -->
<?php   } 
$subcategory3_ids = $this->Database_conn2->getallcategory('subcat_id3',$cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2']);
if(isset($subcategory3_ids))
{
foreach ($subcategory3_ids as $subcat3 ) 
{
    if($subcat3['subcat_id3']!='0')
  {
$subcat3_cost = $this->Database_conn2->get_total_cost($cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2'],$subcat3['subcat_id3']);

?>

<tr>
<td width="33.3%" style="text-align: center">Subcategory3 Name</td>
<td width="33.3%" style="text-align: center"><?php $cat3 = $this->Database_conn2->get_subcat_name('wbs_sub_category3',$subcat3['subcat_id3']);
      if(isset($cat3['0']['sub_category_name3']))
        echo $cat3['0']['sub_category_name3'];
      ?></td>
<td width="33.3%" style="text-align: center"><?php echo $subcat3_cost['0']['sum(estimated_cost)'];?></td>
</tr>














<!-- for subcat4 cost -->
<?php }  
$subcategory4_ids = $this->Database_conn2->getallcategory('subcat_id4',$cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2'],$subcat3['subcat_id3']);
if(isset($subcategory4_ids))
{
foreach ($subcategory4_ids as $subcat4 ) 
{
  if($subcat4['subcat_id4']!='0')
  {
$subcat4_cost = $this->Database_conn2->get_total_cost($cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2'],$subcat3['subcat_id3'],$subcat4['subcat_id4']);

?>

<tr>
<td width="33.3%" style="text-align: center">Subcategory4 Name</td>
<td width="33.3%" style="text-align: center"><?php $cat4 = $this->Database_conn2->get_subcat_name('wbs_sub_category4',$subcat4['subcat_id4']);
     if(isset($cat4['0']['sub_category_name4']))
      echo $cat4['0']['sub_category_name4'];
    ?></td>
<td width="33.3%" style="text-align: center"><?php echo $subcat4_cost['0']['sum(estimated_cost)'];?></td>
</tr>
















<!-- for subcat5 cost -->
<?php    }
$subcategory5_ids = $this->Database_conn2->getallcategory('subcat_id5',$cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2'],$subcat3['subcat_id3'],$subcat4['subcat_id4']);
if(isset($subcategory5_ids))
{
foreach ($subcategory5_ids as $subcat5 ) 
{
   if($subcat5['subcat_id5']!='0')
  {
$subcat5_cost = $this->Database_conn2->get_total_cost($cat_id['category_id'],$subcat1['subcat_id1'],$subcat2['subcat_id2'],$subcat3['subcat_id3'],$subcat4['subcat_id4'],$subcat5['subcat_id5']);

?>

<tr>
<td width="33.3%" style="text-align: center">Subcategory5 Name</td>
<td width="33.3%" style="text-align: center"><?php $cat5 =  $this->Database_conn2->get_subcat_name('wbs_sub_category5',$subcat5['subcat_id5']);
     if(isset($cat5['0']['sub_category_name5']))
      echo $cat5['0']['sub_category_name5'];
    ?></td>
<td width="33.3%" style="text-align: center"><?php echo $subcat5_cost['0']['sum(estimated_cost)'];?></td>
</tr>










                 
  <?php } } } } } } } } } } } } } ?>

    </table>
  </div>
 

            </div>
        </div>
    </div>
    
<?php require('footer.php'); ?>

    
    <script type="text/javascript">
 
 $(document).ready(function(){
    $("#category").click(function(){
        $(".subcat1").toggle();
    });
});

 

        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>