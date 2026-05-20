<?php
class Academic_model extends CI_Model {

    // Class Management
    public function get_classes() {
        $this->db->select('classes.*, teachers.first_name, teachers.last_name');
        $this->db->from('classes');
        $this->db->join('teachers', 'teachers.id = classes.teacher_id', 'left');
        return $this->db->get()->result_array();
    }

    public function add_class($data) {
        return $this->db->insert('classes', $data);
    }

    // Timetable Management
    public function get_timetable($class_id) {
        $this->db->select('timetable.*, teachers.first_name, teachers.last_name');
        $this->db->from('timetable');
        $this->db->join('teachers', 'teachers.id = timetable.teacher_id', 'left');
        $this->db->where('class_id', $class_id);
        return $this->db->get()->result_array();
    }

    public function add_timetable_entry($data) {
        return $this->db->insert('timetable', $data);
    }
}