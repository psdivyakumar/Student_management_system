<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Dashboard_model']);
        $this->load->helper('url');
    }

    public function index() {
        // Fetch all dynamic data
        $data['total_students'] = $this->db->count_all('students');
        $data['total_staff']    = $this->db->count_all('teachers');
        $data['active_classes'] = $this->db->count_all('classes');
        
        $data['recent_students'] = $this->Dashboard_model->get_recent_students();
        $data['tasks']           = $this->Dashboard_model->get_pending_tasks();
        $data['note']            = $this->Dashboard_model->get_latest_announcement();
        $data['revenue']         = $this->Dashboard_model->get_revenue_stats();

        $this->load->view('dashboard', $data);
    }
}