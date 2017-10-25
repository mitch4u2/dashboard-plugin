<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/admin
 * @author     Mohamed Hajjej <mohamed.hajjej@esprit.tn>
 */

namespace admin;

class User {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $username;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $password;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	public function __construct( $username, $password ) {

		$this->username = $username;
		$this->password = $password;

	}


	public function login($username,$password){
		echo $username.'<br>';
		echo $password;
		//$base64_usrpwd = base64_encode('harm:hu1z3putm4n');
		$base64_usrpwd = base64_encode($username.':'.$password);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/user?username='.$username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		echo '<pre>';
		var_dump( $httpcode );
		echo '</pre>';

		if ( $httpcode != 200 ) {
			echo '<h1>MR ANDERSON WELCOME BACK WE MISSED YOU</h1>';
			echo "cURL Error: $ch_error";

		} else {

			echo $curl_response;
			$character = json_decode($curl_response);
			echo '<br><br><br><br><br><br>';
			if ( ! empty($character->emailAddress)  ) {
				echo $character->emailAddress;
			}else{echo 'EROOR MY BROTHER no email address';}
			echo '<br><br>';
			if ( ! empty($character->displayName)  ) {
				echo $character->displayName;
			}else{echo 'EROOR MY BROTHER no email address';}

		}

		curl_close($ch);


	}



	public function signin($username,$password){
		/*echo $username.'<br>';
		echo $password.'<br>';
		//$base64_usrpwd = base64_encode('harm:hu1z3putm4n');
		$base64_usrpwd = base64_encode($username.':'.$password);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/user?username='.$username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		echo '<pre>';
		var_dump( $httpcode );
		echo '</pre>';

		if ($httpcode != 201 ) {
			echo '<h1>MR ANDERSON WELCOME BACK WE MISSED YOU</h1>';
			echo "cURL Error: $ch_error";

		} else {

			echo $curl_response;
			$character = json_decode($curl_response);
			echo '<br><br><br><br><br><br>';
			if ( ! empty($character->emailAddress)  ) {
				echo $character->emailAddress;
			}else{echo 'EROOR MY BROTHER no email address';}
			echo '<br><br>';
			if ( ! empty($character->displayName)  ) {
				echo $character->displayName;
			}else{echo 'EROOR MY BROTHER no email address';}

		}

		curl_close($ch);


*/




		$base64_usrpwd = base64_encode($username.':'.$password);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/servicedeskapi/customer');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'X-ExperimentalApi: opt-in',
			'Authorization: Basic '.$base64_usrpwd));
		$arr['email'] = 'wrabbit@live.fr';
		$arr['fullName'] = 'abracadabra';
		$json_string = json_encode ($arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;




		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/password/policy/updateUser');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'X-ExperimentalApi: opt-in',
			'Authorization: Basic '.$base64_usrpwd));
		$arr['username'] = 'wrabbit@live.fr';
		$arr['oldPassword'] = 'abracadabra';
		$json_string = json_encode ($arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;





		{
    "username": "fred",
    "oldPassword": "secret",
    "newPassword": "correcthorsebatterystaple"
}

		/*$ch_error = curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		echo '<pre>';
		var_dump( $httpcode );
		echo '</pre>';

		if ($httpcode != 201 ) {
			echo '<h1>MR ANDERSON WELCOME BACK WE MISSED YOU</h1>';
			echo "cURL Error: $ch_error";

		} else {

			echo $curl_response;
			$character = json_decode($curl_response);
			echo '<br><br><br><br><br><br>';
			if ( ! empty($character->emailAddress)  ) {
				echo $character->emailAddress;
			}else{echo 'EROOR MY BROTHER no email address';}
			echo '<br><br>';
			if ( ! empty($character->displayName)  ) {
				echo $character->displayName;
			}else{echo 'EROOR MY BROTHER no email address';}

		}

		curl_close($ch);*/


	}




	public function Current($username,$password){
		echo $username.'<br>';
		echo $password.'<br>';
		$base64_usrpwd = base64_encode($username.':'.$password);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/user?username='.$username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);

		if ($ch_error) {

			echo "cURL Error: $ch_error";

		} else {

			echo $curl_response;
			$character = json_decode($curl_response);
			echo '<br><br><br><br><br><br>';
			if ( ! empty($character->emailAddress)  ) {
				echo $character->emailAddress;
			}else{echo 'EROOR MY BROTHER';}

		}

		curl_close($ch);








	}


	public function search($issue){


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
	//return get_from('search', 'SUPPORT-5643');

}

//call JIRA.
$result = search_issue($jql);

echo '<pre>';
var_dump( $result );
echo '</pre>';
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


}

}