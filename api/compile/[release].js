import minify from '@node-minify/core'
import cleanCSS from '@node-minify/clean-css'

import { distPath, sourcePath } from '../../compileSettings'

const basePath = '../'

export default async (req, res) => {
  const { release } = request.query

  // https://www.npmjs.com/package/@node-minify/clean-css
  minify({
    compressor: cleanCSS,
    input: basePath + sourcePath + release + '.css',
    output: basePath + distPath + release + '.css',

    callback (err, min) {

      // Errors
      if (err) {
        res.status(500)
        res.setHeader('content-type', 'text/plain')
        res.send(`Something went wrong when compiling: ${err}`)

      // Compiled
      } else {
        res.status(200)
        res.setHeader('content-type', 'text/css')
        res.send(min)
      }
    }
  });

}
