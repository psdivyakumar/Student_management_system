<?php
class Teacher_model extends CI_Model {

    public function get_teachers() {
        return $this->db->get('teachers')->result_array();
    }

    public function get_teacher_by_id($id) {
        return $this->db->get_where('teachers', array('id' => $id))->row_array();
    }

    public function insert_teacher($data) {
        return $this->db->insert('teachers', $data);
    }

    public function update_teacher($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('teachers', $data);
    }

    public function delete_teacher($id) {
        return $this->db->delete('teachers', array('id' => $id));
    }
}