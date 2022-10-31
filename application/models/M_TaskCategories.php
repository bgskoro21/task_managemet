<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_TaskCategories extends CI_Model{
    public function getTaskCategories($id=null){
        if($id==null){
            return $this->db->get('task_categories')->result_array();
        }else{
            return $this->db->get_where('task_categories',['id' => $id])->result_array();
        }
    }

    public function deleteTaskCategories($id){
        $this->db->delete('task_categories',['id' => $id]);
        return $this->db->affected_rows();
    }

    public function addTaskCategories($data){
        $this->db->insert('task_categories',$data);
        return $this->db->affected_rows();
    }

    public function updateTaskCategories($data,$id){
        $this->db->update('task_categories',$data,['id' => $id]);
        return $this->db->affected_rows();
    }
}