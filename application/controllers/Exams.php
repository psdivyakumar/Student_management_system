<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exams extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Exam_model', 'Academic_model', 'Subject_model', 'Student_model'));
    }

    public function index() {
    $data['exams'] = $this->Exam_model->get_exams();
    
    // Check if the form was submitted
    if ($this->input->post('exam_name')) {
        $insert_data = [
            'exam_name' => $this->input->post('exam_name'),
            'start_date' => $this->input->post('start_date')
        ];
        $this->Exam_model->add_exam($insert_data);
        redirect('exams');
    }
    
    $this->load->view('exam_list', $data);
}

    public function marks_entry() {
        $data['exams'] = $this->Exam_model->get_exams();
        $data['classes'] = $this->Academic_model->get_classes();
        $data['subjects'] = $this->Subject_model->get_all_subjects();
        
        if ($this->input->get('class_id')) {
    $class_id = $this->input->get('class_id');
    
    // Get class details (Name and Section) from the classes table
    $this->db->where('id', $class_id);
    $class_info = $this->db->get('classes')->row_array();
    
    // Now call the model function we just added
    $data['students'] = $this->Student_model->get_students_by_class($class_info['class_name'], $class_info['section_name']);
}

        $this->load->view('marks_entry', $data);
    }

    public function save_marks() {
        $student_ids = $this->input->post('student_id');
        $marks = $this->input->post('marks');
        $exam_id = $this->input->post('exam_id');
        $subject_id = $this->input->post('subject_id');

        foreach ($student_ids as $id) {
            $m = $marks[$id];
            $grade = ($m >= 90) ? 'A+' : (($m >= 80) ? 'A' : (($m >= 70) ? 'B' : 'C'));
            
            $data = [
                'exam_id' => $exam_id,
                'student_id' => $id,
                'subject_id' => $subject_id,
                'marks_obtained' => $m,
                'grade' => $grade
            ];
            $this->Exam_model->save_marks($data);
        }
        redirect('exams/marks_entry');
    }

    public function report_card($student_id, $exam_id) {
        $data['student'] = $this->Student_model->get_student_by_id($student_id);
        $data['results'] = $this->Exam_model->get_student_report($student_id, $exam_id);
        $this->load->view('report_card', $data);
    }
}