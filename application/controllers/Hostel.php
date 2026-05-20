<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hostel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Hostel_model', 'Student_model'));
    }

    public function index() {
        $data['hostels'] = $this->Hostel_model->get_hostels();
        $data['rooms'] = $this->Hostel_model->get_rooms();
        $data['allocations'] = $this->Hostel_model->get_allocations();
        $data['students'] = $this->Student_model->get_students();
        $this->load->view('hostel_management', $data);
    }

    public function add_building() {
        $this->Hostel_model->add_hostel($this->input->post());
        redirect('hostel');
    }

    public function add_room() {
        $this->Hostel_model->add_room($this->input->post());
        redirect('hostel');
    }

    public function allocate() {
        $data = array(
            'student_id' => $this->input->post('student_id'),
            'room_id' => $this->input->post('room_id'),
            'allocation_date' => date('Y-m-d')
        );
        $this->Hostel_model->allocate($data);
        redirect('hostel');
    }
}