<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

class TaskCategories extends RestController{
    public function __construct($config = 'rest')
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
        header('Access-Control-Allow-Credentials: *');
        $this->load->model('M_TaskCategories','mdl',true);
    }

    public function index_get(){
        $id = $this->get('id');
        if ($id == null) {
           $mahasiswa = $this->mdl->getTaskCategories();
        }else{
           $mahasiswa = $this->mdl->getTaskCategories($id);
        }
        if ($mahasiswa) {
            $this->response([
                'status' => true,
                'data'=> $mahasiswa,
            ], RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Data Not Found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete(){
        $id = $this->delete('id');

        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'Masukkan ID terlebih dahulu'
            ], RestController::HTTP_BAD_REQUEST);
        }else{
            if($this->mdl->deleteTaskCategories($id)>0){
                // ok
                $this->response([
                    'status' => true,
                    'data' => $id,
                    'message' => 'deleted.'
                ], RestController::HTTP_OK);
            }else{
                // not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found',
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post(){
        $data = [
            'name' => $this->post('name')
        ];
        if($this->mdl->addTaskCategories($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Data Has Been Added'
            ],RestController::HTTP_CREATED);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Add Data Failed'
            ],RestController::HTTP_BAD_REQUEST);
        }

    }

    public function index_put(){
        $id = $this->put('id');
        $data['name'] = $this->put('name');
        if($this->mdl->updateTaskCategories($data, $id) > 0){
            $this->response([
                'status' => 'true',
                'message' => 'Data has been updated',
            ],RestController::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'id' => $id,
                'message' => 'Update Data Failed',
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}