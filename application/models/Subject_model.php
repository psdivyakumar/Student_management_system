<?php
class Subject_model extends CI_Model {

    public function get_all_subjects() {
        $this->db->select('subjects.*, classes.class_name, classes.section_name');
        $this->db->from('subjects');
        $this->db->join('classes', 'classes.id = subjects.class_id');
        return $this->db->get()->result_array();
    }

    public function insert_subject($data) {
        return $this->db->insert('subjects', $data);
    }

    public function delete_subject($id) {
        return $this->db->delete('subjects', array('id' => $id));
    }
}