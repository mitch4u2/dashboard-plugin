(function( $ ) {

	$( window ).load(function() {
		'use strict';
		var postsButton = document.getElementById('posts-btn');
		var container = document.getElementById("posts-container");

		if (postsButton) {
			postsButton.addEventListener("click",function(){





				var ourRequest = new XMLHttpRequest();
				ourRequest.open('GET', 'http://jira.foursites.nl/rest/api/latest/issue/SUPPORT-4969.json');
				ourRequest.onload = function() {
					if (ourRequest.status >= 200 && ourRequest.status < 400) {
						var data = JSON.parse(ourRequest.responseText);
						//createHTML(data);
						container.innerHTML = data;
						postsButton.remove();

					} else {
						console.log("We connected to the server, but it returned an error.");
					}
				};

				ourRequest.onerror = function() {
					console.log("Connection error");
				};

				ourRequest.send();






			});
		}

		function createHTML(postsData){
		var ourHTMLString = '';
		for (var i = 0; i < postsData.length; i++) {
			ourHTMLString += '<h2>' + postsData[i].title.rendered + '</h2>';
			ourHTMLString += postsData[i].content.rendered;
		}
		container.innerHTML = ourHTMLString;

	}

	});



	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	})( jQuery );
