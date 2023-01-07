import sass from 'node-sass'
// import { readFileSync } from 'fs'
import path from 'path'

import { sourcePath } from '../settings'

export default async (req, res) => {
  const { min } = req.query

  const sourceCodePath = path.join(process.cwd() + './' + sourcePath + 'layers.scss')
  // console.log(sourcePath)
  
  // const sourceCode = readFileSync(sourceCodePath, 'utf8')
  // console.log(sourceCode)

  // https://www.npmjs.com/package/node-sass
  const result = sass.renderSync({
    // data: sourceCode,
    file: sourceCodePath,
    outputStyle: min ? 'compressed' : 'expanded'
  })

  res.status(200)
  res.setHeader('content-type', 'text/css')
  res.send(result.css)
}
