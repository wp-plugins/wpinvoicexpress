<?php

class RCDashboard implements Extension {


	public static function enable() {

		add_action('wp_dashboard_setup', function() {

			wp_add_dashboard_widget('rc_ix_dashboard_widget_pending_payments', 'Invoicexpress Pending', [ __CLASS__, 'renderDashboardWidgetPendingPayments' ]);

			wp_add_dashboard_widget('rc_ix_dashboard_widget_chart', 'Invoicexpress Chart', [ __CLASS__, 'renderDashboardWidgetChart' ]);

		});

		add_action( 'wp_ajax_get_chart_data', [ __CLASS__, 'getChartData'] );

	}

	public static function getChartData() {

		RCCore::includeVendor('InvoicexpressClient/InvoicexpressInvoices');

		$options = get_option( 'wpie_settings' );

		$Invoices = new InvoicexpressInvoices($options['domain'], $options['api_key']);

		$data = $Invoices->chart();

		$labels = (array) $data->series->value;
		$values = (array) $data->graphs->graph->value;

		array_shift($labels);
		array_shift($values);

		die(json_encode([ 'labels' => $labels, 'data' => $values ]));

	}

	public static function renderDashboardWidgetChart() {

		$options = get_option( 'wpie_settings' );

		if (!empty($options)) {

			RCCore::includeScript('Chart', 'assets/js/Chart.min.js', '1.0.2');
			RCCore::includeScript('ieapp', 'assets/js/app.js', '1.0.0');
			RCCore::render('widget_dashboard_chart');

		} else {

			RCCore::render('el_config_missing');
			RCCore::render('el_affiliate');

		}

	}

	public static function renderDashboardWidgetPendingPayments() {

		RCCore::includeVendor('InvoicexpressClient/InvoicexpressInvoices');

		$options = get_option( 'wpie_settings' );

		if (!empty($options)) {

			$Invoices = new InvoicexpressInvoices($options['domain'], $options['api_key']);

			$pending = $Invoices->all()->filter('status', 'final');
			$drafts = $Invoices->filter('status', 'draft');

			RCCore::render('widget_dashboard_invoices', [ 'pending' => $pending, 'drafts' => $drafts ]);

		} else {

			RCCore::render('el_config_missing');
			RCCore::render('el_affiliate');

		}

	}

}