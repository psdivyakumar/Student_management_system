<?php
class Exam_model extends CI_Model {

    public function get_exams() {
        return $this->db->get('exams')->result_array();
    }

    public function add_exam($data) {
        return $this->db->insert('exams', $data);
    }

    public function save_marks($data) {
        // Check if marks already exist to avoid duplication
        $this->db->where('exam_id', $data['exam_id']);
        $this->db->where('student_id', $data['student_id']);
        $this->db->where('subject_id', $data['subject_id']);
        $query = $this->db->get('exam_results');

        if ($query->num_rows() > 0) {
            $this->db->where('id', $query->row()->id);
            return $this->db->update('exam_results', $data);
        } else {
            return $this->db->insert('exam_results', $data);
        }
    }

    public function get_student_report($student_id, $exam_id) {
        $this->db->select('exam_results.*, subjects.subject_name, exams.exam_name');
        $this->db->from('exam_results');
        $this->db->join('subjects', 'subjects.id = exam_results.subject_id');
        $this->db->join('exams', 'exams.id = exam_results.exam_id');
        $this->db->where('student_id', $student_id);
        $this->db->where('exam_id', $exam_id);
        return $this->db->get()->result_array();
    }
}