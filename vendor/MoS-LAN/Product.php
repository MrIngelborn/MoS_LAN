<?php

class Product {
	var $id;
	var $barcode;
	var $name;
	var $price;
	
	function __construct($id, $barcode, $name, $price) {
		$this->id = $id;
		$this->barcode = $barcode;
		$this->name = $name;
		$this->price = $price;
	}
}
	
?>