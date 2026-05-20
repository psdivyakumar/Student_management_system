<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Attendance_model', 'Academic_model'));
        $this->load->helper('url');
    }

    public function index() {
        $data['classes'] = $this->Academic_model->get_classes();
        $data['students'] = null;
        $data['selected_date'] = date('Y-m-d');

        if ($this->input->get('class_id')) {
            $class_id = $this->input->get('class_id');
            $date = $this->input->get('date');
            
            // Get class details to filter students
            $this->db->where('id', $class_id);
            $class_info = $this->db->get('classes')->row_array();
            
            $data['students'] = $this->Attendance_model->get_students_by_class($class_info['class_name'], $class_info['section_name']);
            $data['selected_class'] = $class_id;
            $data['selected_date'] = $date;
        }

        $this->load->view('attendance_management', $data);
    }

    public function save() {
        $student_ids = $this->input->post('student_id');
        $statuses = $this->input->post('status');
        $date = $this->input->post('attendance_date');
        $class_id = $this->input->post('class_id');

        foreach ($student_ids as $id) {
            $data = array(
                'student_id' => $id,
                'class_id' => $class_id,
                'attendance_date' => $date,
                'status' => $statuses[$id]
            );
            $this->Attendance_model->save_attendance($data);
        }
        
        $this->session->set_flashdata('success', 'Attendance marked successfully!');
        redirect('attendance?class_id='.$class_id.'&date='.$date);
    }
}