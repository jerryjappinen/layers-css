
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
	<link rel="stylesheet" href="layers.css">

You can also pick and choose what you want (use alphabetical order):
	<link rel="stylesheet" href="layers/_reset.css">
	<link rel="stylesheet" href="layers/_tools.css">
	<link rel="stylesheet" href="layers/defaults.css">
	<link rel="stylesheet" href="layers/elements.css">
	<link rel="stylesheet" href="layers/inline.css">
	<link rel="stylesheet" href="layers/layout.css">
	<link rel="stylesheet" href="layers/typography.css">

If you use an autoloader (like asset pipeline in Rails, for example), you can just include the whole "layers" folder.



Responsive adjustments
----------------------

All responsive adjustments are included in separate stylesheets:
	<link rel="stylesheet" href="layers-responsive/break-grid.css">
	<link rel="stylesheet" href="layers-responsive/font-size.css">

or all of them in one file:
	<link rel="stylesheet" href="layers-responsive.css">

Feel free to edit e.g. the breaking point for columns if you want. For more complex layout, you want to write more complex degradation declarations.



Colors
------

None of the other files contain any color scheme declarations. You have an empty canvas for your look.

If you want to just get a usable page out, fast, you can add one of the included, separate color files.
	<link rel="stylesheet" href="layers-colors/light.css">
