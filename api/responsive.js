import sass from 'node-sass'
import path from 'path'

// import { sourcePath } from '../settings'

// https://layers-css.vercel.app/responsive/?breakpoint0=tiny,20em&breakpoint1=small,40em&breakpoint2=medium,70em&breakpoint3=large,30em&breakpoint4=huge,80em&breakpoint5=extra,90em
export default async (req, res) => {

  const {
    min,
    breakpoints
  } = req.query

  // Read desired breakpoint definitions
  const definitions = []
  if (breakpoints) {
    breakpoints.split(';').forEach((breakpoint) => {
      if (breakpoint) {
        const [name, width] = breakpoint.split(',')
        if (name && width) {

          // Calculate barelyWidth
          const unit = width.indexOf('em') > -1 ? 'em' : 'px'
          const val = parseFloat(width.substr(0, width.length - 2))
          const barelyWidth = (val - (unit === 'em' ? 0.0625 : 1)) + unit

          definitions.push({ name, width, barelyWidth })
        }
      }
    })
  }

  // const sourceCodePath = path.join(process.cwd() + '/' + sourcePath + 'responsive.scss')
  // const mixinsPath = path.join(process.cwd() + '/' + sourcePath + 'mixins/') // won't work
  const mixinsPath = path.join(process.cwd(), 'source', 'mixins')
  const sourceCode = `
  /*
  Layers CSS 1.2.0
  Docs: https://layers-css.vercel.app
  Source: https://github.com/jerryjappinen/layers-css
  */

  $custom-breakpoints: (${definitions.map((({ name, width, barelyWidth }) => {
    return `(${name}, ${width}, ${barelyWidth})`
  })).join(',')});
  
  // Actual CSS code is here
  @import '${mixinsPath}/responsive.scss';

  @include responsive($custom-breakpoints);
  `

  // https://www.npmjs.com/package/node-sass
  const result = sass.renderSync({
    data: sourceCode,
    // includePaths: [
    //   sourceCodePath + 'mixins/'
    // ],
    outputStyle: min ? 'compressed' : 'expanded'
  })

  res.status(200)
  res.setHeader('content-type', 'text/css')
  res.send(result.css)
}
