<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Carousels Module
 *
 *
 * @author 		Phil Martinez - Philsquare Dev Team
 * @website		http://philsquare.com
 * @package 	PyroCMS
 */

class Admin_slides extends Admin_Controller
{

	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'slides';

    public function __construct()
    {
        parent::__construct();

		// Load lang
        $this->lang->load('carousels');

		// Load assets
		Asset::css('module::admin.css');
		Asset::js('module::admin.js');
		
		// Templates use this lib
		$this->load->library('table');
		
		// Set CP GUI table attr
		$this->table->set_template(array('table_open'  => '<table class="table-list" border="0" cellspacing="0">'));
    }

	// List views
	public function index($offset = 0)
	{
		$extra = array(
			'title' => 'Slides',
			
			'buttons' => array(
				array(
					'label' => 'Edit',
					'url' => 'admin/carousels/slides/form/-entry_id-'
				),
				array(
					'label' => 'Delete',
					'url' => 'admin/carousels/slides/delete/-entry_id-',
					'confirm' => true
				)
			),
			
			'columns' => array('title')
		);
		
		$this->streams->cp->entries_table('slides', 'carousels', 20, 'admin/carousels/slides', true, $extra);
	}
	
	public function form($id = null)
	{
		$extra = array(
			'return' => 'admin/carousels/slides',
			'title' => $id ? 'Edit Product' : 'Add Product'
		);
		
		$this->streams->cp->entry_form('slides', 'carousels', $id ? 'edit' : 'new', $id, true, $extra);
	}
	
	public function delete($id = 0)
	{
		$this->streams->entries->delete_entry($id, 'slides', 'slides');
		$this->session->set_flashdata('error', 'Slide was deleted.');
		redirect('admin/carousels/slides');
	}
}