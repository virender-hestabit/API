<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	
	public function index(){
		    return redirect('admin/login');
	}

  public function login(){
    if(isset($this->session->username))
      return redirect('admin/dashboard');

      if(!isset($this->session->username)){   
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        
        if(!isset($username) || !isset($password))
          return $this->load->view('login');

        if(isset($username) && isset($password)){
          $condition =array('username'   => $username,'password'   => $this->encrypt($password));
          $check=$this->Database_conn->check_login($condition);  
        
          if(isset($check) && sizeof($check)>0){   
            $username = $check->username;
            $id = $check->id;
            $this->session->set_userdata('username',$username);
            $this->session->set_userdata('user_id',$id);
                return redirect('admin/dashboard');          }
          else{ 
            $data['msg']="Invalid login credential.";
            return $this->load->view('login',$data);
          }
        }
      }  
  }

  public function dashboard()
  {
    if(isset($this->session->user_id))
      return $this->load->view('dashboard');
    else
      redirect('admin/login');
  }

  public function addCategory($msg='')
  {
  
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      $submit = $this->input->post('submit');
      $category = $this->input->post('category');
      $cate_status = $this->input->post('cat_status');
      if(isset($submit))
      {
        if(!$this->Database_conn->getData('wbs_category',array('category_name'=>$category))){
          $data = array('category_name' => $category ,'status'=>$cate_status, 'created_by' => $this->session->user_id , 'created_on'=>date('y-m-d H:i:s'));
          $insert = $this->Database_conn->insert('wbs_category',$data);
          $data['msg'] = 'Disease Category Inserted Successfully';
        }
        else
          $data['msg'] = 'Disease Category Already exist';
      }
      $data['dataArr'] = $this->Database_conn->category();
      return $this->load->view('category',$data);
  }

  public function editCategory($category_id = 0 , $msg='')
  {
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      $submit = $this->input->post('submit');
      $category = $this->input->post('category');
      if(isset($submit))
      {
        $category_id = $this->input->post('category_id');
        if(!$this->Database_conn->getData('wbs_category',array('category_name'=>$category,'id!='=>$category_id))){
          $data = array('category_name' => $category , 'created_on'=>date('y-m-d H:i:s'));
          $insert = $this->Database_conn->update('wbs_category',$data, 'id',$category_id);
          $data['msg'] = 'Disease Category Updated Successfully';
        }
        else
          $data['msg'] = 'Disease Category Already exist';
          $category_id = (int)$category_id;
          $data['edit_category'] = $this->Database_conn->getData('wbs_category',array('id'=>$category_id));
      }
      else if($category_id!=0)
      {
        $category_id = (int)$category_id;
        $data['edit_category'] = $this->Database_conn->getData('wbs_category',array('id'=>$category_id));
      }
      $data['dataArr'] = $this->Database_conn->category();
      return $this->load->view('category',$data);
  }  
  public function deleteCategory($category_id = 0 , $msg='')
  {
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      if($category_id!=0)
      {
        $category_id = (int)$category_id;
        $this->Database_conn->deleteData('wbs_category',$category_id);
        $data['msg'] = 'Disease Category Deleted Successfully';
      }
      $data['dataArr'] = $this->Database_conn->category();
      return $this->load->view('category',$data);
  }

  public function get_diseases_data($disease_name) {

      $header[] = "Content-type: application/json";
      
      $this->curl = curl_init();
 
     // curl_setopt($this->curl, CURLOPT_URL,"https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&titles=".$disease_name);
     curl_setopt($this->curl, CURLOPT_URL,"https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&titles=".$disease_name);
     
      curl_setopt($this->curl, CURLOPT_POST, 0);
      curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($this->curl, CURLOPT_HTTPHEADER,  $header);
      $this->response = json_decode(curl_exec($this->curl), true);
      foreach ($this->response['query']['pages'] as $key => $value) {
        return $value['extract'];
      }
  }

  public function manageDisease($msg='')
  {

    if(!isset($this->session->user_id))
      return redirect('admin/login');
      $submit = $this->input->post('submit');
      $category = $this->input->post('category');
      $disease_name = $this->input->post('disease_name');
      $dies_status = $this->input->post('dies_status');
      if(isset($submit))
      {
        if(!$this->Database_conn->getData('disease',array('disease_name'=>$disease_name,'category'=>$category))) {
          $data = array('disease_name' => $disease_name , 'category'=>$category ,'status'=>$dies_status, 'created_by' => $this->session->user_id , 'created_on'=>date('y-m-d H:i:s'),'html_content'=>htmlentities($this->get_diseases_data($disease_name)));
          $insert = $this->Database_conn->insert('disease',$data);
          $data['msg'] = 'Disease Detail Inserted Successfully';
        }
        else
          $data['msg'] = 'Disease Detail Already exist';
      }
      $data['dataArr'] = $this->Database_conn->disease();
      $data['category_detail'] = $this->Database_conn->category();
      return $this->load->view('disease_detail',$data);
  }

  public function editDisease($disease_id = 0 , $msg='')
  {
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      $submit = $this->input->post('submit');
      $disease_name = $this->input->post('disease_name');
      $category = $this->input->post('category');
      if(isset($submit))
      {
        $disease_id = $this->input->post('disease_id');
        if(!$this->Database_conn->getData('disease',array('disease_name'=>$disease_name,'category'=>$category))){
          $data = array('disease_name' => $disease_name ,'category'=>$category, 'created_on'=>date('y-m-d H:i:s'),'html_content'=>htmlentities($this->get_diseases_data($disease_name)));
          $insert = $this->Database_conn->update('disease',$data, 'id',$disease_id);
          $data['msg'] = 'Disease Detail Updated Successfully';
        }
        else
          $data['msg'] = 'Disease Detail Already exist';
          $disease_id = (int)$disease_id;
          $data['edit_disease'] = $this->Database_conn->getData('disease',array('id'=>$disease_id));
      }
      else if($disease_id!=0)
      {
        $disease_id = (int)$disease_id;
        $data['edit_disease'] = $this->Database_conn->getData('disease',array('id'=>$disease_id));
      }
      
      $data['dataArr'] = $this->Database_conn->disease();
      $data['category_detail'] = $this->Database_conn->category();
      return $this->load->view('category',$data);
  }  
  public function deleteDisease($disease_id = 0 , $msg='')
  {
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      if($disease_id!=0)
      {
        $disease_id = (int)$disease_id;
        $this->Database_conn->deleteData('disease',$disease_id);
        $data['msg'] = 'Disease Detail Deleted Successfully';
      }
      $data['dataArr'] = $this->Database_conn->disease();
      $data['category_detail'] = $this->Database_conn->category();
      return $this->load->view('disease_detail',$data);
  }  
  
  public function googleAdsence()
  {
      if(!isset($this->session->user_id))
        return redirect('admin/login');

      $submit = $this->input->post('submit');
      $page = $this->input->post('page');
      $add_script = htmlentities('<script>'.$this->input->post('add_script').'</script>');
      $publish_status = $this->input->post('publish_status');
      $position = ($this->input->post('position')?$this->input->post('position'):'center');
      if(isset($submit))
      {
          $data = array('page' => $page , 'position'=>$position ,'publish_status'=>$publish_status, 'add_script' => $add_script , 'created_on'=>date('y-m-d H:i:s'));
          $insert = $this->Database_conn->insert('google_adsence',$data);
          $data['msg'] = 'Google Adsence Inserted Successfully';
      }
      $data['dataArr'] = $this->Database_conn->getGoogleAdd();
      return $this->load->view('google_adsence',$data);
  }
  public function editGoogleAdsence($id = 0 , $msg='')
  {
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      $submit = $this->input->post('submit');
      $page = $this->input->post('page');
      $add_script = htmlentities('<script>'.$this->input->post('add_script').'</script>');
      $publish_status = $this->input->post('publish_status');
      $position = ($this->input->post('position')?$this->input->post('position'):'center');
      if(isset($submit))
      {
          $add_id = $this->input->post('add_id');
          $data = array('page' => $page , 'position'=>$position ,'publish_status'=>$publish_status, 'add_script' => $add_script , 'created_on'=>date('y-m-d H:i:s'));
          $insert = $this->Database_conn->update('google_adsence',$data, 'id',$add_id);
          $data['msg'] = 'Google Adsence Updated Successfully';
          $add_id = (int)$add_id;
          $data['edit_add'] = $this->Database_conn->getDataNew('google_adsence',array('id'=>$add_id),'publish_status');
      }
      else if($id!=0)
      {
        $id = (int)$id;
        $data['edit_add'] = $this->Database_conn->getDataNew('google_adsence',array('id'=>$id),'publish_status');
      }
      // var_dump($data['edit_add']);die;
      $data['dataArr'] = $this->Database_conn->getGoogleAdd();
      return $this->load->view('google_adsence',$data);
  }

  public function deleteGoogleAdsence($id = 0 , $msg='')
  {
    if(!isset($this->session->user_id))
      return redirect('admin/login');
      if($id!=0)
      {
        $id = (int)$id;
        $this->Database_conn->deleteData('google_adsence',$id);
        $data['msg'] = 'Google Adsence Deleted Successfully';
      }
      $data['dataArr'] = $this->Database_conn->getGoogleAdd();
      return $this->load->view('google_adsence',$data);
  }

  public function logout()
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('user_id');
    return redirect('admin/login');
  }


  function encrypt($string) 
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'da_proj';
        $secret_iv = 'da_projects';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }



    function decrypt($string) 
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'da_proj';
        $secret_iv = 'da_projects';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    } 

    public function update_cate_status(){

      $statusId = $this->input->post('statusId');
      $cate_id = $this->input->post('cate_id');

      $result = $this->Database_conn->update('wbs_category',array('status'=>$statusId),'id',$cate_id);

      if($result){
        echo '1';
      }else{
        echo '0';
      }
    }

    public function update_dies_status(){
      $statusId = $this->input->post('statusId');
      $dies_id = $this->input->post('dies_id');
      $result = $this->Database_conn->update('disease',array('status'=>$statusId),'id',$dies_id);

      if($result){
        echo '1';
      }else{
        echo '0';
      }
    }

    public function update_publish_status(){
      $publish_status = $this->input->post('publish_status');
      $id = $this->input->post('id');
      $table = $this->input->post('table');
      $result = $this->Database_conn->update($table,array('publish_status'=>$publish_status),'id',$id);
      return $result;
    }
}