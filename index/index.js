
/**
* Custom behavior
*/

// Scrolling behavior
var scrollElementTo = function (element, waypoint, duration) {
	if (duration < 1) return;

	var target = menuWaypoints[waypoint];
	var difference = target - element.scrollTop;
	var perTick = difference / duration * 10;

	setTimeout(function() {
		element.scrollTop = element.scrollTop + perTick;
		scrollElementTo(element, waypoint, duration - 5);
	}, 5);

};

// Calculate waypoints for toggling the menu items
var findWaypoints = function () {
	var results = [];

	// Menu position
	results.push(menuPrev.offsetTop + menuPrev.offsetHeight + getCss(menuPrev, 'margin-bottom'));

	// Sections
	for (var i = 0; i < menuLinks.length; i++) {
		var target = document.getElementById(menuLinks[i].getAttribute('href').substring(1));
		results.push(target.offsetTop - menu.offsetHeight + getCss(target, 'border-top-width'));
	}

	return results;
};

var watchWaypoints = function () {
	var i;

	// Toggle fixed menu
	if (document.body.scrollTop > menuWaypoints[0]) {
		addClass(menu, 'fixed');
		for (i = 0; i < menuLinks.length; i++) {
			if (document.body.scrollTop >= menuWaypoints[i+1] && (i == menuLinks.length-1 || document.body.scrollTop < menuWaypoints[i+2])) {
				addClass(menuLinks[i], 'selected');
			} else {
				removeClass(menuLinks[i], 'selected');
			}
		}

	// Switch selected item
	} else {
		removeClass(menu, 'fixed');
		for (i = 0; i < menuLinks.length; i++) {
			removeClass(menuLinks[i], 'selected');
		}
	}

};



/**
* Helpers
*/

// Helper to read numerical CSS values
var getCss = function (target, property) {
	return parseInt(window.getComputedStyle(target).getPropertyValue(property), 10);
};

// Class toggling
var toggleClass = function (element, className) {
	if (hasClass(element, className)) {
		removeClass(element, className);
	} else {
		addClass(element, className);
	}
};
var addClass = function (element, className) {
	if (!hasClass(element, className)) {
		element.className = element.className + ' ' + className;
	}
};
var removeClass = function (element, className) {
	if (hasClass(element, className)) {
		element.className = (' ' + element.className.replace(' ' + className, '')).substring(1);
	}
};
var hasClass = function (element, className) {
	return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
};



/**
* Document skeleton & configs
*/
var downloadLink = document.getElementsByClassName('download')[0];
var firstSection = document.getElementById('grid');
var intro = document.getElementsByClassName('row-intro')[0];
var menu = document.getElementById('menu');
var menuLinks = menu.getElementsByTagName('a');
var menuPrev = document.getElementsByClassName('display')[0];
var sourceContainers = document.getElementsByClassName('source');
var tabGuard = document.getElementsByClassName('tabGuard')[0];
var menuWaypoints = [];



/**
* App launch & bindings
*/

window.onload = function () {
	var i;

	// Highlight download link
	downloadLink.onmouseover = highlightDownload;
	downloadLink.onfocus = highlightDownload;
	downloadLink.onmouseout = removeHighlightDownload;
	downloadLink.onblur = removeHighlightDownload;
	var highlightDownload = function () {
		addClass(intro, 'highlightDownload');
	};
	var removeHighlightDownload = function () {
		removeClass(intro, 'highlightDownload');
	};

	// Cycle tabindex
	tabGuard.onfocus = function () {
		downloadLink.focus();
	};

	// Bind menu links to scrolling
	for (i = 0; i < menuLinks.length; i++) {
		(function () {
			var j = i;
			var links = menuLinks;
			links[j].onclick = function (event) {
				event.preventDefault();
				scrollElementTo(document.body, j+1, 300);
			};
		})();
	}

	// Keep track of menu waypoints
	menuWaypoints = findWaypoints();
	window.onresize = function (event) {
		menuWaypoints = findWaypoints();
	};

	// Menu waypoints
	watchWaypoints();
	window.onscroll = watchWaypoints;

	// Source code previews
	for (i = 0; i < sourceContainers.length; i++) {
		(function () {
			var parent = sourceContainers[i];
			parent.getElementsByClassName('trigger')[0].onclick = function (event) {
				event.preventDefault();
				toggleClass(parent, 'collapsed');

				// Recalculate waypoints (hacky)
				setTimeout(function () {
					menuWaypoints = findWaypoints();
				}, 300);
			};
		})();
	}

};


