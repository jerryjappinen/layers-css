
var menu = document.getElementById('menu');
var menuPrev = document.getElementsByClassName('display')[0];
var firstSection = document.getElementById('grid');



// Treat headline
window.fitText(document.getElementById('pageTitle'));



// Toggle fixed menu
window.onscroll = function (event) {
	var togglePoint = menuPrev.offsetTop + menuPrev.offsetHeight + getCss(menuPrev, 'margin-bottom');
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
		var targetPosition = target.offsetTop - menu.offsetHeight + getCss(target, 'border-top-width');
		scrollElementTo(document.body, targetPosition, 300);
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
	}, 2);

};



// Foo
var getCss = function (target, property) {
	return parseInt(window.getComputedStyle(target).getPropertyValue(property), 10);
};

// Class toggling
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
