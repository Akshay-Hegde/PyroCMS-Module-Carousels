<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Carousels extends Module {

	public $version = '1.0.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Carousels'
			),
			'description' => array(
				'en' => 'A module to manage carousels'
			),
			'frontend' => false,
			'backend' => true,
			'skip_xss' => false,
			'menu' => 'content',
			'sections' => array(
				'carousels' => array(
					'name' => 'carousels:carousels:title',
					'uri' => 'admin/carousels',
					'class' => '',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'carousels:carousels:add',
							'uri' 	=> 'admin/carousels/form',
							'class' => 'add'
						)
					)
				),
				'slides' => array(
					'name' => 'carousels:slides:title',
					'uri' => 'admin/carousels/slides',
					'class' => '',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'carousels:slides:add',
							'uri' 	=> 'admin/carousels/slides/form',
							'class' => 'add'
						)
					)
				)
			),
			'roles' => array(
				''
			)
		);
		
		return $info;
	}

	public function install()
	{
		$this->load->driver('Streams');
		$this->load->library('files/files');
		$this->streams->utilities->remove_namespace('carousels');
		Files::delete_folder(Settings::get('carousels_folder_id'));
		$this->db->delete('settings', array('module' => 'carousels'));
		
		// Create Folders
		$folder = Files::create_folder(0, 'Carousels');
		if($folder['status'] != 1) return false;
		$carousels_folder_id = $folder['data']['id'];
		
		// Create Streams
		if(!$this->streams->streams->add_stream('Carousels', 'carousels', 'carousels', 'carousels_', 'Carousels')) return false;
		if(!$this->streams->streams->add_stream('Slides', 'slides', 'carousels', 'carousels_', 'Carousel Slides')) return false;
		
		// Common Fields		
		$fields = array(
			array(
				'name' => 'Title',
				'slug' => 'title',
				'namespace' => 'carousels',
				'type' => 'text',
				'extra' => array('max_length' => 20)
			),
			array(
				'name' => 'Slug',
				'slug' => 'slug',
				'namespace' => 'carousels',
				'type' => 'slug',
				'extra' => array('space_type' => '-', 'slug_field' => 'title')
			),
			array(
				'name' => 'Description',
				'slug' => 'description',
				'namespace' => 'carousels',
				'type' => 'wysiwyg',
				'extra' => array('editor_type' => 'simple')
			)
		);
		
		$this->streams->fields->add_fields($fields);
		
		// Assign fields to carousels
		$assign_data = array('title_column' => true, 'required' => true, 'unique' => true);
		$this->streams->fields->assign_field('carousels', 'carousels', 'title', $assign_data);
		
		$assign_data = array('title_column' => false, 'required' => true, 'unique' => true);
		$this->streams->fields->assign_field('carousels', 'carousels', 'slug', $assign_data);
		
		$assign_data = array('title_column' => false, 'required' => true, 'unique' => false);
		$this->streams->fields->assign_field('carousels', 'carousels', 'description', $assign_data);
		
		
		// Assign fields to carousels
		$assign_data = array('title_column' => true, 'required' => true, 'unique' => true);
		$this->streams->fields->assign_field('carousels', 'slides', 'title', $assign_data);
		
		$assign_data = array('title_column' => false, 'required' => true, 'unique' => true);
		$this->streams->fields->assign_field('carousels', 'slides', 'slug', $assign_data);
		
		$carousels = $this->streams->streams->get_stream('carousels', 'carousels');
		
		$stream_fields = array(
			array(
				'name' => 'Caption',
				'slug' => 'caption',
				'namespace' => 'carousels',
				'type' => 'wysiwyg',
				'assign' => 'slides',
				'title_column' => false,
				'required' => false,
				'unique' => false
			),
			array(
				'name' => 'Text',
				'slug' => 'text',
				'namespace' => 'carousels',
				'type' => 'wysiwyg',
				'assign' => 'slides',
				'title_column' => false,
				'required' => false,
				'unique' => false
			),
			array(
				'name' => 'URL',
				'slug' => 'url',
				'namespace' => 'carousels',
				'type' => 'url',
				'assign' => 'slides',
				'title_column' => false,
				'required' => false,
				'unique' => false
			),
			array(
				'name' => 'Image',
				'slug' => 'image',
				'namespace' => 'carousels',
				'type' => 'image',
				'extra' => array('folder' => $carousels_folder_id, 'allowed_types' => 'jpg|jpeg|png'),
				'assign' => 'slides',
				'title_column' => false,
				'required' => false,
				'unique' => false
			),
			array(
				'name' => 'Ordinal',
				'slug' => 'ordinal',
				'namespace' => 'carousels',
				'type' => 'integer',
				'extra' => array('max_length' => 2),
				'assign' => 'slides',
				'title_column' => false,
				'required' => false,
				'unique' => false
			),
			array(
				'name' => 'Carousel',
				'slug' => 'carousel',
				'namespace' => 'carousels',
				'type' => 'relationship',
				'extra' => array('choose_stream' => $carousels->id),
				'assign' => 'slides',
				'title_column' => false,
				'required' => false,
				'unique' => false
			)
		);
		
		$this->streams->fields->add_fields($stream_fields);
			
		return true;
	}

	public function uninstall()
	{
		$this->load->driver('Streams');

        $this->streams->utilities->remove_namespace('carousels');

        return true;
	}


	public function upgrade($old_version)
	{
		// Upgrade Logic
		
		// if($old_version == 'A')
		// {
		// 	// Upgrade from A to B
		// 	
		// 	$old_version = 'B';
		// }
		// 
		// if($old_version == 'B')
		// {
		// 	// Upgrade from B to C
		// 	
		// 	$old_version = 'current';
		// }
		
		return true;
	}
}
/* End of file details.php */
