<?php

class ModelToolMineWhat extends Model {

	private $minewhat_enable;	// MineWhat module install status
	private $minewhat_domain_id;	// MineWhat unique domain id

	// Load config data
	private function init() {

		$this->load->model('setting/setting');

		$this->model_setting_setting->getSetting('minewhat');

		$this->minewhat_enable = $this->config->get('minewhat_enable');

		if ($this->minewhat_enable) {

			$this->minewhat_domain_id = $this->config->get('minewhat_domain_id');

			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('account/order');

		}
	}

	// Returns product data
	public function getMineWhatProductData() {

		$this->init();

		$product_id = $this->request->get['product_id'];
		if(isset($product_id)) {

			// Look up the product info using the product ID
			// Uses function from the catalog/product model
			$product_info = $this->model_catalog_product->getProduct($product_id);

			$mwdata = array();
			$mwdata['product'] = array();
			$mwdata['product']['id'] = $product_id;
			$mwdata['product']['sku'] = $product_info['sku'];
			$mwdata['product']['name'] = $product_info['name'];
			$mwdata['product']['brand'] = $product_info['manufacturer'];
			$mwdata['product']['price'] = $product_info['price'];

			return "//![CDATA[" .
				json_encode($mwdata)
				. "//]]";

		} else {

			return null;

		}

	}

	// Returns product view tracking script
	public function getMineWhatProductTrcakingScript() {

		$this->init();

		if (isset($this->minewhat_enable) && $this->minewhat_enable && isset($this->request->get['product_id'])) {

			$product_id = $this->request->get['product_id'];

			$productData = array(
				"pid" => $product_id
			);

			// Return the javascript text
			$script = 'var _mwapi = _mwapi || [];';
			$script .= '_mwapi.push(["trackEvent", "product", '
					 . json_encode($productData) . ']);' . "\n";
			return $script;

		} else {

			return '';

		}

	}

	// Returns product purchase tracking script
	public function getMineWhatPurchaseTrackingScript($order_id) {

		$this->init();

		if ($this->minewhat_enable) {

			$order_info = $this->model_account_order->getOrder($order_id);
			$order_info_products = $this->model_account_order->getOrderProducts($order_id);

			$products = array();

			// Add ecommerce items for each product in the order before tracking
			foreach ($order_info_products as $order_product) {

				$product = array(
					"pid" => $order_product['product_id'],
					"qty" => $order_product['quantity'],
					"price" => $order_product['price'],
					"revenue" => $order_product['total']
				);
				$products[] = $product;

			}

			$order = array(
				"order_number" => $order_id,
				"email" => $order_info['email'],
				"payment" => $order_info['payment_method']
			);

			$purchaseData = array(
				"products" => $products,
				"order" => $order
			);

			// Return the javascript text
			$script = 'var _mwapi = _mwapi || [];';
			$script .= '_mwapi.push(["trackEvent", "buy", '
					. json_encode($purchaseData) . ']);' . "\n";
			return $script;

		} else {

			return null;

		}

	}

	// MineWhat ID
	public function getMineWhatID() {

		$this->init();

		if (isset($this->minewhat_enable) && $this->minewhat_enable && isset($this->minewhat_domain_id) && strlen($this->minewhat_domain_id) > 0) {
			return explode("_", $this->minewhat_domain_id)[0];
		} else {
			return null;
		}

	}

}
?>
