<?php
class Transport_model extends CI_Model {

    // Vehicle CRUD
    public function get_vehicles() { return $this->db->get('vehicles')->result_array(); }
    public function add_vehicle($data) { return $this->db->insert('vehicles', $data); }

    // Route CRUD
    public function get_routes() { return $this->db->get('transport_routes')->result_array(); }
    public function add_route($data) { return $this->db->insert('transport_routes', $data); }

    // Member Assignment
    public function get_members() {
        $this->db->select('transport_members.*, students.first_name, transport_routes.route_title, transport_routes.fare');
        $this->db->from('transport_members');
        $this->db->join('students', 'students.id = transport_members.student_id');
        $this->db->join('transport_routes', 'transport_routes.id = transport_members.route_id');
        return $this->db->get()->result_array();
    }
    public function add_member($data) { return $this->db->insert('transport_members', $data); }
}