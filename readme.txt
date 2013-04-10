
Layers CSS
Minimum-interference collection of reset and default styles

Docs and demos at http://eiskis.net/layers/
Bitbucket project at https://bitbucket.org/Eiskis/layers-css

By Jerry Jäppinen
Released under the MIT license
eiskis@gmail.com
http://eiskis.net/
@Eiskis




Usage
=====

To get it all, use the single-file compilation:
	<link rel="stylesheet" href="layers/base.css">

You can also pick and choose what you want (in alphabetical order):
	<link rel="stylesheet" href="layers/base/_reset.css">
	<link rel="stylesheet" href="layers/base/defaults.css">
	<link rel="stylesheet" href="layers/base/elements.css">
	<link rel="stylesheet" href="layers/base/inline.css">
	<link rel="stylesheet" href="layers/base/layout.css">
	<link rel="stylesheet" href="layers/base/text.css">
	<link rel="stylesheet" href="layers/base/tools.css">

If you use an autoloader (e.g. asset pipeline in Rails), you can just include the whole base directory.



Responsive adjustments
----------------------

All responsive adjustments are included in separate stylesheets:
	<link rel="stylesheet" href="layers/responsive/break-grid.css">
	<link rel="stylesheet" href="layers/responsive/font-size.css">

or in one file:
	<link rel="stylesheet" href="layers/responsive.css">

Feel free to edit e.g. the breaking point for columns. You want to write more complex degradation declarations, this is just a start.



Extras
------

None of the other files contain any color scheme declarations. You have an empty canvas for your look.

If you want to just get a usable page out, fast, you can add one of the included, separate color files from extras.
	<link rel="stylesheet" href="extras/light.css">
