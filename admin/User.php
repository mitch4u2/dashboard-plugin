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
	//private $username;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	//private $password;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	/*public function __construct( $username, $password ) {

		$this->username = $username;
		$this->password = $password;

	}*/


	public static function login($username,$password){
		/*echo $username.'<br>';
		echo $password;*/
		//$base64_usrpwd = base64_encode('harm:hu1z3putm4n');

		$base64_usrpwd = base64_encode($username.':'.$password);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/myself');

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ( $httpcode === 200 ) {
			wp_redirect( "admin.php?page=jira_tickets", $status = 302 );
			echo "cURL Error: $ch_error";

		} else {

			wp_redirect( "admin.php?page=jira_settings" .'&code='.$httpcode );
			 //wp_redirect( esc_url( add_query_arg( 'error', $httpcode, "admin.php?page=jira_settings" ) ) );
    		//exit;
			//wp_redirect( "admin.php?page=jira_settings?error=$httpcode", $status = 302 );
			/*echo $curl_response;
			$character = json_decode($curl_response);
			echo '<br><br><br><br><br><br>';
			if ( ! empty($character->emailAddress)  ) {
				echo $character->emailAddress;
			}else{echo 'EROOR MY BROTHER no email address';}
			echo '<br><br>';
			if ( ! empty($character->displayName)  ) {
				echo $character->displayName;
			}else{echo 'EROOR MY BROTHER no email address';}*/

		}

		curl_close($ch);

	}


	public function Search(){

		//$base64_usrpwd = base64_encode('mohamed:qrt235234@#$%!');
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://jira.foursites.nl/rest/api/2/search?jql=reporter=currentuser()&fields=summary,comment,description,resolutiondate,customfield_10100,updated,created,issuetype,status,priority,assignee,resolution');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//magical line
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('cookie:'.$cookiestr));

		/*curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));*/
		$curl_response = curl_exec($ch);
		var_dump($curl_response);
		$ch_error = curl_error($ch);
		var_dump($ch_error);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($ch_error) {
			$character= false ;
		} else {
			$character = json_decode($curl_response);
		}
		curl_close($ch);
		return $character;
	}

	public static function getIssue($issueKey){

		//$base64_usrpwd = base64_encode('wiljon:weEw4BTpsh6h');
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://jira.foursites.nl/rest/api/2/issue/'.$issueKey.'?fields=summary,comment,description,resolutiondate,customfield_10100,updated,created,issuetype,status,priority,assignee,resolution');

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('cookie:'.$cookiestr));

		/*curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));*/
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($ch_error) {
			$character= false ;
		} else {
			$character = $curl_response;
		}
		curl_close($ch);
		//$character = ' i get it fron the user class';
		return $character;
	}

	public static function create($summary,$description,$type,$priority,$page){

		//echo $summary.$description.$type.$priority.$page;
		//$base64_usrpwd = base64_encode('wiljon:weEw4BTpsh6h');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/issue/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','cookie:'.$cookiestr));
		$arr['project'] = array( 'key' => 'SUPPORT');
		$arr['issuetype'] = array( 'name' => $type);
		$arr['summary'] = $summary;
		$link = get_permalink($page);
		$arr['description'] = $link ." ". $description;
		$arr['issuetype'] = array( 'name' => $type);
		$arr['priority'] = array( 'name' => $priority);
		$json_arr['fields'] = $arr;
		$json_string = json_encode ($json_arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		curl_close($ch);
		//echo $result;

		$sess_arr = json_decode($result, true);
		if(isset($sess_arr['errorMessages'][0])) {
			wp_redirect( "admin.php?page=create_issue" .'&code='.$sess_arr['errorMessages'][0] );
		}
		else {
			wp_redirect( "admin.php?page=create_issue", $status = 302 );
		}

	}


	public static function Comment($issueKey,$comment){

		//echo $summary.$description.$type.$priority.$page;
		//$base64_usrpwd = base64_encode('willjon:weEw4BTpsh6h');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/issue/'.$issueKey.'/comment');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','cookie:'.$cookiestr));
		$json_arr['body'] = $comment;
		$json_string = json_encode ($json_arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		curl_close($ch);
		echo $result;

		/*$sess_arr = json_decode($result, true);
		if(isset($sess_arr['errorMessages'][0])) {
			wp_redirect( "admin.php?page=create_issue" .'&code='.$sess_arr['errorMessages'][0] );
		}
		else {
			wp_redirect( "admin.php?page=create_issue", $status = 302 );
		}*/

	}


	public static function update($issue,$summary,$description,$type,$priority){

		//echo $summary.$description.$type.$priority.$page;
		//$base64_usrpwd = base64_encode('wiljon:weEw4BTpsh6h');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/issue/'.$issue);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','cookie:'.$cookiestr));

		$arr['project'] = array( 'key' => 'SUPPORT');
		$arr['issuetype'] = array( 'name' => $type);
		$arr['summary'] = $summary;
		$arr['description'] = $description;
		$arr['issuetype'] = array( 'name' => $type);
		$arr['priority'] = array( 'name' => $priority);
		$json_arr['fields'] = $arr;
		$json_string = json_encode ($json_arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		curl_close($ch);
		//echo $result;

		$sess_arr = json_decode($result, true);
		if(isset($sess_arr['errorMessages'][0])) {
			wp_redirect( "admin.php?page=create_issue" .'&code='.$sess_arr['errorMessages'][0] );
		}
		else {
			wp_redirect( "admin.php?page=create_issue", $status = 302 );
		}

	}



	public function userProfile(){
		$ch = curl_init('http://jira.foursites.nl/rest/api/2/user?username=mohamed');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('cookie:'.$cookiestr));

		$result = curl_exec($ch);
		curl_close($ch);
		$sess_arr = json_decode($result, true);

		if(isset($sess_arr['errorMessages'][0])) {
			echo $sess_arr['errorMessages'][0];
		}
		else {
			echo $sess_arr['displayName'];
			echo "\n";
			echo $sess_arr['emailAddress'];
		}

	}

	public static function userInfo($username){
		$ch = curl_init('http://jira.foursites.nl/rest/api/2/user?username='.$username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		if(isset($_COOKIE['JSESSIONID']))
			$cookiestr='JSESSIONID='.$_COOKIE['JSESSIONID'];
		else
			$cookiestr="";

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','cookie:'.$cookiestr));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);
		$sess_arr = json_decode($curl_response , true);

		if ($ch_error)
		{
			$avatar =  "cURL Error: $ch_error";

		}
		else
		{
			$avatarid =substr(isset($sess_arr['avatarUrls']['48x48']), -5);
			if ((!empty($sess_arr['avatarUrls']['48x48'])) && ($avatarid !='11405'))
			{
				$avatar = $sess_arr['avatarUrls']['48x48'];
			}
			elseif ((!empty($sess_arr['avatarUrls']['32x32'])) && ($avatarid !='11405'))
			{
				$avatar = $sess_arr['avatarUrls']['32x32'];
			}
			elseif ((!empty($sess_arr['avatarUrls']['24x24'])) && ($avatarid !='11405'))
			{
				$avatar = $sess_arr['avatarUrls']['24x24'];
			}
			elseif ((!empty($sess_arr['avatarUrls']['16x16'])) && ($avatarid !='11405'))
			{
				$avatar = $sess_arr['avatarUrls']['16x16'];
			}
			else
			{
				$avatar = 'https://cdn1.iconfinder.com/data/icons/ninja-things-1/1772/ninja-simple-48.png';
			}
		}
		return $avatar;
		curl_close($ch);

	}



	public static function loginSession($username,$password){
		/*echo $username.'<br>';
		echo $password;*/
		//$base64_usrpwd = base64_encode('harm:hu1z3putm4n');

		$ch = curl_init('https://jira.foursites.nl/rest/auth/1/session');
		$jsonData = array(
			'username' => $username,
			'password' => $password );
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//magical line
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$result = curl_exec($ch);
		curl_close($ch);

		$sess_arr = json_decode($result, true);
		

		if(isset($sess_arr['errorMessages'][0])) {
			wp_redirect( "admin.php?page=jira_settings" .'&code='.$sess_arr['errorMessages'][0] );		
		}
		else {
			setcookie($sess_arr['session']['name'], $sess_arr['session']['value'], time() + (86400 * 30 * 100), "/");
			$user_id=get_current_user_id();
			if ( (bool) $user_id) {
				$havemetauser = get_user_meta($user_id, '_jira_user', false);
				$havemetapass = get_user_meta($user_id, '_jira_password', false);
				if ((!$havemetauser) && (!$havemetapass)) {
					add_user_meta( $user_id, '_jira_user', $username);
					add_user_meta( $user_id, '_jira_password', $password);
					
				}
				else {
					update_user_meta( $user_id, '_jira_user', $username);
					update_user_meta( $user_id, '_jira_password', $password);
				}
			}
			wp_redirect( "admin.php?page=jira_tickets", $status = 302 );
		}
		curl_close($ch);
	}

	public static function loginSession1($username,$password){
		/*echo $username.'<br>';
		echo $password;*/
		//$base64_usrpwd = base64_encode('harm:hu1z3putm4n');

		$ch = curl_init('https://jira.foursites.nl/jira/rest/auth/1/session');
		$jsonData = array(
			'username' => $username,
			'password' => $password );
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$result = curl_exec($ch);
		var_dump($username);
		var_dump($password);
		echo $ch; 
		curl_close($ch);

		$sess_arr = json_decode($result, true);
		

		/*if(isset($sess_arr['errorMessages'][0])) {
			wp_redirect( "admin.php?page=jira_settings" .'&code='.$sess_arr['errorMessages'][0] );		
		}
		else {
			setcookie($sess_arr['session']['name'], $sess_arr['session']['value'], time() + (86400 * 30 * 100), "/");
			$user_id=get_current_user_id();
			if ( (bool) $user_id) {
				$havemetauser = get_user_meta($user_id, '_jira_user', false);
				$havemetapass = get_user_meta($user_id, '_jira_password', false);
				if ((!$havemetauser) && (!$havemetapass)) {
					add_user_meta( $user_id, '_jira_user', $username);
					add_user_meta( $user_id, '_jira_password', $password);
					
				}
			}
			wp_redirect( "admin.php?page=jira_tickets", $status = 302 );
		}
		curl_close($ch);*/
	}

	public function signin($username,$password,$name,$email){

		$base64_usrpwd = base64_encode('willjon:weEw4BTpsh6h');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/user');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'Authorization: Basic '.$base64_usrpwd));
		$arr['name'] = $username;
		$arr['emailAddress'] = $email;
		$arr['displayName'] = $name;
		$arr['notification'] = true;
		$json_string = json_encode ($arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		wp_redirect( "admin.php?page=jira_settings" .'&info='.$httpcode );



/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/password/policy/updateUser');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'X-ExperimentalApi: opt-in',
			'Authorization: Basic '.$base64_usrpwd));
		$arr['username'] = 'wrabbit@live.fr';
		$arr['oldPassword'] = '';
		$arr['newPassword'] = 'Switchmitch21%';
		$json_string = json_encode ($arr);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_string);
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		echo '<pre>';
		var_dump( $httpcode );
		echo '</pre>';
		curl_close($ch);
		echo $result;*/
	/*

			{
	    "username": "fred",
	    "oldPassword": "secret",
	    "newPassword": "correcthorsebatterystaple"
	}*/

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
		curl_setopt($ch, CURLOPT_URL, 'http://jira.foursites.nl/rest/api/2/search?jql=assignee=harm');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$base64_usrpwd));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);

		if ($ch_error) {

			echo "cURL Error: $ch_error";

		} else {

			echo $curl_response;
			/*$character = json_decode($curl_response);
			echo '<br><br><br><br><br><br>';
			if ( ! empty($character->emailAddress)  ) {
				echo $character->emailAddress;
			}else{echo 'EROOR MY BROTHER';}*/

		}

		curl_close($ch);



	}

	public function PageSpeed($strategy){

		$ApiKey = 'AIzaSyAX1AOJ_EYCPyTMgob4r-m_qSDjfB75g1I';
		$url = 'http://www.foursites.nl';
		$ch = curl_init();
		//change the website url from static to synamic
		curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=http://www.foursites.nl/&key=AIzaSyAX1AOJ_EYCPyTMgob4r-m_qSDjfB75g1I&strategy='.$strategy);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$curl_response = curl_exec($ch);
		$ch_error = curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpcode != 200) {

			echo "cURL Error: $ch_error";

		} else {
			$character = json_decode($curl_response);
			if ( ! empty($character->ruleGroups)  ) {
				$speed= isset($character->ruleGroups->SPEED->score) && ! empty( $character->ruleGroups->SPEED->score ) ?$character->ruleGroups->SPEED->score : '' ;
				$usability= isset($character->ruleGroups->USABILITY->score) && ! empty( $character->ruleGroups->USABILITY->score ) ?$character->ruleGroups->USABILITY->score : '' ;
				return array($speed,$usability);
				/*$character->ruleGroups->SPEED->score
				$character->ruleGroups->USABILITY->score*/
			}else{echo 'EROOR MY BROTHER';}
		}
		curl_close($ch);
	}
}