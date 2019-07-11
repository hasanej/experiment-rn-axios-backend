<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model
{
    var $book = 'book';

    public function get_book()
    {
        $query = "SELECT * FROM book";
        $bookList = $this->db->query($query);

        if ($bookList->num_rows() > 0 )
        {
            $result = $bookList->result();

            foreach($result as $row)
            {
				$row->cover_image = base64_encode($row->cover_image);
            }

			return $result;
        }
        else
        {
            return array();
        }
    }

    public function save_book($data)
    {
        $this->db->insert($this->book, $data);
        return $this->db->insert_id();
    }

    public function update_book($where, $data)
    {
        $this->db->update($this->book, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_book($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->book);
        return $this->db->affected_rows();
    }
}
