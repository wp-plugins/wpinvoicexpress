<?php

class RCDashboard implements Extension {


	public static function enable() {

		add_action('wp_dashboard_setup', function() {

			wp_add_dashboard_widget('rc_ix_dashboard_widget_pending_payments', 'Invoicexpress Pending', [ __CLASS__, 'renderDashboardWidgetPendingPayments' ]);

			wp_add_dashboard_widget('rc_ix_dashboard_widget_chart', 'Invoicexpress Chart', [ __CLASS__, 'renderDashboardWidgetChart' ]);

		});

	}

	public function renderDashboardWidgetChart() {

		RCCore::includeVendor('InvoicexpressClient/InvoicexpressInvoices');

		$options = get_option( 'wpie_settings' );

		if (!empty($options)) {

			$Invoices = new InvoicexpressInvoices($options['domain'], $options['api_key']);

			$data = $Invoices->chart();

			$labels = (array) $data->series->value;
			$values = (array) $data->graphs->graph->value;

			array_shift($labels);
			array_shift($values);

			RCCore::render('widget_dashboard_chart', [ 'labels' => $labels, 'data' => $values ]);

		} else {

			RCCore::render('el_config_missing');
			RCCore::render('el_affiliate');

		}

	}

	public function renderDashboardWidgetPendingPayments() {

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