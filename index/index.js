
var menu = document.getElementById('menu');



// Treat headline
window.fitText(document.getElementById('pageTitle'));

// Toggle fixed menu
var firstSection = document.getElementById('grid');
window.onscroll = function (event) {
	var togglePoint = firstSection.offsetTop + parseInt(window.getComputedStyle(firstSection).getPropertyValue('border-top-width'), 10);
	if (document.body.scrollTop > togglePoint) {
		addClass(menu, 'fixed');
	} else {
		removeClass(menu, 'fixed');
	}
};

// Bind menu link behavior
var menuLinks = menu.getElementsByTagName('a');
for (var i = 0; i < menuLinks.length; i++) {
	menuLinks[i].onclick = function (event) {
		event.preventDefault();
		var target = document.getElementById(this.getAttribute('href').substring(1));
		scrollElementTo(document.body, target.offsetTop, 300);
	};
}



// Scrolling behavior
var scrollElementTo = function (element, target, duration) {
	if (duration < 1) return;

	var difference = target - element.scrollTop;
	var perTick = difference / duration * 10;

	setTimeout(function() {
		element.scrollTop = element.scrollTop + perTick;
		scrollElementTo(element, target, duration - 2);
		console.log(target);
	}, 2);

};

// Toggle class for an element
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
