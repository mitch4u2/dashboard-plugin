/* Switch tabs for Admin Settings */
/* -----------------------------------------------------*/
window.addEventListener("load", function()
{
	var tabs = document.querySelectorAll("ul.nav-tabs > li");
	for (i = 0; i < tabs.length; i++)
	{
		tabs[i].addEventListener("click", switchTab);
	}
	function switchTab(event)
	{
		event.preventDefault();
		document.querySelector("ul.nav-tabs li.active").classList.remove("active");
		document.querySelector(".tab-pane.active").classList.remove("active");
		var clickedTab = event.currentTarget;
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");
		clickedTab.classList.add("active");
		document.querySelector(activePaneID).classList.add("active");
	}
});

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
		$('#tags li a').each(function(i)
		{
			item = $(this).text();
			if(item.length > 0)
			{
				granted.push(item.slice(0,-1));
			}
		});
		$('#ungrantedtags li a').each(function(i)
		{
			item = $(this).text();
			if(item.length > 0)
			{
				ungranted.push(item.slice(0,-1));
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
		if (id === 'administrator')
		{
			return window.confirm("you can't delete an administrator");

		}else
		{
			var x =  window.confirm("Are you sure?");
			if (x)
			{
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
			}
		}
	});
});








/* DELETE ROLE CONFIRMATION */
/* ------------------------*/
jQuery(document).ready( function ($)
{
	//$(".signin").css("background-color", "yellow");
	$("button[type='delete']").click(function(){
		if (!confirm("Do you want to delete")){
			return false;
		}
	});

	$(".signinform").click(function(){
		$('.signin').toggle( "slow", function() {
    // Animation complete.
  });
		$('.login').toggle( "slow", function() {
    // Animation complete.
  });
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
var general= ['edit_dashboard','export','import','manage_categories','manage_links','manage_options','moderate_comments','read','unfiltered_html','unfiltered_upload','update_core','upload_files'];
var themes =['delete_themes','edit_theme_options','edit_themes','install_themes','switch_themes','update_themes'];
var posts=['create_posts','delete_others_posts','delete_posts','delete_private_posts','delete_published_posts','edit_others_posts','edit_posts','edit_private_posts','edit_published_posts','manage_categories','moderate_comments','publish_posts','read_private_posts'];
var pages=['create_pages','delete_others_pages','delete_pages','delete_private_pages','delete_published_pages','edit_others_pages','edit_pages','edit_private_pages','edit_published_pages','publish_pages','read_private_pages'];
var plugins=['activate_plugins','delete_plugins','edit_plugins','install_plugins','update_plugins'];
var users=['create_users','delete_users','edit_users','list_users','promote_users','remove_users'];
var custom = ['ure_create_capabilities','ure_create_roles','ure_delete_capabilities','ure_delete_roles','ure_edit_roles','ure_manage_options','ure_reset_roles'];
var deprecated = ['edit_files','level_0','level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10'];
var numgeneral=0;
var numthemes =0;
var numposts=0;
var numpages=0;
var numplugins=0;
var numusers=0;
var numcustom =0;

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
				if ($.inArray(key,deprecated) > -1 ) {

					$('ul#tags').append('<li  id="role_'+key+'"><a style="opacity:0.7;" href="#">'+key+'<span>D</span></a></li>');
					capsadminuni.push(key);
				}else{
					$('ul#tags').append('<li id="role_'+key+'"><a href="#">'+key+'<span>G</span></a></li>');
					capsadminuni.push(key);
				}
			});

			$.each(capsadminuni,function(key,value)
			{
				if ($.inArray(value,general) > -1 ) {
					numgeneral++;
				}
				if ($.inArray(value,themes) > -1 ) {
					numthemes++;
				}
				if ($.inArray(value,posts) > -1 ) {
					numposts++;
				}
				if ($.inArray(value,pages) > -1 ) {
					numpages++;
				}
				if ($.inArray(value,plugins) > -1 ) {
					numplugins++;
				}
				if ($.inArray(value,users) > -1 ) {
					numusers++;
				}
				if ($.inArray(value,custom) > -1 ) {
					numcustom++;
				}
			});

			//console.log(numgeneral);
			$(".single-storey span b").html(numgeneral);
			$(".double-storey span b").html(numthemes);
			$(".house-and-land span b").html(numposts);
			$(".develop-subdivide span b").html(numpages);
			$(".land-estate span b").html(numplugins);
			$(".apartments span b").html(numusers);
			$(".luxury-homes span b").html(numcustom);


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
						if ($.inArray(key,deprecated) > -1 )
						{
							$('ul#tags').append('<li  id="role_'+key+'"><a style="opacity:0.7;" href="#">'+key+'<span>D</span></a></li>');
							capsuni.push(key);
						}else
						{
							$('ul#tags').append('<li id="role_'+key+'"><a href="#">'+key+'<span>G</span></a></li>');
							capsuni.push(key);
						}
					}
				});

				for (var i=capsadminuni.length; i--;)
				{
					if (capsuni.indexOf(capsadminuni[i]) === -1)
					{

						if ($.inArray(capsadminuni[i],deprecated) > -1 )
						{
							allcaps.push(capsadminuni[i]);
							$('ul#ungrantedtags').append('<li id="role_'+capsadminuni[i]+'"><a style="opacity:0.7;" href="#">'+capsadminuni[i]+'<span>D</span></a></li>');
						}else{
							allcaps.push(capsadminuni[i]);
							$('ul#ungrantedtags').append('<li id="role_'+capsadminuni[i]+'"><a href="#">'+capsadminuni[i]+'<span>U</span></a></li>');
						}
					}
				}
				numgeneral=numthemes=numposts=numpages=numplugins=numusers=numcustom=0;
				$.each(capsuni,function(key,value)
				{
					if ($.inArray(value,general) > -1 ) {
						numgeneral++;
					}
					if ($.inArray(value,themes) > -1 ) {
						numthemes++;
					}
					if ($.inArray(value,posts) > -1 ) {
						numposts++;
					}
					if ($.inArray(value,pages) > -1 ) {
						numpages++;
					}
					if ($.inArray(value,plugins) > -1 ) {
						numplugins++;
					}
					if ($.inArray(value,users) > -1 ) {
						numusers++;
					}
					if ($.inArray(value,custom) > -1 ) {
						numcustom++;
					}
				});

			//console.log(numgeneral);
			$(".single-storey span b").html(numgeneral);
			$(".double-storey span b").html(numthemes);
			$(".house-and-land span b").html(numposts);
			$(".develop-subdivide span b").html(numpages);
			$(".land-estate span b").html(numplugins);
			$(".apartments span b").html(numusers);
			$(".luxury-homes span b").html(numcustom);


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
var modal3 = document.getElementsByClassName("modalrole")[0];
var modal4 = document.getElementsByClassName("modalrename")[0];

// Get the button that opens the modal
var btn = document.getElementsByClassName("update")[0];
var btn2 = document.getElementsByClassName("view")[0];
var btn3 = document.getElementsByClassName("create")[0];
var btn4 = document.getElementsByClassName("rename")[0];



// When the user clicks the button, open the modal
jQuery(".update").click(function()
{
	modal.style.display = "block";
});
jQuery(".view").click(function()
{
	modal2.style.display = "block";
});
jQuery(".create").click(function()
{
	modal3.style.display = "block";
});
jQuery(".rename").click(function()
{
	modal4.style.display = "block";
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
jQuery(".close3").click(function()
{
	modal3.style.display = "none";
	modal4.style.display = "none";
});
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event)
{
	if ( (event.target == modal3) || (event.target == modal4) )
	{
		modal3.style.display = "none";
		modal4.style.display = "none";
	}
	if ( (event.target == modal) || (event.target == modal2) )
	{
		modal.style.display = "none";
		modal2.style.display = "none";
	}
}


/* JS Functions for role  categories  */
/* -----------------------------------*/

jQuery(document).ready( function ($)
{
	$(document).on('click','.homes-list li', function ()
	{
		var catarr = new Array();
		var cat = $(this).data('cat');
		var color = '';
		var general= ['edit_dashboard','export','import','manage_categories','manage_links','manage_options','moderate_comments','read','unfiltered_html','unfiltered_upload','update_core','upload_files'];
		var themes =['delete_themes','edit_theme_options','edit_themes','install_themes','switch_themes','update_themes'];
		var posts=['create_posts','delete_others_posts','delete_posts','delete_private_posts','delete_published_posts','edit_others_posts','edit_posts','edit_private_posts','edit_published_posts','manage_categories','moderate_comments','publish_posts','read_private_posts'];
		var pages=['create_pages','delete_others_pages','delete_pages','delete_private_pages','delete_published_pages','edit_others_pages','edit_pages','edit_private_pages','edit_published_pages','publish_pages','read_private_pages'];
		var plugins=['activate_plugins','delete_plugins','edit_plugins','install_plugins','update_plugins'];
		var users=['create_users','delete_users','edit_users','list_users','promote_users','remove_users'];
		var custom = ['ure_create_capabilities','ure_create_roles','ure_delete_capabilities','ure_delete_roles','ure_edit_roles','ure_manage_options','ure_reset_roles'];


		$(".homes-list li").css('width','120px');
		$(this).css('width','130px');

		switch(cat) {
			case 'General':
			catarr = general;
			color='#f67b4f';
			break;
			case 'Themes':
			catarr = themes;
			color='#32a8d9';
			break;
			case 'Posts':
			catarr = posts;
			color='#ff3232';
			break;
			case 'Pages':
			catarr = pages;
			color='#fdbc3b';
			break;
			case 'Plugins':
			catarr = plugins;
			color='#551A8B';
			break;
			case 'Users':
			catarr = users;
			color='#67d0c7';
			break;
			case 'Custom':
			catarr = custom;
			color='#566b8d';
			break;
			default:
			catarr = '';
		}

		$( "ul#tags li a, ul#ungrantedtags li a").css("font-weight", "");
		$( "ul#tags li span, ul#ungrantedtags li span ").css("background","");
		$( "ul#tags li span, ul#ungrantedtags li span").css("border-color","");
		$.each(catarr,function(key,value)
		{
			if (key!='null')
			{
				$( "#role_"+value+" a").css("font-weight", "bold");
				$( "#role_"+value+" span").css("background", color);
				$( "#role_"+value+" span").css("border-color", color+' '+color+' '+color);
			}
		});

	});
});