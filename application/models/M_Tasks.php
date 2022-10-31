<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Tasks extends CI_Model{
    public function getTasks($id=null){
        if ($id == null) {
            return $this->db->get('tasks')->result_array();
        }else{
            return $this->db->get_where('tasks',['id' => $id])->result_array();
        }
    }

    public function deleteTasks($id){
        $this->db->delete('tasks',['id' => $id]);
        return $this->db->affected_rows();
    }

    public function addTasks($data){
        $this->db->insert('tasks',$data);
        return $this->db->affected_rows();
    }

    public function updateTasks($data, $id){
        $this->db->update('tasks',$data,['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getGambarLama($id){
        $this->db->select('doc_url');
        return $this->db->get_where('tasks',['id' => $id])->result_array();
    }
}




?>