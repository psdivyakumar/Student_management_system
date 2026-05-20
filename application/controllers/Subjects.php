<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Subject_model', 'Academic_model'));
        $this->load->helper('url');
    }

    public function index() {
        // We need the list of classes for the dropdown menu
        $data['classes'] = $this->Academic_model->get_classes();
        $data['subjects'] = $this->Subject_model->get_all_subjects();
        
        if ($this->input->post()) {
            $insert_data = array(
                'class_id'     => $this->input->post('class_id'),
                'subject_name' => $this->input->post('subject_name'),
                'subject_code' => $this->input->post('subject_code'),
                'syllabus'     => $this->input->post('syllabus')
            );
            $this->Subject_model->insert_subject($insert_data);
            redirect('subjects');
        }
        
        $this->load->view('subject_management', $data);
    }

    public function delete($id) {
        $this->Subject_model->delete_subject($id);
        redirect('subjects');
    }
}