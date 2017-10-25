<?php

//pull in login credentials and CURL access function
 require_once("utils.php");

//create a payload that we can then pass to JIRA with JSON
$jql = array(
	'jql' => 'created > -1d'
);

/*define a function that calls the right REST API
We convert the array to JSON inside of the function. */
function search_issue($issue) {
	return get_from('search', $issue);
}

//call JIRA.
$result = search_issue($jql);

//check for errors
if (property_exists($result, 'errors')) {
	echo "Error(s) searching for issues:\n";
	var_dump($result);
} else {
	//print out the issue keys and summaries
	echo "Here are the issue keys and summaries\n";
	foreach ($result->issues as &$issue) {
    	echo($issue->key . "  " . $issue->fields->summary . "\n");
	}
}

?>