<?php
	//echoes first row in table
	echo '<tr>
			<td>Company Name</td>
			<td>Symbol</td>
			<td>Price</td>
		</tr>';
	//array of stocks that will be analyzed
	$symbols = array("AAPL", "FB", "AMZN", "TWTR", "GOOG", "IBM", "MSFT", "AMD", "F", "GE");
	
	$lists = "";
	
	//loop adds each stock in array above to the blank "lists" variable, along with a comma
	foreach($symbols as $stock) {
		$lists = $lists . $stock . ",";
	}
	
	//trims off the last comma in the "lists" variable string
	$lists = substr($lists, 0, -1);
	
	//makes one API batch call using the "lists" variable from above
	$call = "https://api.iextrading.com/1.0/stock/market/batch?symbols=$lists&types=quote";
	$content = file_get_contents($call);
	$data = json_decode($content, true);
	
	//reads each stock from the returned data array using the "symbols" array
	foreach ($symbols as $stocks) {
	$price = $data[$stocks]['quote']['latestPrice'];
	$name = $data[$stocks]['quote']['companyName'];
	$close = $data[$stocks]['quote']['close'];
	
	//assigns values to variables if the stock symbol does not exist
	if(empty($name)) {
		$price = "N/A";
		$stocks = "N/A";
		$name = "N/A";
	}
	
	//changes color of price if stock is higher or lower than closing price of the previous day
	if ($price >= $close) {
		$pricestatus = '<span style="color: green">'.$price.'</span>';
	} else {
		$pricestatus = '<span style="color: red">'.$price.'</span>';
	}
	
	//echoes data from API into a table row
	echo '<tr>
			<td>'.$name.'</td>
			<td>'.$stocks.'</td>
			<td>'.$pricestatus.'</td>
		</tr>';
}
