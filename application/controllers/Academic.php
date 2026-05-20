<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Academic extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Academic_model', 'Teacher_model'));
        $this->load->helper('url');
    }

    // Manage Classes
    public function classes() {
        $data['classes'] = $this->Academic_model->get_classes();
        $data['teachers'] = $this->Teacher_model->get_teachers();
        
        if ($this->input->post()) {
            $insert_data = array(
                'class_name'   => $this->input->post('class_name'),
                'section_name' => $this->input->post('section_name'),
                'teacher_id'   => $this->input->post('teacher_id'),
                'capacity'     => $this->input->post('capacity')
            );
            $this->Academic_model->add_class($insert_data);
            redirect('academic/classes');
        }
        $this->load->view('academic_structure', $data);
    }

    // View/Add Timetable
    public function timetable($class_id) {
        $data['class_id'] = $class_id;
        $data['schedule'] = $this->Academic_model->get_timetable($class_id);
        $data['teachers'] = $this->Teacher_model->get_teachers();

        if ($this->input->post()) {
            $insert_data = array(
                'class_id'     => $class_id,
                'day'          => $this->input->post('day'),
                'start_time'   => $this->input->post('start_time'),
                'end_time'     => $this->input->post('end_time'),
                'subject_name' => $this->input->post('subject_name'),
                'teacher_id'   => $this->input->post('teacher_id')
            );
            $this->Academic_model->add_timetable_entry($insert_data);
            redirect('academic/timetable/'.$class_id);
        }
        $this->load->view('timetable_view', $data);
    }
}