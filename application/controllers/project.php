<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class project extends CI_Controller{

   function __construct(){
		parent::__construct();
    $this->load->library('upload');
    $this->load->model('M_project');
	}

  public function index(){
    $this->load->view('V_Dashboard');
  }



  ####################################
              // Project
  ####################################

  public function projectView()
  {
    $data["list_project"] = $this->M_project->select('project');
    $data["username"] = "Fadli Test";
    $this->session->set_userdata($data);
    $this->load->view('V_Project',$data);
  }
  
  public function SaveData(){
    $this->form_validation->set_rules('project_id','Project ID','required');
    $this->form_validation->set_rules('nama_project','Nama Project','required');
    $this->form_validation->set_rules('asset','Asset','required');
    $this->form_validation->set_rules('departement','Departement','required');
    $this->form_validation->set_rules('industri','Industri','required');
    $this->form_validation->set_rules('type','Type','required');
    $this->form_validation->set_rules('status','status','required');
    $this->form_validation->set_rules('lokasi','Lokasi','required');


    if($this->form_validation->run() == TRUE)
    {
        $project_id  = $this->input->post('project_id',TRUE);
        $nama_project  = $this->input->post('nama_project',TRUE);
        $departement  = $this->input->post('departement',TRUE);
        $industri  = $this->input->post('industri',TRUE);
        $type  = $this->input->post('type',TRUE);
        $asset       = $this->input->post('asset',TRUE);
        $status         = $this->input->post('status',TRUE);
        $lokasi  = $this->input->post('lokasi',TRUE);

        $data = array(
            'id_project' => $project_id,
            'nama_project' => $nama_project,
            'departement' => $departement,
            'industri' => $industri,
            'type' => $type,
            'asset' => $asset,
            'status' => $status,
            'lokasi' => $lokasi
        );
        
        $isIdProjectExist = $this->M_project->isIdProjectExist($project_id);
        if($isIdProjectExist->num_rows() > 0){
            $data["list_project"] = $this->M_project->select('project');
            $this->session->set_flashdata('msg_warn','ID Barang Sudah Terdaftar');
            $this->load->view('project/form_insert',$data);  
        }else{
            $this->M_project->insert('project',$data);

            //Prepare upload
            $config =  array(
              'upload_path'     => "./assets/upload/img/",
              'allowed_types'   => "gif|jpg|png|jpeg",
              'encrypt_name'    => False, //
              'max_size'        => "50000",  // ukuran file gambar
              'max_height'      => "9680",
              'max_width'       => "9024"
            );

            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            $dataFiles = [];
            $Number = 1;
            $count = count($_FILES["fotoproject"]["name"]);

            for ($i=0; $i < $count ; $i++) {
              $_FILES['file']['name'] = $_FILES['fotoproject']['name'][$i];
              $_FILES['file']['type'] = $_FILES['fotoproject']['type'][$i];
              $_FILES['file']['tmp_name'] = $_FILES['fotoproject']['tmp_name'][$i];
              $_FILES['file']['error'] = $_FILES['fotoproject']['error'][$i];
              $_FILES['file']['size'] = $_FILES['fotoproject']['size'][$i];
              
              if($this->upload->do_upload('file')){
                $uploadData = $this->upload->data();
                $filename = $uploadData['file_name'];
                $dataFiles['totalFiles'][] = $filename;
                $where = array('id_project' => $project_id);
                $data = array('foto_project'.$Number => $filename);
            
                $Number++;
              }else{
                $this->session->set_flashdata('msg_error_gambar', $this->upload->display_errors());
                $this->load->view('project/form_insert_project',$data);
              }
              $this->M_project->update('project',$data,$where);
            }
          }
          $this->session->set_flashdata('msg_berhasil_gambar','Data Berhasil Di Input');
          redirect(site_url('project/projectView'));
        }else{
          $data["list_project"] = $this->M_project->select('project');
          $this->load->view('project/form_insert',$data);
        }
      }
  
  public function projectViewUpdate(){
    $id_project = $this->uri->segment(3);
    $where = array('id_project' => $id_project);
    $data['data_list_project'] = $this->M_project->get_data('project',$where);
    $this->load->view('project/form_update',$data);
  }
  
  public function UpdateData(){
    $this->form_validation->set_rules('project_id','Project ID','required');
    $this->form_validation->set_rules('nama_project','Nama Project','required');
    $this->form_validation->set_rules('asset','Asset','required');
    $this->form_validation->set_rules('status','status','required');

    $project_id  = $this->input->post('project_id',TRUE);
    $nama_project  = $this->input->post('nama_project',TRUE);
    $departement  = $this->input->post('departement',TRUE);
    $industri  = $this->input->post('industri',TRUE);
    $type  = $this->input->post('type',TRUE);
    $asset       = $this->input->post('asset',TRUE);
    $status         = $this->input->post('status',TRUE);
    $lokasi  = $this->input->post('lokasi',TRUE);
    $DoUpdate = false;

    $data = array(
        'id_project' => $project_id,
        'nama_project' => $nama_project,
        'departement' => $departement,
        'industri' => $industri,
        'type' => $type,
        'asset' => $asset,
        'status' => $status,
        'lokasi' => $lokasi
    );
    
    $where = array('id_project' => $project_id);

    $this->M_project->update('project',$data,$where);

    //Prepare upload
    $config =  array(
        'upload_path'     => "./assets/upload/img/",
        'allowed_types'   => "gif|jpg|png|jpeg",
        'encrypt_name'    => False, //
        'max_size'        => "50000",  // ukuran file gambar
        'max_height'      => "9680",
        'max_width'       => "9024"
      );
    $this->load->library('upload',$config);
    $this->upload->initialize($config);

    if($this->upload->do_upload('fotoproject'))
    {
        $upload_data = $this->upload->data();
        $nama_file = $upload_data['file_name'];
        $where = array('id_project' => $project_id);
        $data = array('foto_project1' => $nama_file);
        
        $this->M_project->update('project',$data,$where);
        $this->session->set_flashdata('msg_berhasil_gambar','Data Berhasil Di Input');
        redirect(site_url('project/projectView'));
    }else{
        $this->session->set_flashdata('msg_berhasil','Data Berhasil Di Update');
        redirect(site_url('project/projectView'));
    }
  }

  public function DeleteData($id_project){
    $where = array('id_project' => $id_project);
    $this->M_project->delete('project',$where);
    $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
    redirect(site_url('project/projectView'));
  }

  public function form_insert_project(){
      $this->load->view('project/form_insert');
  }
  public function form_update_project(){
    $this->load->view('project/form_update');
  }

  ####################################
           // End Project
  ####################################
}