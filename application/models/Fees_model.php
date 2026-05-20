<?php
class Fees_model extends CI_Model {

    public function get_fee_structure($class_id) {
        return $this->db->get_where('fee_structure', array('class_id' => $class_id))->result_array();
    }

    public function add_fee_config($data) {
        return $this->db->insert('fee_structure', $data);
    }

    public function get_invoices() {
        $this->db->select('invoices.*, students.first_name, students.last_name');
        $this->db->from('invoices');
        $this->db->join('students', 'students.id = invoices.student_id');
        return $this->db->get()->result_array();
    }

    public function create_invoice($data) {
        return $this->db->insert('invoices', $data);
    }

    public function update_payment($id, $paid_amount, $status) {
        $this->db->where('id', $id);
        return $this->db->update('invoices', array(
            'paid_amount' => $paid_amount,
            'status' => $status
        ));
    }
}