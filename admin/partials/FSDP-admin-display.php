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


<h2>Modal Example</h2>


<!-- Trigger/Open The Modal -->


<!-- The Modal -->



<button class="button button-primary load_ajax" data-page='1' data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">Load Ajay</button>

<br><br>
<div class="jira-container"></div>
<br><br>

<div class="speedtest">
	<!-- Top Navigation -->
	<section>
		<div class="tabs tabs-style-topline">
			<nav>
				<ul>
					<li><a href="#section-topline-1" class="icon icon-home"><span>Desktop</span></a></li>
					<li><a href="#section-topline-2" class="icon icon-gift"><span>Mobile</span></a></li>
				</ul>
			</nav>
			<div class="content-wrap">
				<section id="section-topline-1">
					<p>if the website score reach the Yellow area an automatic Issue Type Bug will be generated an autoassigned to  one of foursites beautiful developer to work on it</p>
					<div id="chart_div" style="width: 400px; height: 180px;"></div>
				</section>
				<section id="section-topline-2">
					<p>if the website score reach the Red area an automatic Issue Type Urgent will be generated an autoassigned to one of foursites beautiful developer to work on it </p>
					<div id="chart_div1" style="width: 400px; height: 180px;"></div>
				</section>
			</div><!-- /content -->
		</div><!-- /tabs -->
	</section>
</div><!-- /container -->

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- <div class="wrap">
	JIRA TICKET
</div> -->
<!-- <button id="posts-btn">LOAD POSTS</button> -->
<div id="chart_div" style="width: 400px; height: 180px;"></div>
<?php $user = new User('','');
/*$arr=$user->PageSpeed('desktop');
$arr1=$user->PageSpeed('mobile');
*/
$arr2=$user->Search();
//$user->userProfile();
//echo 'Speed:'.$arr[0].' Usability:'.$arr1[1];
//echo 'Speed:'.$arr1[0].' Usability:'.$arr1[1]; ?>
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
	/*(function( $ ) {
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
					width: 400, height: 180,
					redFrom: 0, redTo: 20,
					yellowFrom: 20, yellowTo: 50,
					greenFrom:80, greenTo: 100,
					minorTicks: 10
				};
				var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		});*/

		/*Script to Run the gauge chart by retrieving data from PageSpeed('mobile') php function */

		/*$( window ).load(function() {
			google.charts.load('current', {'packages':['gauge']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data1 = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['Usability',<?php echo $arr1[0]; ?> ],
					['Speed', <?php echo $arr1[1]; ?>]
					]);
				var options1 = {
					width: 400, height: 180,
					redFrom: 0, redTo: 20,
					yellowFrom: 20, yellowTo: 50,
					greenFrom:80, greenTo: 100,
					minorTicks: 10
				};
				var chart = new google.visualization.Gauge(document.getElementById('chart_div1'));
				chart.draw(data1, options1);
			}
		});*/

		/*Script to Run the gauge chart by retrieving data from PageSpeed('mobile') php function */

		/*$( window ).load(function() {
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
	})( jQuery );*/
</script>

<!-- Script to Run the folder tab design for the pagespeed -->
<script>
	( function( window ) {
		'use strict';
		function extend( a, b ) {
			for( var key in b ) {
				if( b.hasOwnProperty( key ) ) {
					a[key] = b[key];
				}
			}
			return a;
		}
		function CBPFWTabs( el, options ) {
			this.el = el;
			this.options = extend( {}, this.options );
			extend( this.options, options );
			this._init();
		}
		CBPFWTabs.prototype.options = {
			start : 0
		};
		CBPFWTabs.prototype._init = function() {
		// tabs elems
		this.tabs = [].slice.call( this.el.querySelectorAll( 'nav > ul > li' ) );
		// content items
		this.items = [].slice.call( this.el.querySelectorAll( '.content-wrap > section' ) );
		// current index
		this.current = -1;
		// show current content item
		this._show();
		// init events
		this._initEvents();
	};
	CBPFWTabs.prototype._initEvents = function() {
		var self = this;
		this.tabs.forEach( function( tab, idx ) {
			tab.addEventListener( 'click', function( ev ) {
				ev.preventDefault();
				self._show( idx );
			} );
		} );
	};
	CBPFWTabs.prototype._show = function( idx ) {
		if( this.current >= 0 ) {
			this.tabs[ this.current ].className = this.items[ this.current ].className = '';
		}
		// change current
		this.current = idx != undefined ? idx : this.options.start >= 0 && this.options.start < this.items.length ? this.options.start : 0;
		this.tabs[ this.current ].className = 'tab-current';
		this.items[ this.current ].className = 'content-current';
	};
	// add to global namespace
	window.CBPFWTabs = CBPFWTabs;

})( window );

(function() {

	[].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
		new CBPFWTabs( el );
	});

})();
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
