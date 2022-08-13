<?php
// Alternative page to page-output.inc.php if you have dynamic content and/or need to handle JSON strings.
// Draw the page.

set_include_path(__DIR__ . ':../../components/html/');

// Is this an ajax call? Set a handy variable to true or false.
$acss = (isset($_POST['_ACSS']) && $_POST['_ACSS'] == 1) ? true : false;
// Was there an ajax type sent over? If so, we'll set a variable for it.
$isJson = (isset($_POST['_ACSSTYPE']) && $_POST['_ACSSTYPE'] == 'JSON') ? true : false;

if ($acss && $isJson) {
	// This is an JSON-type ajax call - we will want all output to be in a string format.
	// Start the output buffer, which puts the output into memory rather than back to the browser.
	// We'll take the output out of the buffer later on, and then put it into a variable.
	ob_start();
}

// if (!$acss) {
// 	// Not ajax - we need to show the whole page. Either refresh was hit or the URL was gone to directly.
// 	include 'header.inc.php';
// 	include 'menu.inc.php';
// }

set_include_path(__DIR__ . ':../../components/html/');

// We always output the page contents at the very least.
include $pageInclude . '.php';

// if (!$acss) {
// 	// Not ajax - we need to show the whole page. Either refresh was hit or the URL was gone to directly.
// 	include 'footer.inc.php';
// }

if ($acss && $isJson) {
	// This is a JSON-type ajax call. We'll make a JSON array.
	$jsonArray = [];

	// Clean the output buffer and put the page data generated so far, it will be a string, into an item in an array.
	$jsonArray['result'] = ob_get_clean();

	// Convert the array to a JSON string, as we can't sent an array to the front-end. We need it in JSON format as a string.
	$jsonString = json_encode($jsonArray);

	// Tell the front-end that all is ok.
	http_response_code(200);

	// Send back the results.
	// In this case, it will be found as {result} on the front-end in Active CSS.
	// (if it isn't done by this JSON way, the ajax variable will be {$STRING}.)
	echo ($jsonString);
	flush();
}

// That's it. The page has been sent to the front-end.
// If there was an ajax call but it was in HTML format, not JSON, then the contents has already been sent.
