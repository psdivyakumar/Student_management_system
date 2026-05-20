<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fees extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Fees_model', 'Academic_model', 'Student_model'));
        $this->load->helper('url');
    }

    // 1. MAIN LIST OF BILLS
    public function index() {
        $data['invoices'] = $this->Fees_model->get_invoices();
        $this->load->view('fee_invoices', $data);
    }

    // 2. CONFIGURE CLASS FEES (Tuition, Transport, etc.)
    public function configuration() {
        $data['classes'] = $this->Academic_model->get_classes();
        if ($this->input->post()) {
            $this->Fees_model->add_fee_config([
                'class_id' => $this->input->post('class_id'),
                'fee_type' => $this->input->post('fee_type'),
                'amount'   => $this->input->post('amount')
            ]);
            redirect('fees/configuration');
        }
        $this->load->view('fee_configuration', $data);
    }

    // 3. CREATE A NEW BILL FOR A STUDENT
    public function create_invoice() {
        $data['students'] = $this->Student_model->get_students();
        
        if ($this->input->post()) {
            $insert_data = array(
                'invoice_no'   => 'INV-' . strtoupper(uniqid()),
                'student_id'   => $this->input->post('student_id'),
                'title'        => $this->input->post('title'),
                'total_amount' => $this->input->post('total_amount'),
                'status'       => 'Unpaid',
                'created_at'   => date('Y-m-d')
            );
            $this->Fees_model->create_invoice($insert_data);
            redirect('fees');
        }
        $this->load->view('create_invoice', $data);
    }

    // 4. PRINT RECEIPT (Matches Page 42)
    public function receipt($id) {
        $this->db->select('invoices.*, students.first_name, students.last_name, students.class');
        $this->db->from('invoices');
        $this->db->join('students', 'students.id = invoices.student_id');
        $this->db->where('invoices.id', $id);
        $data['inv'] = $this->db->get()->row_array();
        
        $this->load->view('fee_receipt', $data);
    }

    public function collect($invoice_id) {
        $this->db->where('invoices.id', $invoice_id);
        $this->db->join('students', 'students.id = invoices.student_id');
        $data['inv'] = $this->db->get('invoices')->row_array();

        if ($this->input->post()) {
            $new_paid = $this->input->post('amount_to_pay');
            $status = ($new_paid >= $data['inv']['total_amount']) ? 'Paid' : 'Partial';
            $this->Fees_model->update_payment($invoice_id, $new_paid, $status);
            redirect('fees');
        }
        $this->load->view('collect_payment', $data);
    }
}