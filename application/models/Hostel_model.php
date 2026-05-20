<?php
class Hostel_model extends CI_Model {

    public function get_hostels() { return $this->db->get('hostels')->result_array(); }
    public function add_hostel($data) { return $this->db->insert('hostels', $data); }

    public function get_rooms() {
        $this->db->select('hostel_rooms.*, hostels.hostel_name');
        $this->db->from('hostel_rooms');
        $this->db->join('hostels', 'hostels.id = hostel_rooms.hostel_id');
        return $this->db->get()->result_array();
    }
    public function add_room($data) { 
        $data['available_beds'] = $data['total_beds'];
        return $this->db->insert('hostel_rooms', $data); 
    }

    public function get_allocations() {
        $this->db->select('hostel_allocations.*, students.first_name, hostel_rooms.room_no, hostel_rooms.rent, hostel_rooms.food_cost');
        $this->db->from('hostel_allocations');
        $this->db->join('students', 'students.id = hostel_allocations.student_id');
        $this->db->join('hostel_rooms', 'hostel_rooms.id = hostel_allocations.room_id');
        return $this->db->get()->result_array();
    }
    public function allocate($data) {
        // Decrease available beds
        $this->db->set('available_beds', 'available_beds-1', FALSE);
        $this->db->where('id', $data['room_id']);
        $this->db->update('hostel_rooms');
        return $this->db->insert('hostel_allocations', $data);
    }
}