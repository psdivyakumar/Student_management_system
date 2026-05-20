<?php
class Attendance_model extends CI_Model {

    // Get students for a specific class to mark attendance
    public function get_students_by_class($class_name, $section) {
        $this->db->where('class', $class_name);
        $this->db->where('section', $section);
        return $this->db->get('students')->result_array();
    }

    // Save attendance (Update if exists, Insert if new)
    public function save_attendance($data) {
        // Check if attendance already exists for this student on this date
        $this->db->where('student_id', $data['student_id']);
        $this->db->where('attendance_date', $data['attendance_date']);
        $query = $this->db->get('attendance');

        if ($query->num_rows() > 0) {
            $this->db->where('student_id', $data['student_id']);
            $this->db->where('attendance_date', $data['attendance_date']);
            return $this->db->update('attendance', array('status' => $data['status']));
        } else {
            return $this->db->insert('attendance', $data);
        }
    }

    // Fetch marked attendance for viewing
    public function get_attendance_report($class_id, $date) {
        $this->db->select('attendance.*, students.first_name, students.last_name, students.adm_no');
        $this->db->from('attendance');
        $this->db->join('students', 'students.id = attendance.student_id');
        $this->db->where('attendance.class_id', $class_id);
        $this->db->where('attendance.attendance_date', $date);
        return $this->db->get()->result_array();
    }
}