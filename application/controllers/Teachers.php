<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Teacher_model');
        $this->load->helper(array('url', 'form'));
    }

    public function index() {
        $data['teachers'] = $this->Teacher_model->get_teachers();
        $this->load->view('teacher_list', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $config['upload_path']   = './uploads/teachers/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            $photo_name = 'default.png';
            if ($this->upload->do_upload('teacher_photo')) {
                $photo_name = $this->upload->data('file_name');
            }

            $data = array(
                'emp_id'        => $this->input->post('emp_id'),
                'subject'       => $this->input->post('subject'),
                'qualification' => $this->input->post('qualification'),
                'joining_date'  => $this->input->post('joining_date'),
                'salary'        => $this->input->post('salary'),
                'first_name'    => $this->input->post('first_name'),
                'last_name'     => $this->input->post('last_name'),
                'email'         => $this->input->post('email'),
                'phone'         => $this->input->post('phone'),
                'address'       => $this->input->post('address'),
                'photo'         => $photo_name
            );
            $this->Teacher_model->insert_teacher($data);
            redirect('teachers');
        }
        $this->load->view('add_teacher');
    }

    public function edit($id) {
        $data['teacher'] = $this->Teacher_model->get_teacher_by_id($id);
        
        if ($this->input->post()) {
            $update_data = array(
                'emp_id' => $this->input->post('emp_id'),
                'subject' => $this->input->post('subject'),
                'qualification' => $this->input->post('qualification'),
                'joining_date' => $this->input->post('joining_date'),
                'salary' => $this->input->post('salary'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );

            if (!empty($_FILES['teacher_photo']['name'])) {
                $config['upload_path']   = './uploads/teachers/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name']  = TRUE;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('teacher_photo')) {
                    $update_data['photo'] = $this->upload->data('file_name');
                }
            }

            $this->Teacher_model->update_teacher($id, $update_data);
            redirect('teachers');
        }
        $this->load->view('edit_teacher', $data);
    }

    public function delete($id) {
        $this->Teacher_model->delete_teacher($id);
        redirect('teachers');
    }
}