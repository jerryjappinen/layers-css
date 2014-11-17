
# Layers CSS 1.1.1

A minimum-interference collection of common-sense default styles.

- Reference docs at [eiskis.net/layers](http://eiskis.net/layers/)
- Bitbucket project at [bitbucket.org/Eiskis/layers-css](https://bitbucket.org/Eiskis/layers-css)
- Released under the MIT license
- Authored by Jerry Jäppinen
	- [eiskis@gmail.com](mailto:eiskis@gmail.com)
	- [eiskis.net](http://eiskis.net/)
	- [@Eiskis](https://twitter.com/Eiskis)



## Get started using Layers

To get it all, use the single-file compilation:

	<link rel="stylesheet" href="release/layers.css">

You can also pick and choose what you want (in alphabetical order):

	<link rel="stylesheet" href="source/layers/_normalize.css">
	<link rel="stylesheet" href="source/layers/forms.css">
	<link rel="stylesheet" href="source/layers/grid.css">
	...

If you use an autoloader (e.g. asset pipeline in Rails), you can just include the whole directory.



### Responsive adjustments

All responsive adjustments are included in separate from the main release:

	<link rel="stylesheet" href="release/responsive.css">

Individual files are also available under `source/`. Feel free to edit the breaking points and add more complex degradation behavior, this is just a start.



### Extras

None of the other files contain any color scheme declarations. If you want to just get a usable page out, fast, you can add one of the separate color schemes from extras:

	<link rel="stylesheet" href="extras/light.css">



## How to contribute

Email, tweet and fork freely!


