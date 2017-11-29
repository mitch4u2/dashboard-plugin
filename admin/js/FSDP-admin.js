/* Ajax Functions Just for Testing Delete this when done */
/* -----------------------------------------------------*/
jQuery(document).ready( function ($)
{
	$(document).on('click','.load_ajax', function ()
	{
		var that = $(this);
		var page = that.data('page');
		var newPage = page+1;
		var ajaxurl = that.data('url');

		$.ajax({
			url : ajaxurl,
			type : 'post',
			data :
			{
				page : page,
				action : 'load_ajax'
			},
			error : function ( response )
			{
				console.log(response);
			},
			success : function ( response )
			{
				that.data('page', newPage);
				$('.jira-container').append(response);
			}

		});

	});
});

/* Ajax Functions for updating the role capabilities */
/* --------------------------------------------------*/

jQuery(document).ready( function ($)
{
	$(document).on('click','.update-caps', function ()
	{
		var granted = [];
		var ungranted = [];
		var item = '';
		$('#tags li').each(function(i)
		{
			item = $(this).text();
			if(item.length > 0)
			{
				granted.push(item);
			}
		});
		$('#ungrantedtags li').each(function(i)
		{
			item = $(this).text();
			if(item.length > 0)
			{
				ungranted.push(item);
			}
		});

		var that = $(this);
		var ajaxurl = that.data('url');
		var id = $( ".role" ).val();

		$.ajax({
			url : ajaxurl,
			type : 'post',
			data :
			{
				action : 'update_caps',
				id : id,
				granted : granted,
				ungranted : ungranted,
			},
			error : function ( response )
			{
				console.log(response);
			},
			success : function ( response )
			{
				//console.log(response);
			}
		});

	});
});





/* Ajax Functions for the delete role */
/* ----------------------------------*/
jQuery(document).ready( function ($)
{
	$(document).on('click','.delete-role', function ()
	{
		var id = $( ".role" ).val();
		var ajaxurl = $(this).data('url');

		console.log(id+'==>'+ajaxurl);

		$.ajax(
		{
			url : ajaxurl,
			type : 'post',
			data :
			{
				id : id,
				action : 'delete_role'
			},
			error : function ( response )
			{
				console.log(response);
			},
			success : function ( response )
			{
				location.reload(true);
			}
		});
	});
});










/* DELETE ROLE CONFIRMATION */
/* ------------------------*/
jQuery(document).ready( function ($)
{

$("button[type='delete']").click(function(){
    if (!confirm("Do you want to delete")){
      return false;
    }
  });
});





/* Ajax Functions fro modal View Ticket */
/* ------------------------------------*/
jQuery(document).ready( function ($)
{
	$(document).on('click','.load-issue', function ()
	{
		var that = $(this);
		var key = that.data('key');
		var ajaxurl = that.data('url');

		$.ajax(
		{
			url : ajaxurl,
			type : 'post',
			data :
			{
				key : key,
				action : 'load_issue'
			},
			error : function ( response )
			{
				console.log(response);
			},
			success : function ( response )
			{
				var arr = JSON.parse(response);
				var status = arr['fields']['status']['statusCategory']['name'];
				var comments = arr['fields']['comment']['comments'];
				var key = arr['key'];
				var summary = arr['fields']['summary'];
				var statusname = arr['fields']['status']['name'];
				var author ="Unassigned";
				if ( arr['fields']['assignee'] != null )
				{
					author = arr['fields']['assignee']['displayName'];
				}
				var created = "../../..";
				var done = "../../..";
				var open = "../../..";

				if (arr['fields']['created'])
				{
					created = arr['fields']['created'].substr(0, 16).replace("T"," ");
				}
				if (arr['fields']['resolutiondate'])
				{
					done = arr['fields']['resolutiondate'].substr(0, 16).replace("T"," ");
				}
				if (arr['fields']['updated'])
				{
					open = arr['fields']['updated'].substr(0, 16).replace("T"," ");
				}

				$('.issueKey').html(key);
				$('.modaltitle').html(summary);
				$('.statusname').html(statusname);
				$('.datetodo').html(created);
				$('.datedone').html(done);
				$('.dateinprogress').html(open);
				$('.author').html(author);
				$('#issuekeycomment').val(key);
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

				$( ".comment-container" ).html(" ");
				$.each(comments,function(key,value)
				{
					var avatar = value['author']['avatarUrls']['16x16'];
					var date = value['created'];
					var body = value['body'];

					$( ".comment-container" ).append("\
						<div class='comment-wrap'>\
						<div class='photo'>\
						<div class='avatar' style='background-image: url("+avatar+")'></div>\
						</div>\
						<div class='comment-block'>\
						<p class='comment-text'>"+body+"</p>\
						<div class='bottom-comment'>\
						<div class='comment-date'>Aug 24, 2014 @ 2:35 PM  ==> </div>\
						<div class='comment-date'>"+date+"</div>\
						<ul class='comment-actions'>\
						<li class='complain'>Complain</li>\
						<li class='reply'>Reply</li></ul></div></div></div>");
				});
			}
		});
	});
});

/* Ajax Functions Loading admin roles and Capabilities */
/* ----------------------------------------------------*/
var loaded = false;
var capsadmin = new Array();
var capsadminuni = new Array();
jQuery(document).ready( function ($)
{
	$( ".role" ).val('administrator');
	var ajaxurl = $( ".role" ).data('url');
	if(loaded) return;
	$.ajax(
	{
		url : ajaxurl,
		type : 'post',
		data :
		{
			action : 'load_admin_role'
		},
		error : function ( response )
		{
			console.log(response);
		},
		success : function ( response )
		{
			arradmin = JSON.parse(response);
			capsadmin = arradmin['capabilities'];
			$.each(capsadmin,function(key,value)
			{
				$('ul#tags').append('<li id="role_'+key+'"><a href="#">'+key+'<span></span></a></li>');
				capsadminuni.push(key);
			});
			loaded = true;
			$( function()
			{
				$( "#roles" ).autocomplete({
					source: capsadminuni,
					select: function( event, ui ) {
						$( "#role_"+ui.item.value+" a" ).css("color", "black");
						$( "#role_"+ui.item.value+" a" ).css("font-size", "18px");
						$( "#role_"+ui.item.value+" a" ).css("font-weight", "bolder");
					}
				});
			} );
			//$('ul#tags li a').removeAttr('style');
			$("#tags").sortable(
			{
				connectWith: "#ungrantedtags",
				update: function(event, ui)
				{
					var postdata = $(this).sortable('serialize');
				}
			});
			$("#ungrantedtags").sortable(
			{
				connectWith: "#tags",
				update: function(event, ui)
				{
					var postdata = $(this).sortable('serialize');
				}
			});
		}
	});

	$( ".role" ).change(function()
	{
		$('ul#ungrantedtags').html('');
		$('ul#grantedtags').html('');
		var capsuni = new Array();
		var allcaps = new Array();
		var that = $(this);
		var id = that.val();
		var ajaxurl = that.data('url');
		$('ul#tags').text(' ');
		$.ajax({
			url : ajaxurl,
			type : 'post',
			data :
			{
				id : id,
				action : 'load_role'
			},
			error : function ( response )
			{
				console.log(response);
			},
			success : function ( response )
			{
				var arr = JSON.parse(response);
				var caps = arr['capabilities'];
				$.each(caps,function(key,value)
				{
					if (key!='null')
					{
						$('ul#tags').append('<li id="role_'+key+'"><a href="#">'+key+'<span></span></a></li>');
						capsuni.push(key);
					}
				});

				for (var i=capsadminuni.length; i--;)
				{
					if (capsuni.indexOf(capsadminuni[i]) === -1)
					{
						allcaps.push(capsadminuni[i]);
						$('ul#ungrantedtags').append('<li id="role_'+capsadminuni[i]+'"><a href="#">'+capsadminuni[i]+'<span></span></a></li>');
					}
				}

				$("#tags").sortable(
				{
					connectWith: "#ungrantedtags",
					update: function(event, ui)
					{
						var postdata = $(this).sortable('serialize');
					}
				});

				$("#ungrantedtags").sortable({
					connectWith: "#tags",
					update: function(event, ui){
						var postdata = $(this).sortable('serialize');
					}
				});
			}
		});
	});
});

/* JS CODE TO OPEN THE MODALS */
/* ---------------------------*/

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

// When the user clicks the button, open the modal
jQuery(".update").click(function()
{
	modal.style.display = "block";
});
jQuery(".view").click(function()
{
	modal2.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
jQuery(".close").click(function()
{
	modal.style.display = "none";
});
jQuery(".close2").click(function()
{
	modal2.style.display = "none";
});
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event)
{
	if ((event.target == modal) || (event.target == modal2)) {
		modal.style.display = "none";
		modal2.style.display = "none";
	}
}