<?php
namespace MoS\LAN\Controllers;

use MoS\LAN\Models\PageModel;

class PageController
{
	private $model;
	
    public function __construct(PageModel $model)
    {
	    $this->model = $model;
    }
    
    /*
	* Sets the model to get the item equal to the given criteria
	* 
	* @return bool True if at least one result was found
	*/
    public function get($name)
    {
	    $this->model->setCriteria($name);
	    return $this->model->hasData();
    }
}