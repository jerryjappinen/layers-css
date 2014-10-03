
# Layers CSS changelog

Latest official changelog is available on the web at [bitbucket.org/Eiskis/layers-css](https://bitbucket.org/Eiskis/layers-css/src/default/changelog.md).



## 1.1.0 - Sunday June 15, 2014

### To do

### Miscellaneous fixes

- `width: 100%; height: 100%;` added to normalizations for `html` and `body`.
- Some `input` definitions are less specific.
- Resetting border-radius in `.plain` inputs and buttons.
- Also added `.fifth`-width columns.
- `.row` and `.row-content` clear floats. However, they're still completely optional.

### New responsive adjustments !important;

The Layers CSS grid now supports columns set to arbitrary break points. The stock responsive adjustments set uses 4 break points.

Regular columns continue to never break unless explicitly set.

`.center` columns are no longer supported. To reliably center content, you can

1. adjust the `max-width` or a `row-container`,
2. `.keep-center` a container element while setting a sensible `max-width`, or
3. `.push-` a `.column` (responsive versions available).



## 1.0.6 - Saturday April 5, 2014

Switched width and max-width on text fields in `forms.css`. They're more intuitive and easier to override this way.

`.plain` inputs and buttons inherit text color.



## 1.0.5 - Monday March 3, 2014

Fixed `.absolute` positioning bug in `tools.css`. Prioritizing Helvetica over Lucida Grande as default font.



## 1.0.4 - Tuesday December 10, 2013

Updated default cursor for input elements in `_normalize.css`.



## 1.0.3 - Saturday November 30, 2013

Setting `outline-width` to 0 properly in `_normalize.css`.



## 1.0.2 - Friday October 25, 2013

Only `.plain` buttons inherit line-height.



## 1.0.1 - Tuesday October 22, 2013

List tools now work with definition lists, too. The following markups now work and make sense:

- `dl.plain`
- `dl.inline`
	- `dl.inline.center`
	- `dl.inline.right`
- `dl.collapse`
	- `dl.collapse.right`

Definition lists added to reference documentation as well.



## 1.0 - Friday October 18, 2013

First formal release. Latest additions include `.clear-after` and positioning tools.
