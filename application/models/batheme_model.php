<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class batheme_model extends CI_Model
{
    protected $table = 'batheme';

    public function get_all_batheme()
    {
        $this->db->from($this->table);
        $query=$this->db->get();
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('bat_id',$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function batheme_add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function batheme_update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('bat_id', $id);
        $this->db->delete($this->table);
    }
}