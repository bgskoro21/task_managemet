<?php
use chriskacerguis\RestServer\RestController;

class Tasks extends RestController{
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
        header('Access-Control-Allow-Credentials: *');
        $this->load->model('M_Tasks','mdl',true);
        $this->load->helper('form'); 
        $this->load->library('form_validation');
    }

    public function index_get(){
        $id = $this->get('id');
        if($id == null){
            $mahasiswa = $this->mdl->getTasks();
        }else{
            $mahasiswa = $this->mdl->getTasks($id);
        }

        if($mahasiswa){
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ],RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => true,
                'message' => 'Data Not Found'
            ],RestController::HTTP_OK);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');

        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'Masukkin ID dulu'
            ],RestController::HTTP_BAD_REQUEST);
        }else{
            if($this->mdl->deleteTasks($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], RestController::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'id' => $id,
                    'message' => 'failed delete'
                ],RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post(){
                $config['upload_path'] = './assets/images';
                $config['allowed_types'] = 'gif|jpg|png|docx|doc|txt|rtf';
    
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('doc_url')) {
                    $this->response([
                        'message' => 'Upload Gagal'
                    ], RestController::HTTP_BAD_REQUEST);
                }else{
                    $namaGambar = $this->upload->data('file_name');
                    $doc_url = base_url("/assets/images/". $namaGambar);
                }


            

        $data = [
            'category_id' => $this->input->post('category_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'finish_date' => $this->input->post('finish_date'),
            'status' => $this->post('status'),
            'doc_url' => $doc_url
        ];
        

        if($this->mdl->addTasks($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Data has been added'
            ],RestController::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Add Data Failed!'
            ],RestController::HTTP_BAD_REQUEST);
        }
    }

    public function update_post(){
        $id = $this->input->post('id');

        $gambarLama = $this->mdl->getGambarLama($id);
        $pecah = explode('/',$gambarLama[0]['doc_url']);

        $config['upload_path'] = './assets/images';
        $config['allowed_types'] = 'gif|jpg|png|docx|doc|txt|rtf';
    
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('doc_url')) {
                $this->response([
                    'message' => 'Upload Gagal'
                ], RestController::HTTP_BAD_REQUEST);
        }else{
            $namaGambar = $this->upload->data('file_name');
            unlink("./assets/images/$pecah[6]");
            $doc_url = base_url("/assets/images/". $namaGambar);
        }


            

        $data = [
            'category_id' => $this->input->post('category_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'finish_date' => $this->input->post('finish_date'),
            'status' => $this->input->post('status'),
            'doc_url' => $doc_url
        ];

        if($this->mdl->updateTasks($data,$id) > 0){
            $this->response([
                'status' => true,
                'message' => 'Data has been updated'
            ],RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Failed update Data'
            ],RestController::HTTP_BAD_REQUEST);
        }
    }
}




?>