/* Ajax Functions */
jQuery(document).ready( function ($) {
	$(document).on('click','.load_ajax', function () {

		var that = $(this);
		var page = that.data('page');
		var newPage = page+1;
		var ajaxurl = that.data('url');

		$.ajax({

			url : ajaxurl,
			type : 'post',
			data : {

				page : page,
				action : 'load_ajax'

			},
			error : function ( response ) {
				console.log(response);
			},
			success : function ( response ) {
				that.data('page', newPage);
				$('.jira-container').append(response);
			}

		});

	});
});


/* Ajax Functions fro modal View Ticket */
jQuery(document).ready( function ($) {
	$(document).on('click','.load-issue', function () {

		var that = $(this);
		var key = that.data('key');
		var ajaxurl = that.data('url');

		$.ajax({

			url : ajaxurl,
			type : 'post',
			data : {

				key : key,
				action : 'load_issue'

			},
			error : function ( response ) {
				console.log(response);
			},
			success : function ( response ) {

				var arr = JSON.parse(response);
				var status = arr['fields']['status']['statusCategory']['name'];
				var comments = arr['fields']['comment']['comments'];
				var key = arr['key'];
				var summary = arr['fields']['summary'];
				var statusname = arr['fields']['status']['name'];
				var author ="Unassigned";


				//console.log((arr['fields']['assignee']).length);
				if ( arr['fields']['assignee'] != null ){
					author = arr['fields']['assignee']['displayName'];
				}
				var created = "../../..";
				var done = "../../..";
				var open = "../../..";

				if (arr['fields']['created']) {
					created = arr['fields']['created'].substr(0, 16).replace("T"," ");
				}
				if (arr['fields']['resolutiondate']) {
					done = arr['fields']['resolutiondate'].substr(0, 16).replace("T"," ");
				}
				if (arr['fields']['updated']) {
					open = arr['fields']['updated'].substr(0, 16).replace("T"," ");
				}

				$('.issueKey').html(key);
				$('.modaltitle').html(summary);
				$('.statusname').html(statusname);
				$('.datetodo').html(created);
				$('.datedone').html(done);
				$('.dateinprogress').html(open);
				$('.author').html(author);


				$( "#inprogress" ).removeClass( "complete" );
				$( "#done" ).removeClass( "complete" );

				if (status === 'In Progress')
				{
					$( "#inprogress" ).addClass( "complete" );
				}
				if (status === 'Done')
				{
					$( "#inprogress" ).addClass( "complete" );
					$( "#done" ).addClass( "complete" );
				}

				$.each(comments,function(key,value){
					console.log(value['author']['avatarUrls']['32x32']);
					var avatar = value['author']['avatarUrls']['16x16'];

					//$.('.comment-container').html('');

								/*$( ".comment-container" ).html(function() {
									var emphasis = "<div class='comment-wrap'><div class='photo'><div class='avatar' style='background-image: url("+avatar+")'></div></div><div class='comment-block'><p class='comment-text'>Mohamed Hajjej</p><div class='bottom-comment'><div class='comment-date'>Aug 24, 2014 @ 2:35 PM</div><ul class='comment-actions'><li class='complain'>Complain</li><li class='reply'>Reply</li></ul></div></div></div>";
									return emphasis;
								});*/


								$( ".comment-container" ).html(function() {
									$( ".comment-container" ).html("<div class='comment-wrap'><div class='photo'><div class='avatar' style='background-image: url("+avatar+")'></div></div><div class='comment-block'><p class='comment-text'>Mohamed Hajjej</p><div class='bottom-comment'><div class='comment-date'>Aug 24, 2014 @ 2:35 PM</div><ul class='comment-actions'><li class='complain'>Complain</li><li class='reply'>Reply</li></ul></div></div></div>");
								});



							});


			}

		});


	});
});



var script = document.createElement("script");
script.type = "text/javascript";
script.src = "https://www.gstatic.com/charts/loader.js";
document.getElementsByTagName("head")[0].appendChild(script);



// Get the modal
var modal = document.getElementsByClassName("modalUpdate")[0];
var modal2 = document.getElementsByClassName("modalView")[0];

// Get the button that opens the modal
var btn = document.getElementsByClassName("update")[0];
var btn2 = document.getElementsByClassName("view")[0];
// console.log(btn);

;

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close2")[0];

// When the user clicks the button, open the modal
jQuery(".update").click(function() {
	modal.style.display = "block";
});
jQuery(".view").click(function() {
	modal2.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
	modal.style.display = "none";
}
span2.onclick = function() {
	modal2.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if ((event.target == modal) || (event.target == modal2)) {
		modal.style.display = "none";
		modal2.style.display = "none";
	}
}


