# Layers CSS 1.2.0

A minimum-interference collection of common-sense default styles.

- Reference docs at [layers-css.vercel.app](https://layers-css.vercel.app)
- GitHub project at [https://github.com/jerryjappinen/layers-css](https://github.com/jerryjappinen/layers-css)
- Released under the MIT license
- Authored by [@jerryjappinen](https://github.com/jerryjappinen/)



## Get started using Layers CSS

To get it all, use the single-file compilation:

```html
<link rel="stylesheet" href="release/layers.min.css">
```

You can also pick and choose what you want (in alphabetical order):

```html
<link rel="stylesheet" href="source/layers/normalize.css">
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


