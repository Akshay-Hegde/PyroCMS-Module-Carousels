<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Carousels Module
 *
 *
 * @author 		Phil Martinez - Philsquare Dev Team
 * @website		http://philsquare.com
 * @package 	PyroCMS
 */

class Admin_carousels extends Admin_Controller
{

	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'carousels';

    public function __construct()
    {
        parent::__construct();

		// Load lang
        $this->lang->load('carousels');
		
		// Templates use this lib
		$this->load->library('table');
		
		// Set CP GUI table attr
		$this->table->set_template(array('table_open'  => '<table class="table-list" border="0" cellspacing="0">'));
    }

	// List views
	public function index($offset = 0)
	{
		$extra = array(
			'title' => 'Carousels',
			
			'buttons' => array(
				array(
					'label' => 'Edit',
					'url' => 'admin/carousels/form/-entry_id-'
				),
				array(
					'label' => 'Delete',
					'url' => 'admin/carousels/delete/-entry_id-',
					'confirm' => true
				)
			),
			
			'columns' => array('id', 'title')
		);
		
		$this->streams->cp->entries_table('carousels', 'carousels', 20, 'admin/carousels', true, $extra);
	}
	
	public function form($id = null)
	{
		$extra = array(
			'return' => 'admin/carousels',
			'title' => $id ? 'Edit Product' : 'Add Product'
		);
		
		$this->streams->cp->entry_form('carousels', 'carousels', $id ? 'edit' : 'new', $id, true, $extra);
	}
	
	public function delete($id = 0)
	{
		$this->streams->entries->delete_entry($id, 'carousels', 'carousels');
		$this->session->set_flashdata('error', 'Product was deleted.');
		redirect('admin/carousels');
	}
}