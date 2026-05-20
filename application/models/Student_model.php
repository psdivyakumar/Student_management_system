<?php
class Student_model extends CI_Model {

    public function get_students() {
        return $this->db->get('students')->result_array();
    }

    // Get data for ONE specific student to edit
    public function get_student_by_id($id) {
        return $this->db->get_where('students', array('id' => $id))->row_array();
    }

    public function insert_student($data) {
        return $this->db->insert('students', $data);
    }

    // Update existing student
    public function update_student($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('students', $data);
    }

    public function delete_student($id) {
        $this->db->where('id', $id);
        return $this->db->delete('students');
    }
    // Add this to your Student_model.php
public function get_students_by_class($class_name, $section) {
    $this->db->where('class', $class_name);
    $this->db->where('section', $section);
    return $this->db->get('students')->result_array();
}
}