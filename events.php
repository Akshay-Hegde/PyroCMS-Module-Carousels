<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * UDL Courses Module Events
 *
 *
 * @author 		Phil Martinez - Philsquare Dev Team
 * @website		http://philsquare.com
 * @package 	PyroCMS
 */
class Events_Carousels {
    
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        
        Events::register('admin_controller', array($this, 'hello'));

		Events::register('whatever', array($this, 'custom'));
    }
    
    public function hello()
    {
		// Hi There
    }

	public function custom()
	{
		// Custom trigger set with Events::trigger('whatever')
	}
}
/* End of file events.php */