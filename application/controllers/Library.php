<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Library extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Library_model', 'Student_model'));
    }

    public function index() {
        $data['books'] = $this->Library_model->get_books();
        $data['issued'] = $this->Library_model->get_issued_books();
        $data['students'] = $this->Student_model->get_students();
        $this->load->view('library_management', $data);
    }

    public function add_book() {
        $this->Library_model->add_book($this->input->post());
        redirect('library');
    }

    public function issue() {
        $data = array(
            'book_id' => $this->input->post('book_id'),
            'student_id' => $this->input->post('student_id'),
            'issue_date' => $this->input->post('issue_date'),
            'due_date' => $this->input->post('due_date'),
            'status' => 'Issued'
        );
        $this->Library_model->issue_book($data);
        redirect('library');
    }

    public function return_item($issue_id, $book_id) {
        $this->Library_model->return_book($issue_id, $book_id);
        redirect('library');
    }
}