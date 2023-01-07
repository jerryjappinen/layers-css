# Layers CSS 1.2.0

A minimum-interference collection of common-sense default styles.

- Reference docs at [eiskis.net/layers](http://eiskis.net/layers/)
- GitHub project at [https://github.com/Eiskis/layers-css](https://github.com/Eiskis/layers-css)
- Released under the MIT license
- Authored by Jerry Jäppinen
	- [eiskis@gmail.com](mailto:eiskis@gmail.com)
	- [eiskis.net](http://eiskis.net/)
	- [@Eiskis](https://twitter.com/Eiskis)



## Get started using Layers

To get it all, use the single-file compilation:

```html
<link rel="stylesheet" href="release/layers.min.css">
```

You can also pick and choose what you want (in alphabetical order):

```html
<link rel="stylesheet" href="source/layers/_normalize.css">
<link rel="stylesheet" href="source/layers/forms.css">
<link rel="stylesheet" href="source/layers/grid.css">
...
```

If you use an autoloader (e.g. asset pipeline in Rails), you can just include the whole source directory.



### Responsive adjustments

All responsive adjustments are included in separate from the main release:

```html
<link rel="stylesheet" href="release/responsive.min.css">
```

Individual files are also available under `source/`.

You'll want to build the responsive part with your own break points at [jerryjappinen.com/layers/](http://labs.jerryjappinen.com/layers/) and add more complex degradation behavior, this is just a start.



## How to contribute

Email, tweet and fork freely!


