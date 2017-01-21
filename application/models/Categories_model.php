<?php 
/**
* 
*/
class Categories_model extends CI_Model
{
	
	public function __construct()
	{
		$this->load->database();
	}

	public function get_categories($id = FALSE)
	{
		if ($id === FALSE) 
		{
			$query = $this->db->get('categories');

			return $query->result_array();
		}

		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('cat_id', $id);

		$query = $this->db->get();

		return $query->result()[0];
		
	}
}