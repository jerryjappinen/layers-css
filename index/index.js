
/**
* Scrolling and menu watching
*/

// Scrolling behavior
var scrollWindow = function (element, waypoint, duration) {
	if (duration < 1) return;

	var target = menuWaypoints[waypoint]+1;
	var difference = target - element.scrollTop;
	var perTick = difference / duration * 10;

	element.scrollTop = element.scrollTop + perTick;
	setTimeout(function() {
		scrollWindow(element, waypoint, duration - 5);
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

// Update menu and other elements as the user scrolls
var watchWaypoints = function () {
	var i;
	var scrollPosition = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;

	// Toggle fixed menu, we're in sections
	if (scrollPosition > menuWaypoints[0]) {
		addClass(menu, 'fixed');
		var newWaypoint = 0;

		// Going up
		if (scrollPosition < menuWaypoints[currentWaypoint]) {
			newWaypoint = currentWaypoint - 1;

		// Going down, but not past end
		} else if (currentWaypoint < (menuWaypoints.length-1) && scrollPosition > menuWaypoints[currentWaypoint+1]) {
			newWaypoint = currentWaypoint + 1;
		}

		// We changed sections
		if (newWaypoint > 0) {
			currentWaypoint = newWaypoint;

			// Choose correct menu item
			for (i = 0; i < menuLinks.length; i++) {
				if (i === currentWaypoint-1) {
					addClass(menuLinks[i], 'selected');
					menuLinks[i].focus();
				} else {
					removeClass(menuLinks[i], 'selected');
					// menuLinks[i].blur();
				}
			}

		}


	// We're up there
	} else {
		removeClass(menu, 'fixed');
		currentWaypoint = 0;
		for (i = 0; i < menuLinks.length; i++) {
			menuLinks[i].blur();
			removeClass(menuLinks[i], 'selected');
		}
	}

};

// Toggle browser tabs
var selectBrowserTab = function (index) {
	removeClass(browser, 'unloaded');
	for (var i = 0; i < browserTabs.length; i++) {
		if (i === index) {
			loadSample(browserTabs[i].getAttribute('href'));
			addClass(browserTabs[i].parentNode, 'selected');
		} else {
			removeClass(browserTabs[i].parentNode, 'selected');
		}
	}
};

// Load document into fake browser
var loadSample = function (url) {
	browserSandbox.src = url;
	browserLink.href = url;
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

var menu = document.getElementById('menu');
var menuLinks = menu.getElementsByTagName('a');
var menuPrev = document.getElementsByClassName('display')[0];

var browser = document.getElementsByClassName('browser')[0];
var browserTabs = browser.getElementsByClassName('tabbar')[0].getElementsByTagName('a');
var browserSandbox = browser.getElementsByTagName('iframe')[0];
var browserTrigger = browser.getElementsByClassName('trigger')[0];
var browserLink = browser.getElementsByClassName('extracontrols')[0].getElementsByClassName('open')[0].getElementsByTagName('a')[0];

var sourceContainers = document.getElementsByClassName('source');
var menuWaypoints = [];
var currentWaypoint = 0;



/**
* App
*/

var DownloadManager = function () {
	var self = this;

	// Default values
	self.defaults = {
		em: [30, 45, 60, 75],
		px: [360, 768, 1024, 1440]
	};

	// Constants
	self.breakpointNames = ['tiny', 'small', 'medium', 'large', 'huge', 'extra'];
	self.coreSize = 15.9;
	self.breakpointSize = 6.5;
	self.compressionRatio = 0.7;

	// Active parameters
	self.breakpoints = ko.observableArray((function () {
		var results = [];
		for (var i = 0; i < self.breakpointNames.length; i++) {
			results.push(new Breakpoint(self.breakpointNames[i], (self.defaults.em[i] ? self.defaults.em[i] : 0), (self.defaults.px[i] ? self.defaults.px[i] : 0)));
		}
		return results;
	})());

	// Computed active parameters
	self.maxBreakpoints = ko.computed(function () {
		return self.breakpointNames.length;
	});

	self.breakpointCount = ko.computed(function () {
		return self.breakpoints().length;
	});

	self.estimatedSize = ko.computed(function () {
		return Math.floor(self.coreSize + self.breakpointCount() * self.breakpointSize);
	});

	self.estimatedSizeCompressed = ko.computed(function () {
		return Math.floor(self.compressionRatio * self.estimatedSize());
	});

};

var Breakpoint = function (name, em, px) {
	var self = this;

	self.em = ko.observable(em > 0 ? em : 0);
	self.px = ko.observable(px > 0 ? px : 0);
	self.name = ko.observable(name);

	self.em.subscribe(function (newValue) {
		if (newValue !== parseInt(newValue)) {
			self.em(parseInt(newValue));
		} else if (newValue < 0) {
			self.em(Math.abs(newValue));
		}
	});

	self.px.subscribe(function (newValue) {
		if (newValue !== parseInt(newValue)) {
			self.px(parseInt(newValue));
		} else if (newValue < 0) {
			self.px(Math.abs(newValue));
		}
	});

	self.selectedUnit = ko.observable('px');

	self.isEmpty = ko.computed(function () {
		return self.selectedUnit() === 'px' ? (self.px() <= 0) : (self.em() <= 0);
	});

	self.css = ko.computed(function () {
		return self.selectedUnit() + (self.isEmpty() ? ' empty' : '');
	});

	self.empty = function () {
		return self.selectedUnit() === 'px' ? self.px(0) : self.em(0);
	};

	self.toggle = function () {
		return self.selectedUnit() === 'px' ? self.selectedUnit('em') : self.selectedUnit('px');
	};

};

var app = new DownloadManager();



/**
* Init
*/
window.onload = function () {
	var i;

	// Bind menu links to scrolling
	for (i = 0; i < menuLinks.length; i++) {
		(function () {
			var j = i;
			var links = menuLinks;
			links[j].onclick = function (event) {
				event.preventDefault();
				scrollWindow(document.body, j+1, 300);
				scrollWindow(document.documentElement, j+1, 300);
			};
		})();
	}

	// Bind browser tab links to change sample
	for (i = 0; i < browserTabs.length; i++) {
		(function () {
			var j = i;
			var tabs = browserTabs;
			tabs[j].onclick = function (event) {
				if (event.which != 2 && !event.metaKey) {
					event.preventDefault();
					selectBrowserTab(j);
				}
			};
		})();
	}
	browserTrigger.onclick = function (event) {
		event.preventDefault();
		selectBrowserTab(0);
	};

	// Keep menu waypoints accurate
	menuWaypoints = findWaypoints();
	window.onresize = function (event) {
		menuWaypoints = findWaypoints();
		watchWaypoints();
	};

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

	// Watch waypoints when scrolling
	watchWaypoints();
	window.onscroll = watchWaypoints;



	// Ko
	ko.applyBindings(app);

};


