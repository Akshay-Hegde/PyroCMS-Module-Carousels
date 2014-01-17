<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Plugin sample for the carousels template module
 *
 * @author 		Phil Martinez - Philsquare Dev Team
 * @website		http://philsquarelabs.com
 * @package 	PyroCMS
 * @subpackage 	Template Module
 */
class Plugin_Carousels extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Carousels'
	);
	public $description = array(
		'en' => 'Carousels description'
	);
	
	public function _self_doc()
	{
		$info = array(
			'method' => array(
				'description' => array(
					'en' => ''
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			)
		);
	
		return $info;
	}
	
	public function carousel()
	{
		$carousel_id = $this->attribute('id', null);
		
		$params = array(
			'stream' => 'slides',
			'namespace' => 'carousels',
			'where' => "`carousel` = '$carousel_id'",
			'disable' => 'created|updated|created_by',
			'order_by' => 'ordinal'
		);
		
		$slides = $this->streams->entries->get_entries($params);
		
		return $slides['entries'];
	}
	
	public function bootstrap()
	{
		$carousel_id = $this->attribute('id', null);
		
		$params = array(
			'stream' => 'slides',
			'namespace' => 'carousels',
			'where' => "`carousel` = '$carousel_id'",
			'disable' => 'created|updated|created_by',
			'order_by' => 'ordinal'
		);
		
		$slides = $this->streams->entries->get_entries($params);
		
		return $this->load->view('carousels/snippets/bootstrap', array('slides' => $slides['entries']), true);
	}

}

/* End of file plugin.php */