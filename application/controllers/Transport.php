<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Transport_model', 'Student_model'));
    }

    public function index() {
        $data['vehicles'] = $this->Transport_model->get_vehicles();
        $data['routes'] = $this->Transport_model->get_routes();
        $data['members'] = $this->Transport_model->get_members();
        $data['students'] = $this->Student_model->get_students();
        
        $this->load->view('transport_management', $data);
    }

    public function add_vehicle() {
        $this->Transport_model->add_vehicle($this->input->post());
        redirect('transport');
    }

    public function add_route() {
        $this->Transport_model->add_route($this->input->post());
        redirect('transport');
    }

    public function assign_student() {
        $this->Transport_model->add_member($this->input->post());
        redirect('transport');
    }
}