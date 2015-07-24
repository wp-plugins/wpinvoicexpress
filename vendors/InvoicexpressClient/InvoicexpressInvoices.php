<?php

require_once 'InvoicexpressAPIClient.php';
require_once 'FilterInterface.php';

class InvoicexpressInvoices extends InvoicexpressAPIClient implements Filter {

	protected $items = [];


	public function chart() {

		return $this->fetch('api/charts/invoicing');

	}


	public function all($page = null) {

		$this->items = $this->fetch('invoices');

		return $this;

	}

	public function get() {

		return $this->items;

	}

	public function filter($field, $value) {

		$xpath = "/invoices/invoice[{$field} = '{$value}']";
		$nodes = $this->items->xpath($xpath);

		return $nodes;

	}

}