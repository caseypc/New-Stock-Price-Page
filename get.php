<?php
	echo '<tr>
			<td>Company Name</td>
			<td>Symbol</td>
			<td>Price</td>
		</tr>';
	$symbols = array("AAPL", "FB", "AMZN", "TWTR", "GOOG", "IBM", "MSFT", "AMD", "F", "GE");

	$lists = "";

	foreach($symbols as $stock) {
		$lists = $lists . $stock . ",";
	}

	$lists = substr($lists, 0, -1);

	$call = "https://api.iextrading.com/1.0/stock/market/batch?symbols=$lists&types=quote";
	$content = file_get_contents($call);
	$data = json_decode($content, true);
			
	foreach ($symbols as $stocks) {
	$price = $data[$stocks]['quote']['latestPrice'];
	$name = $data[$stocks]['quote']['companyName'];
	$close = $data[$stocks]['quote']['close'];

	if(empty($name)) {
		$price = "N/A";
		$stocks = "N/A";
		$name = "N/A";
	}
		
	if ($price >= $close) {
		$pricestatus = '<span style="color: green">'.$price.'</span>';
	} else {
		$pricestatus = '<span style="color: red">'.$price.'</span>';
	}

	echo '<tr>
			<td>'.$name.'</td>
			<td>'.$stocks.'</td>
			<td>'.$pricestatus.'</td>
		</tr>';
}
