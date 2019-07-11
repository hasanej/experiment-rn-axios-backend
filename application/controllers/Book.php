<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Book extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('book_model');
		$this->load->helper('url');
	}

	public function index() {
		$this->get_book();
	}

	public function get_book()
	{
		$response = array(
			'result' => 'OK',
			'book' => $this->book_model->get_book()
		);

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT))
			->_display();

		exit;
	}

	public function add_book()
	{
		$data = array(
			'isbn' => $this->input->post('isbn'),
			'title' => $this->input->post('title'),
			'author' => $this->input->post('author'),
			'published_year' => $this->input->post('published_year'),
			'synopsis' => $this->input->post('synopsis'),
			'cat_id' => $this->input->post('cat_id'),
			'cover_image' => base64_decode($this->input->post('cover_image'))
		);

		$insert = $this->book_model->save_book($data);

		if ($insert)
		{
			$response = array(
				'result' => 'OK',
				'id' => $insert,
				'message' => 'Book added'
			);
		}
		else
		{
			$response = array(
				'result' => 'NG',
				'id_buku' => 0,
				'message' => 'Failure - Book not added');
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT))
			->_display();

		exit;
	}

	public function update_book()
	{
		$this->load->helper('url');

		if ($this->input->post('id') != "")
		{
			$data = array(
				'isbn' => $this->input->post('isbn'),
				'title' => $this->input->post('title'),
				'author' => $this->input->post('author'),
				'published_year' => $this->input->post('published_year'),
				'synopsis' => $this->input->post('synopsis'),
				'cat_id' => $this->input->post('cat_id'),
				'cover_image' => base64_decode($this->input->post('cover_image'))
			);

			$update = $this->book_model->update_book(array('id' => $this->input->post('id')), $data);

			if ($update)
			{
				$response = array(
					'result' => 'OK',
					'message' =>'Book updated'
				);
			}
			else
			{
				$response = array(
					'result' => 'NG',
					'message' =>'Failure - Book not updated'
				);
			}
		}
		else
		{
			$response = array(
				'result' => 'NG',
				'message' =>'ID not found'
			);
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT))
			->_display();

		exit;
	}

	 public function delete_book()
	 {
		$this->load->helper('url');

		if ($this->input->post('id') != "")
		{
			$id = $this->input->post('id');
			$delete = $this->book_model->delete_book($id);

			if ($delete) {
				$response = array(
					'result' => 'OK',
					'message' =>'Book deleted'
				);
			}
			else
			{
				$response = array(
					'result' => 'NG',
					'message' =>'Failure - Book not deleted'
				);
			}
		}
		else
		{
			$response = array(
			'result' => 'NG',
			'message' =>'ID not found');
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT))
			->_display();

		exit;
	}
}
