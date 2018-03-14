<?php
namespace admin;
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    foursites-dashboard-plugin
 * @subpackage foursites-dashboard-plugin/admin/partials
 */
?>

<?php $user = new User('','');
$arr=$user->PageSpeed('desktop');
$arr1=$user->PageSpeed('mobile');

//$arr2=$user->Search();
//$user->userProfile();
/*echo 'Speed:'.$arr[0].' Usability:'.$arr1[1];
echo 'Speed:'.$arr1[0].' Usability:'.$arr1[1];*/ ?>




<div class="fsdp-header">
	<div class="fsdp-logo"></div>
	<br>
</div>

<h2>Modal Example</h2>


<!-- Trigger/Open The Modal -->


<!-- The Modal -->


<div class="rowstat">
	<ul>
					<li>
						<div class="rad-info-box rad-txt-success">
							<i class="dashicons dashicons-share"></i>
							<span class="heading">Microsoft</span>
							<span class="value"><span>4949</span></span>
						</div>
					</li>
					<li>
						<div class="rad-info-box rad-txt-primary">
							<i class="dashicons dashicons-hammer"></i>
							<span class="heading">Facebook</span>
							<span class="value"><span>23K</span></span>
						</div>
					</li>
					<li>
						<div class="rad-info-box rad-txt-danger">
							<i class="dashicons dashicons-flag"></i>
							<span class="heading">Google</span>
							<span class="value"><span>49M</span></span>
						</div>
					</li>
					<li>
						<div class="rad-info-box">
							<i class="dashicons dashicons-admin-tools"></i>
							<span class="heading">Apple</span>
							<span class="value"><span>10.9K</span></span>
						</div>
					</li>
					</ul>
</div>


<div class="rowsgauge">
	<ul>
		<li>
			<div class="rad-info-box">

					<div class="panel-heading">
						<ul>
							<li><i class="dashicons dashicons-desktop"></i></li>
							<li><h3 class="panel-title"> Desktop speed index</h3></li>
						</ul>
					</div><br>
					<hr>

				<div id="chart_div"></div>
				<hr>

					
				<span class="value" style="font-size: 16px;"><span style="background-color: green;color: white;">&nbsp;<?php echo $arr[0]; ?> / 100&nbsp;</span> Speed</span>
			</div>
		</li>
		<li>
			<div class="rad-info-card">
			<div class="panel-heading">
						<ul>
							<li><i class="dashicons dashicons-info"></i></li>
							<li><h3 class="panel-title"> info</h3></li>
						</ul>
					</div><br>
					<hr>
				<span class="card-info">
						the gauges are powered by google page speed index it indicates your websites speed and usability both for  desktop and mobile.
						in order to maintain a quality of work the developer team of Foursites will get an autaumatic warning in their system if the gauge reachs the yellow area
				</span>
			</div>
		</li>
		<li>
			<div class="rad-info-box">
				<div class="panel-heading">
						<ul>
							<li><i class="dashicons dashicons-smartphone"></i></li>
							<li><h3 class="panel-title"> mobile speed index</h3></li>
						</ul>
					</div><br>
					<hr>
				<div id="chart_div1"></div>
				<hr>
				<span class="value" style="font-size: 16px;"><span style="background-color: green;color: white;">&nbsp;<?php echo $arr1[0]; ?> / 100&nbsp;</span> Speed</span>
			</div>
		</li>
	</ul>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



<!-- <button class="button button-primary load_ajax" data-page='1' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">Load Ajay</button> -->

<br><br>
<div class="jira-container"></div>
<br><br>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- <div class="wrap">
	JIRA TICKET
</div> -->
<!-- <button id="posts-btn">LOAD POSTS</button> -->
<div id="chart_div" style="width: 400px; height: 180px;"></div>
<div id="posts-container"></div>
<div id="donutchart" style="width: 650px; height: 450px;"></div>
<div class="jira-list">
	<?php
	$user->Search(); ?>
</div>
<div class="jira-list">
	<?php
	if ( ! empty($arr2->issues)  ) {
		echo "<table id='mytable'>
		<tr>
		<th>Comments ids</th>
		<th>Comments total</th>
		<th>Issue Key</th>
		<th>Issue Summary</th>
		<th>Issue Description</th>
		<th>Resolution date</th>

		<th>Start Time</th>
		<th>Updated</th>
		<th>goal duration</th>
		<th>date</th>
		<th>Issue Type</th>
		<th>Issue Status</th>
		<th>Issue Priority</th>
		<th>assignee</th>
		<th>resolution</th>
		<th>update</th>
		<th>avatar</th>
		<th>open</th>
		</tr>";
		$issuetotal=0;
		$issueTotal=0;
		$issueStory=0;
		$issueBug=0;
		$issueImprovement=0;
		$issueNewFeature=0;
		$issueTask=0;
		$issueSubTasks=0;

		foreach ($arr2->issues as &$issue) {
			$issuetotal++;
			switch ($issue->fields->issuetype->name) {
				case "Story": $issueStory++;break;
				case "Bug": $issueBug++;break;
				default : $issueTask++;
			}
			$comments = $issue->fields->comment;

			echo "<tr><td>";
			foreach ($comments->comments as &$comment) {
				echo $comment->author->key.'<br>'.$comment->body.'<img style ="width:50px;size:50px;" src='.User::userInfo((isset($comment->author->key) ? $comment->author->key : "Unassigned")).'>';
			}
			echo"
			</td><td id='comment'>".$comments->total."</td>
			<td><b>".$issue->key."</b></td>
			<td id='summary'>".$issue->fields->summary."</td>

			<td class='description'>".$issue->fields->description."</td>
			<td id='resolution'>".substr($issue->fields->resolutiondate,0,10)."</td>
			<td class='starttime'>".(isset($issue->fields->customfield_10100->ongoingCycle->startTime->friendly)?$issue->fields->customfield_10100->ongoingCycle->startTime->friendly : 'empty')."</td>
			<td class='updated'>".((isset($issue->fields->updated)) ? substr($issue->fields->updated,0,10) : 'empty')."</td>
			<td class='goal'>".(isset($issue->fields->customfield_10100->ongoingCycle->goalDuration->friendly) ? $issue->fields->customfield_10100->ongoingCycle->goalDuration->friendly : 'Empty')."</td>
			<td id='created'>".substr($issue->fields->created, 0,10)."</td>
			<td class='type'>
			<b>".$issue->fields->issuetype->name."</b>
			<div class='tooltip'>
			<img src=".$issue->fields->issuetype->iconUrl.">
			<span class='tooltiptext'>".$issue->fields->issuetype->description."</span>
			</div>
			</td>
			<td>
			<b id='statusname'>".$issue->fields->status->name."</b>
			<div class='tooltip'>
			<b style='color:".$issue->fields->status->statusCategory->colorName."';''><span id='status'>".$issue->fields->status->statusCategory->name."</span></b>
			<img src=".$issue->fields->status->iconUrl.">
			<span class='tooltiptext'>".$issue->fields->status->description."</span>
			</div>
			</td>
			<td class='priority'><b>".$issue->fields->priority->name."</b>
			<img src=".$issue->fields->priority->iconUrl."> </td>
			<td><b id='assignee'>".(isset($issue->fields->assignee->name) ? $issue->fields->assignee->name : 'Unassigned')."</b>
			</td>
			<td class='resolution'>
			<div class='tooltip'>
			<b>".(isset($issue->fields->resolution->name) ? $issue->fields->resolution->name : 'Empty')."</b>
			<span class='tooltiptext'>".(isset($issue->fields->resolution->description) ? $issue->fields->resolution->description : 'Empty')."</span>
			</div>
			</td>
			<td><button value='' class='update'>Update</button></td>
			<td><img src=".User::userInfo((isset($issue->fields->assignee->name) ? $issue->fields->assignee->name : 'Unassigned'))."></td>
			<td><button value='".$issue->key."' class='view'>View</button></td>
			<td><button class='view button button-primary load-issue' data-key='".$issue->key."' data-url=".admin_url( 'admin-ajax.php' )." >View</button></td>


			</tr>";
		}
		echo "</table>";
		echo "<h1> Total Number of Issues : ".$issuetotal."</h1> <br>";
		echo "<h1> Total Number of Stories : ".$issueStory."</h1> <br>";
		echo "<h1> Total Number of Bugs : ".$issueBug."</h1> <br>";
		echo "<h1> Total Number of Other : ".$issueTask."</h1> <br>";

	}else{echo 'EROOR MY BROTHER';}

	?>
</div>
<!-- Script to fill in the update form and to open the model -->
<script>

	(function( $ ) {
		$(document).ready(function(){
			$(".update").click(function(){
				var $row = $(this).closest("tr");    // Find the row
				var $summary = $row.find(".summary").text();
				var $description = $row.find(".description").text();
				var $type = $row.find(".type").text();
				var $priority = $row.find(".priority").text();

				$("textarea.sum").val($summary);
				$("textarea.description").val($description);
				$("textarea.type").val($type);
				$("#type").val($type);
				$("#priority").val($priority);
				$("textarea.description").keyup(function(e) {
					while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
						$(this).height($(this).height()+1);
					};
				});
				var btn = $(this);
				var modal= $("#issueKey");
				$("#issueKey").val(btn.val());
				modal.html(btn.val());
			});
		});

	})( jQuery );

</script>
<!-- Script to fill in the update form and to open the model -->
<script>
	(function( $ ) {
		$( window ).load(function() {
			google.charts.load('current', {'packages':['gauge']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['Usability',<?php echo $arr1[1]; ?> ],
					['Speed', <?php echo $arr[0]; ?>]
					]);
				var options = {
					width: 300, height: 200,
					redFrom: 0, redTo: 20,
					yellowFrom: 20, yellowTo: 50,
					greenFrom:80, greenTo: 100,
					minorTicks: 10
				};
				var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		});

		/*Script to Run the gauge chart by retrieving data from PageSpeed('mobile') php function */

		$( window ).load(function() {
			google.charts.load('current', {'packages':['gauge']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data1 = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['Usability',<?php echo $arr1[1]; ?> ],
					['Speed', <?php echo $arr1[0]; ?>]
					]);
				var options1 = {
					width: 300, height: 200,
					redFrom: 0, redTo: 20,
					yellowFrom: 20, yellowTo: 50,
					greenFrom:80, greenTo: 100,
					minorTicks: 10
				};
				var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));
				chart.draw(data1, options1);
			}
		});

		/*Script to Run the pie chart by retrieving data from JIRA API  function */

		$( window ).load(function() {
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Issue Type', 'Number'],
					['Story',    <?php echo $issueStory ?>],
					['Bug',      <?php echo $issueBug ?>],
					['New Feature',  2],
					['Watch TV', 2],
					['Sleep',    7]
					]);
				var options = {
					title: 'Issue by Type',
					pieHole: 0.4,
				};
				var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
				chart.draw(data, options);
			}

		});
	})( jQuery );
</script>

	
<!-- modal for the update -->
<div id="myModal" class="modalUpdate" >
	<!-- Modal content -->
	<div class="modal-content">
		<span class="close">&times;</span>
		<p>Some text in the Modal..</p>
		<h1 class='modaltitle'>Update Ticket</h1>
		<?php settings_errors(); ?>
		<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<?php settings_fields( 'jira_issue_update' ) ?>
			<?php do_settings_sections( 'jira_settings_update' ); ?>
			<?php submit_button( 'Update', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
		</form>
	</div>
</div>
<!-- modal for the view -->
<div id="myModal" class="modalView" >
	<!-- Modal content -->
	<div class="modal-content">
		<span class="close2">&times;</span>
		<p class="issueKey"></p>
		<h1 class='modaltitle'></h1>

		<span class='statusname' style='background-color: #4a6785;color:white;padding: 3px;border-radius: 5px;'>(opslaan)</span>

		<ul class="timeline" id="timeline">
			<li id="todo" class="li complete">
				<div class="timestamp">
					<span class="author">Foursites</span>
					<span class="datetodo">../../..<span>
					</div>
					<div class="status">
						<h4 style='background-color: #4a6785;color:white;padding: 3px;border-radius: 5px;'> TO DO </h4>
					</div>
				</li>
				<li id="inprogress" class="li">
					<div class="timestamp">
						<span class="author">Foursites</span>
						<span class="dateinprogress">../../..<span>
						</div>
						<div class="status">
							<h4 style='background-color: #EE7600;color:white;padding: 3px;border-radius: 5px;'> IN PROGRESS </h4>
						</div>
					</li>
					<li id="done" class="li">
						<div class="timestamp">
							<span class="author">Foursites</span>
							<span class="datedone">../../..<span>
							</div>
							<div class="status">
								<h4 style='background-color: #14892c;color:white;padding: 3px;border-radius: 5px;'> DONE </h4>
							</div>
						</li>
					</ul>

					<!-- COMMENT SECTION -->
					<div class="comments">
						<div class="comment-wrap">
							<div class="photo">
								<div class="avatar" style="background-image: url('https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg')"></div>
							</div>
							<!-- <div class="comment-block">
								<form action="">
									<textarea name="" id="" cols="30" rows="3" placeholder="Add comment..."></textarea>
								</form>
							</div> -->
							<div class="comment-block">
								<?php settings_errors(); ?>
								<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
									<?php settings_fields( 'jira_issue_comment' ); ?>
									<?php do_settings_sections( 'jira_settings_comment' ); ?>
									<?php submit_button( 'Comment', $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
								</form>
							</div>
						</div>
						<div class="comment-container">
						</div>
					</div>
				</div>
				<!--END COMMENT SECTION -->
			</div>
		</div>
