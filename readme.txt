
Layers CSS
Minimum-interference collection of reset and default styles

See the reference docs at http://eiskis.net/layers/
Bitbucket project at https://bitbucket.org/Eiskis/layers-css

By Jerry Jäppinen
Released under the MIT license
eiskis@gmail.com
http://eiskis.net/
@Eiskis




Usage
=====

To get it all, use the single-file compilation:
	<link rel="stylesheet" href="release/layers.css">

You can also pick and choose what you want (in alphabetical order):
	<link rel="stylesheet" href="source/layers/_normalize.css">
	<link rel="stylesheet" href="source/layers/forms.css">
	<link rel="stylesheet" href="source/layers/grid.css">
	<link rel="stylesheet" href="source/layers/lists.css">
	<link rel="stylesheet" href="source/layers/rhythm.css">
	<link rel="stylesheet" href="source/layers/text.css">
	<link rel="stylesheet" href="source/layers/tools.css">

If you use an autoloader (e.g. asset pipeline in Rails), you can just include the whole directory.



Responsive adjustments
----------------------

All responsive adjustments are included in separate from the main release:
	<link rel="stylesheet" href="release/responsive.css">

and in individual files:
	<link rel="stylesheet" href="source/responsive/break-grid.css">
	<link rel="stylesheet" href="source/responsive/font-size.css">

Feel free to edit e.g. the breaking point for columns. You want to write more complex degradation declarations, this is just a start.



Extras
------

None of the other files contain any color scheme declarations. You have an empty canvas for your look.

If you want to just get a usable page out, fast, you can add one of the included, separate color files from extras.
	<link rel="stylesheet" href="extras/light.css">
