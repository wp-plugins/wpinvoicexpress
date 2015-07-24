<h3>Drafts</h3>
<table class="wp-list-table widefat fixed">
	<thead>
		<tr>
			<th>Date</th>
			<th>Client</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($drafts as $invoice): ?>
			<tr>
				<td>
					<?php echo $invoice->due_date ?>
					<p><a target="_blank" href="<?php echo $invoice->permalink ?>">draft</a></p>
				</td>
				<td><?php echo $invoice->client->name ?></td>
				<td align="right"><?php echo number_format((float) $invoice->total, 2) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h3>Pending Payment</h3>
<table class="wp-list-table widefat fixed">

	<thead>
		<tr>
			<th>Date</th>
			<th>Client</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($pending as $invoice): ?>
			<tr>
				<td>
					<?php echo $invoice->due_date ?>
					<p><a target="_blank" href="<?php echo $invoice->permalink ?>"><?php echo $invoice->sequence_number ?></a></p>
				</td>
				<td><?php echo $invoice->client->name ?></td>
				<td align="right"><?php echo number_format((float) $invoice->total, 2) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>