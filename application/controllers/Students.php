<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->helper(array('url', 'form'));
    }

    public function index() {
        $data['students'] = $this->Student_model->get_students();
        $this->load->view('student_list', $data);
    }

    // ADD STUDENT with Image Upload
    public function add() {
        if ($this->input->post()) {
            $config['upload_path']   = './uploads/students/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name']  = TRUE; // Random name for security
            $this->load->library('upload', $config);

            $photo_name = 'default.png'; // Default if no image uploaded
            if ($this->upload->do_upload('student_photo')) {
                $upload_data = $this->upload->data();
                $photo_name = $upload_data['file_name'];
            }

            $data = array(
                'adm_no'     => $this->input->post('adm_no'),
                'class'      => $this->input->post('class'),
                'section'    => $this->input->post('section'),
                'roll_no'    => $this->input->post('roll_no'),
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'dob'        => $this->input->post('dob'),
                'gender'     => $this->input->post('gender'),
                'father_name'=> $this->input->post('father_name'),
                'mother_name'=> $this->input->post('mother_name'),
                'photo'      => $photo_name
            );
            $this->Student_model->insert_student($data);
            redirect('students');
        }
        $this->load->view('add_student');
    }

    // EDIT STUDENT
   public function edit($id) {
    $data['student'] = $this->Student_model->get_student_by_id($id);

    if ($this->input->post()) {
        // Capture ALL fields from the form
        $update_data = array(
            'adm_no'     => $this->input->post('adm_no'),
            'class'      => $this->input->post('class'),
            'section'    => $this->input->post('section'),
            'roll_no'    => $this->input->post('roll_no'),
            'first_name' => $this->input->post('first_name'),
            'last_name'  => $this->input->post('last_name'),
            'dob'        => $this->input->post('dob'),
            'gender'     => $this->input->post('gender'),
            'father_name'=> $this->input->post('father_name'),
            'mother_name'=> $this->input->post('mother_name')
        );

        // Image Update Logic
        if (!empty($_FILES['student_photo']['name'])) {
            $config['upload_path']   = './uploads/students/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('student_photo')) {
                $upload_data = $this->upload->data();
                $update_data['photo'] = $upload_data['file_name'];
            }
        }

        $this->Student_model->update_student($id, $update_data);
        redirect('students');
    }
    $this->load->view('edit_student', $data);
}

    public function delete($id) {
        $this->Student_model->delete_student($id);
        redirect('students');
    }
    
}