<?php
class Dashboard_model extends CI_Model {

    public function get_recent_students() {
        return $this->db->order_by('id', 'DESC')->limit(3)->get('students')->result_array();
    }

    public function get_pending_tasks() {
        return $this->db->where('status', 0)->limit(4)->get('tasks')->result_array();
    }

    public function get_latest_announcement() {
        return $this->db->order_by('id', 'DESC')->limit(1)->get('announcements')->row_array();
    }

    public function get_revenue_stats() {
        $this->db->select_sum('total_amount');
        $this->db->select_sum('paid_amount');
        $query = $this->db->get('invoices')->row();
        
        $total = $query->total_amount ?? 0;
        $collected = $query->paid_amount ?? 0;
        $percent = ($total > 0) ? ($collected / $total) * 100 : 0;

        return ['total' => $total, 'collected' => $collected, 'percent' => round($percent)];
    }
}