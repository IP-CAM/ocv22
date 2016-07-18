<?php
class ControllerSaleOrderVolusion extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/order_volusion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order_volusion');

		$this->getList();
	}

	public function add() {
		$this->load->language('sale/order_volusion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order_volusion');

		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/order_volusion');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order_volusion');

		$this->getForm();
	}

	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], true);
		$data['shipping'] = $this->url->link('sale/order/shipping', 'token=' . $this->session->data['token'], true);
		$data['add'] = $this->url->link('sale/order/add', 'token=' . $this->session->data['token'], true);

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'      => $filter_order_id,
			'filter_customer'	   => $filter_customer,
			'filter_order_status'  => $filter_order_status,
			'filter_total'         => $filter_total,
			'filter_date_added'    => $filter_date_added,
			'filter_date_modified' => $filter_date_modified,
			'sort'                 => $sort,
			'order'                => $order,
			'start'                => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_sale_order_volusion->getTotalOrders($filter_data);

		$results = $this->model_sale_order_volusion->getOrders($filter_data);

		foreach ($results as $result) {
			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'order_status'  => $result['order_status'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'shipping_code' => $result['shipping_code'],
				'edit'          => $this->url->link('sale/order_volusion/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, true),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_order_id'] = $this->language->get('entry_order_id');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');

		$data['button_invoice_print'] = $this->language->get('button_invoice_print');
		$data['button_shipping_print'] = $this->language->get('button_shipping_print');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_ip_add'] = $this->language->get('button_ip_add');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, true);
		$data['sort_status'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);
		$data['sort_total'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_order_status'] = $filter_order_status;
		$data['filter_total'] = $filter_total;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

		// API login
		$this->load->model('user/api');

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			$data['api_id'] = $api_info['api_id'];
			$data['api_key'] = $api_info['key'];
			$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
		} else {
			$data['api_id'] = '';
			$data['api_key'] = '';
			$data['api_ip'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/order_volusion_list', $data));
	}

	public function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['act_complete_order'] = $this->url->link('sale/order_volusion/complete_order', 'token=' . $this->session->data['token'] . $url, true);
		$data['act_jump'] = $this->url->link('sale/order_volusion/edit', 'token=' . $this->session->data['token'] . $url, true);
		$data['act_list'] = $this->url->link('sale/order_volusion', 'token=' . $this->session->data['token'] . $url, true);
		$data['act_customer'] = $this->url->link('customer/customer/edit', 'token=' . $this->session->data['token'] . $url, true);

		/* This is to add necessary columns to order, customer tables */
		$this->model_sale_order_volusion->addColumns();
		$this->model_sale_order_volusion->addPaymentTable();
		/* This is to add necessary columns to order, customer tables */

		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_sale_order_volusion->getOrder($this->request->get['order_id']);
		}

		if (!empty($order_info)) {
			$data['order_id'] = $this->request->get['order_id'];
			$data['store_id'] = $order_info['store_id'];
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

			$data['customer'] = $order_info['customer'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['customer_group_id'] = $order_info['customer_group_id'];
			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['fax'] = $order_info['fax'];
			$data['account_custom_field'] = $order_info['custom_field'];

			$this->load->model('customer/customer');

			$data['addresses'] = $this->model_customer_customer->getAddresses($order_info['customer_id']);

			$data['payment_firstname'] = $order_info['payment_firstname'];
			$data['payment_lastname'] = $order_info['payment_lastname'];
			$data['payment_company'] = $order_info['payment_company'];
			$data['payment_address_1'] = $order_info['payment_address_1'];
			$data['payment_address_2'] = $order_info['payment_address_2'];
			$data['payment_city'] = $order_info['payment_city'];
			$data['payment_postcode'] = $order_info['payment_postcode'];
			$data['payment_country_id'] = $order_info['payment_country_id'];
			$data['payment_country'] = $order_info['payment_country'];
			$data['payment_zone_id'] = $order_info['payment_zone_id'];
			$data['payment_zone'] = $order_info['payment_zone'];
			$data['payment_custom_field'] = $order_info['payment_custom_field'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['payment_code'] = $order_info['payment_code'];

			$data['shipping_firstname'] = $order_info['shipping_firstname'];
			$data['shipping_lastname'] = $order_info['shipping_lastname'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address_1'] = $order_info['shipping_address_1'];
			$data['shipping_address_2'] = $order_info['shipping_address_2'];
			$data['shipping_city'] = $order_info['shipping_city'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_country_id'] = $order_info['shipping_country_id'];
			$data['shipping_country'] = $order_info['shipping_country'];
			$data['shipping_zone_id'] = $order_info['shipping_zone_id'];
			$data['shipping_zone'] = $order_info['shipping_zone'];
			$data['shipping_custom_field'] = $order_info['shipping_custom_field'];
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['shipping_code'] = $order_info['shipping_code'];

			// Products
			$data['order_products'] = array();

			$products = $this->model_sale_order_volusion->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$data['order_products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $this->model_sale_order_volusion->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
					'quantity'   => $product['quantity'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'reward'     => $product['reward']
				);
			}

			// Vouchers
			$data['order_vouchers'] = $this->model_sale_order_volusion->getOrderVouchers($this->request->get['order_id']);

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';

			$data['order_totals'] = array();

			$order_totals = $this->model_sale_order_volusion->getOrderTotals($this->request->get['order_id']);

			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');

				if ($start && $end) {
					$data[$order_total['code']] = substr($order_total['title'], $start, $end - $start);
				}
			}

			$data['order_status_id'] = $order_info['order_status_id'];
			$data['comment'] = $order_info['comment'];

			$data['affiliate_id'] = $order_info['affiliate_id'];
			$data['affiliate'] = $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'];
			$data['currency_code'] = $order_info['currency_code'];

			$data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

			$data['date_added'] = date('m/d/Y h:iA', strtotime($order_info['date_added']));
			$data['date_modified'] = date('m/d/Y h:iA', strtotime($order_info['date_modified']));
			$data['ip'] = $order_info['ip'];
			$data['user_agent'] = $order_info['user_agent'];
			$data['date_shipped'] = $order_info['date_shipped'];
			$data['internal_comment'] = $order_info['internal_comment'];
			$data['gift_comment'] = $order_info['gift_comment'];
			$data['customer_comment'] = $order_info['customer_comment'];
		} else {
			$data['order_id'] = 0;
			$data['store_id'] = '';
			$data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
			
			$data['customer'] = '';
			$data['customer_id'] = '';
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$data['firstname'] = '';
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['fax'] = '';
			$data['customer_custom_field'] = array();

			$data['addresses'] = array();

			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_company'] = '';
			$data['payment_address_1'] = '';
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_country_id'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_custom_field'] = array();
			$data['payment_method'] = '';
			$data['payment_code'] = '';

			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_custom_field'] = array();
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';

			$data['order_products'] = array();
			$data['order_vouchers'] = array();
			$data['order_totals'] = array();

			$data['order_status_id'] = $this->config->get('config_order_status_id');
			$data['comment'] = '';
			$data['affiliate_id'] = '';
			$data['affiliate'] = '';
			$data['currency_code'] = $this->config->get('config_currency');

			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
		}

		// Stores
		$this->load->model('setting/store');

		$data['stores'] = array();

		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default'),
		);

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}

		// Customer Groups
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// Custom Fields
		$this->load->model('customer/custom_field');

		$data['custom_fields'] = array();

		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);

		$custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

		foreach ($custom_fields as $custom_field) {
			$data['custom_fields'][] = array(
				'custom_field_id'    => $custom_field['custom_field_id'],
				'custom_field_value' => $this->model_customer_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
				'name'               => $custom_field['name'],
				'value'              => $custom_field['value'],
				'type'               => $custom_field['type'],
				'location'           => $custom_field['location'],
				'sort_order'         => $custom_field['sort_order']
			);
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['voucher_min'] = $this->config->get('config_voucher_min');

		$this->load->model('sale/voucher_theme');

		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

		// API login
		$this->load->model('user/api');

		$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

		if ($api_info) {
			$data['api_id'] = $api_info['api_id'];
			$data['api_key'] = $api_info['key'];
			$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
		} else {
			$data['api_id'] = '';
			$data['api_key'] = '';
			$data['api_ip'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['accordion_payments'] = $this->getOrderPaymentsHtml($this->request->get['order_id']); /*Accordion payments-tab*/
		$data['savedCcHtml'] = $this->savedCcHtml($this->request->get['order_id']);

		$this->response->setOutput($this->load->view('sale/order_volusion_form', $data));
	}

	private function getTotals() {
		$this->session->data['catalog_model'] = 1;
		$this->load->model('setting/extension');
		$return_data = array();
		$total_data = array();			
		$total = 0;
		$taxes = $this->cart->getTaxes();
		$sort_order = array(); 
		$results = $this->model_setting_extension->getExtensions('total'); //no need
		if (isset($this->session->data['optional_fees'])) {
			$s = 900;
			foreach ($this->session->data['optional_fees'] as $optional_fee) {
				$results[] = array(
					'extension_id'	=> $s,
					'type'			=> 'total',
					'code'			=> $optional_fee['code']
				);
				$s++;
			}
		}
		foreach ($results as $key => $value) {
			$found = false;
			if (isset($this->session->data['optional_fees'])) {
				foreach ($this->session->data['optional_fees'] as $optional_fee) {
					if ($value['code'] == $optional_fee['code']) {
						$sort_order[$key] = $optional_fee['sort_order'];
						$found = true;
					}
				}
			}
			if (!$found) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
		}
		array_multisort($sort_order, SORT_ASC, $results);
		
		foreach ($results as $result) {
			$found = false;
			if (isset($this->session->data['optional_fees'])) {
				foreach ($this->session->data['optional_fees'] as $optional_fee) {
					if ($result['code'] == $optional_fee['code']) {
						$sub_total = $this->cart->getSubTotal();
						if ($optional_fee['type'] == "p-amt" || $optional_fee['type'] == "p-per") {
							if ($optional_fee['type'] == "p-amt") {
								$amount = $optional_fee['value'];
							} elseif ($optional_fee['type'] == "p-per") {
								$amount = ($sub_total * $optional_fee['value']) / 100;
							}
							if ($optional_fee['taxed'] && $optional_fee['tax_class_id'] && ($optional_fee['type'] == 'p-amt' || $optional_fee['type'] == 'p-per')) {
								if (version_compare(VERSION, '1.5.1.2', '>')) {
									$tax_rates = $this->tax->getRates($amount, $optional_fee['tax_class_id']);
									foreach ($tax_rates as $tax_rate) {
										if (!isset($taxes[$tax_rate['tax_rate_id']])) {
											$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
										} else {
											$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
										}
									}
								} else {
									if (!isset($taxes[$optional_fee['tax_class_id']])) {
										$taxes[$optional_fee['tax_class_id']] = $amount / 100 * $this->tax->getRate($optional_fee['tax_class_id']);
									} else {
										$taxes[$optional_fee['tax_class_id']] += $amount / 100 * $this->tax->getRate($optional_fee['tax_class_id']);
									}
								}
							}
						} else {
							$amount = 0;
							if ($optional_fee['type'] == "m-amt") {
								$discount_min = min($optional_fee['value'], $sub_total);
							}
							foreach ($this->cart->getProducts() as $product) {
								$discount = 0;
								if ($optional_fee['type'] == "m-amt") {
									$discount = $discount_min * ($product['total'] / $sub_total);
								} elseif ($optional_fee['type'] == "m-per") {
									$discount = ($product['total'] * $optional_fee['value']) / 100;
								}
								if ($product['tax_class_id'] && $optional_fee['pre_tax'] == 1) {
									$tax_rates = $this->tax->getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);
									foreach ($tax_rates as $tax_rate) {
										if ($tax_rate['type'] == 'P') {
											$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
										}
									}
								}
								$amount -= $discount;
							}
							if ($optional_fee['shipping'] && isset($this->session->data['shipping_method'])) {
								$discount = 0;
								foreach ($this->session->data['shipping_methods'] as $shipping_method) {
									foreach ($shipping_method['quote'] as $quote) {
										if ($quote['code'] == $this->session->data['shipping_method']['code']) {
											if ($optional_fee['type'] == "m-amt") {
												if ($quote['cost'] >= $optional_fee['value']) {
													$discount = $optional_fee['value'];
												} else {
													$discount = $quote['cost'];
												}
											} elseif ($optional_fee['type'] == "m-per") {
												$discount = ($quote['cost'] * $optional_fee['value']) / 100;
											}
											if ($this->session->data['shipping_method']['tax_class_id'] && $optional_fee['pre_tax'] == 1) {
												foreach ($tax_rates as $tax_rate) {
													if (version_compare(VERSION, '1.5.1.2', '>')) {
														$tax_rates = $this->tax->getRates($quote['cost'] - ($quote['cost'] - $discount), $this->session->data['shipping_method']['tax_class_id']);
														foreach ($tax_rates as $tax_rate) {
															if (!isset($taxes[$tax_rate['tax_rate_id']])) {
																$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
															} else {
																$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
															}
														}
													} else {
														if (!isset($taxes[$this->session->data['shipping_method']['tax_class_id']])) {
															$taxes[$this->session->data['shipping_method']['tax_class_id']] = $discount / 100 * $this->tax->getRate($this->session->data['shipping_method']['tax_class_id']);
														} else {
															$taxes[$this->session->data['shipping_method']['tax_class_id']] -= $discount / 100 * $this->tax->getRate($this->session->data['shipping_method']['tax_class_id']);
														}
													}
												}
											}
										}
									}
								}
								$amount -= $discount;
							}
						}
						$total += $amount;
						$text = $this->currency->format($amount);
						$total_data[] = array(
							'code'			=> $optional_fee['code'],
							'title'			=> $optional_fee['title'],
							'text'			=> $text,
							'value'			=> $amount,
							'sort_order'	=> $optional_fee['sort_order']
						);
						$found = true;
					}
				}
			}
			if (!$found) {
				if ($this->config->get($result['code'] . '_status')) {
					if (version_compare(VERSION, '1.5.2', '<') && $result['code'] != "tax") {
						$this->language->load('oentrytotal/' . $result['code']);
					} elseif (version_compare(VERSION, '1.5.1.3.1', '>')) {
						$this->language->load('oentrytotal/' . $result['code']);
					}
					$this->load->model('total/' . $result['code']);
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
			$sort_order = array(); 
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			array_multisort($sort_order, SORT_ASC, $total_data);			
		}
		
		
		unset($this->session->data['catalog_model']);
		$return_data = array(
			'total_data'	=> $total_data,
			'total'			=> $total,
			'taxes'			=> $taxes
		);
		return $return_data;
	}

	private function savedCcHtml($order_id) {
		$cards = $this->model_sale_order_volusion->getSavedCards($order_id, 'credit_card');
		
		$payment_types = array(
			'credit_card' => 'Credit Card',
			'paypal'	=> 'Paypal',
			'check'		=> 'Check',
			'cash'		=> 'Cash',
			'wire'		=> 'Wire Transfer',
			'bank'		=> 'Bank Deposit',
			'other'		=> 'Other'
		);
		$card_types = array('3'=>'Amex', '4'=>'Visa', '5' =>'MasterCard', '6'=>'Discover');
		
		$res_html = "<option value=''>Select</option>";
		foreach($cards as $card) {
			$value = base64_decode($card['cc_number']);
			$value.= ",".$card['cc_type'].",".$card['cc_name'].",".str_replace("-",",",$card['cc_exp_month_year']).",".base64_decode($card['cc_cvv']);
			$res_html .= "<option value='{$value}'>{$card_types[$card['cc_type']]} {$card['pay_details']}</option>";
		}
		
		return $res_html;
	}

	private function getOrderPaymentsHtml($order_id) {
		$payment_records = $this->model_sale_order_volusion->getOrderPayments($order_id);
		$payment_records_html = "";
		
		$payment_types = array(
			'credit_card' => 'Credit Card',
			'paypal'	=> 'Paypal',
			'check'		=> 'Check',
			'cash'		=> 'Cash',
			'wire'		=> 'Wire Transfer',
			'bank'		=> 'Bank Deposit',
			'other'		=> 'Other'
		);
		$card_types = array('3'=>'Amex', '4'=>'Visa', '5' =>'MasterCard', '6'=>'Discover');
		
		//$totals = $this->getTotals();
		$balance_due = 0;//$totals['total'];
		
		foreach($payment_records as $payment) {
			$payment_records_html .= "<tr>
				<td>".date('n/j/Y g:i A', strtotime($payment['created']))."</td>";
			
			switch($payment['payment_method']) {
				case 'credit_card': case 'paypal': case 'wire': case 'bank': case 'check': case 'cash':
					$payment_records_html .= "<td>".$payment_types[$payment['payment_method']]." | ".($payment['pay_option']=='received' ? "<span style='color:#333;'>Received</span>":($payment['pay_option']=='deposited' ? "<span style='color:#33D;'>Deposited</span>":"<span style='color:#D33;'>Refunded</span>"))."</td>";
					break;
				case 'other': 
					$payment_records_html .= "<td>".$payment['other_payment_type_name']." | ".($payment['pay_option']=='received' ? "<span style='color:#333;'>Received</span>":($payment['pay_option']=='deposited' ? "<span style='color:#33D;'>Deposited</span>":"<span style='color:#D33;'>Refunded</span>"))."</td>";
					break;
				default:
					$payment_records_html .= "<td>".$payment_types[$payment['payment_method']]."</td>";
					break;
			}
			
			$payment_records_html .= "<td>".($payment['chk_not_balance'] == 0 ? "Yes":"No")."</td>";
			
			switch($payment['payment_method']) {
				case 'paypal':
					$payment_records_html .= "<td>{$payment['payer_paypal_email']}</td>";
					break;
				case 'credit_card':
					$card_type = $card_types[$payment['cc_type']];
					$payment_records_html .= "<td>{$card_type} {$payment['pay_details']}</td>";
					break;
				case 'check': 
					$payment_records_html .= "<td>".base64_decode($payment['check_deposit_account'])."</td>";
					break;
				case 'cash': 
					$payment_records_html .= "<td>".base64_decode($payment['cash_deposit_account'])."</td>";
					break;
				case 'bank': 
					$payment_records_html .= "<td>".base64_decode($payment['bank_deposit_account'])."</td>";
					break;
				case 'wire': case 'other': default:
					$payment_records_html .= "<td>".$payment['pay_details']."</td>";
					break;
			}
			
			$payment_records_html .= "<td>".$this->currency->format($payment['pay_amount'])."</td>";
			
			if($payment['chk_not_balance'] == 0) {
				if($payment['pay_option'] == 'refunded') { // Refunded Money
					$balance_due += $payment['pay_amount'];
				}
				else {
					$balance_due -= $payment['pay_amount'];
				}
				
				$payment_records_html .= "<td>".$this->currency->format($balance_due)."</td>";
			} else {
				$payment_records_html .= "<td>".$this->currency->format($balance_due)."</td>";
			}
			
			$payment_records_html .= "
				<td align='center'><a href='javascript:void(0);' data-role={$payment['order_payment_id']} class='remove_payment_record'>&nbsp;</a></td>
			</tr>";
			
			switch($payment['payment_method']) {
				case 'paypal':
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>AuthCode:</label><span class='value'>{$payment['payer_paypal_email']}</span>
								<label>TransID:</label><span class='value'>{$payment['trans_id']}</span>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
				case 'credit_card':
					$card_type = $card_types[$payment['cc_type']];
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>Card #:</label><span class='value'>{$payment['pay_details']}</span>
								<label>Card Type:</label><span class='value'>{$card_type}</span>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
				case 'check':
					if($payment['check_received_date']) {
						$l_date = "Received Date";
						$v_date = date('m/d/Y', strtotime($payment['check_received_date']));
					}
					elseif($payment['check_deposit_date']) {
						$l_date = "Deposited Date";
						$v_date = date('m/d/Y', strtotime($payment['check_deposit_date']));
					}
					else {
						$l_date = "Refunded Date";
						$v_date = date('m/d/Y', strtotime($payment['check_refund_date']));
					}
							
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>Check #:</label><span class='value'>{$payment['pay_details']}</span>
								<label>{$l_date}:</label><span class='value'>{$v_date}</span>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
				case 'cash': 
					if($payment['cash_received_date']) {
						$l_date = "Received Date";
						$v_date = date('m/d/Y', strtotime($payment['cash_received_date']));
					}
					elseif($payment['cash_deposit_date']) {
						$l_date = "Deposited Date";
						$v_date = date('m/d/Y', strtotime($payment['cash_deposit_date']));
					}
					else {
						$l_date = "Refunded Date";
						$v_date = date('m/d/Y', strtotime($payment['cash_refund_date']));
					}
							
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>{$l_date}:</label><span class='value'>{$v_date}</span>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
				case 'other': default:
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
				case 'wire':
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>Transfer Date:</label><span class='value'>".date('m/d/Y', strtotime($payment['wire_transfer_date']))."</span>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
				case 'bank':
					$payment_records_html .= "<tr class='note'>
						<td colspan='7'>
						    <div>
								<label>Deposited Date:</label><span class='value'>".date('m/d/Y', strtotime($payment['bank_deposit_date']))."</span>
								<label>Note:</label><span class='value'>{$payment['note']}</span>
						    </div>
						</td>
					</tr>";
					break;
			}
		}
		
		return $payment_records_html;
	}
	public function complete_order() {
		$this->load->model('sale/order_volusion');

		$order_id = $this->request->get['order_id'];
		$email = $this->request->get['email'];

		$date_shipped = date('Y-m-d H:i:s');
		$this->model_sale_order_volusion->completeOrder($order_id, $date_shipped);
		
		$this->session->data['success'] = $this->language->get('text_success');
		
		$this->redirect($this->url->link('sale/order_volusion/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id . $url, 'SSL'));
	}
	public function addOrderPayment(){	
		$post = $this->request->post;
		$this->load->model('sale/order_volusion');
		$saved_card = $this->model_sale_order_volusion->addOrderPayment($post);
		$payment_log = array('orderHtml'=>"", 'savedCcHtml'=>"",);
		$payment_log['orderHtml'] = $this->getOrderPaymentsHtml($post['order_id']);	
		
		if (isset($post['pay_cc_save'])) $payment_log['savedCcHtml'] = $this->savedCcHtml($post['order_id']);
		

		$this->response->setOutPut(json_encode($payment_log));
	}

	public function delOrderPayment(){
		$order_payment_id = $this->request->post['order_payment_id'];
		$this->load->model('sale/order_volusion');
		$this->model_sale_order_volusion->delOrderPayment($order_payment_id);
		$this->response->setOutPut('success');
	}
}
