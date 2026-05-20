<?php
class Library_model extends CI_Model {

    public function get_books() {
        return $this->db->get('books')->result_array();
    }

    public function add_book($data) {
        $data['available_qty'] = $data['quantity'];
        return $this->db->insert('books', $data);
    }

    public function get_issued_books() {
        $this->db->select('library_issue.*, students.first_name, books.title as book_title');
        $this->db->from('library_issue');
        $this->db->join('students', 'students.id = library_issue.student_id');
        $this->db->join('books', 'books.id = library_issue.book_id');
        return $this->db->get()->result_array();
    }

    public function issue_book($data) {
        // Decrease available quantity
        $this->db->set('available_qty', 'available_qty-1', FALSE);
        $this->db->where('id', $data['book_id']);
        $this->db->update('books');

        return $this->db->insert('library_issue', $data);
    }

    public function return_book($issue_id, $book_id) {
        // Increase available quantity
        $this->db->set('available_qty', 'available_qty+1', FALSE);
        $this->db->where('id', $book_id);
        $this->db->update('books');

        // Update status
        $this->db->where('id', $issue_id);
        return $this->db->update('library_issue', array('status' => 'Returned', 'return_date' => date('Y-m-d')));
    }
}