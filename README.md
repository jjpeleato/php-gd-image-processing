# PHP and GD library

Create and manipulate image files with PHP and the GD library of images.

https://www.php.net/manual/en/book.image.php

PHP is not limited to creating just HTML output. It can also be used to create and manipulate image files in a variety of different image formats, including GIF, PNG, JPEG, WBMP, and XPM. Even more conveniently, PHP can output image streams directly to a browser. You will need to compile PHP with the GD library of image functions for this to work. GD and PHP may also require other libraries, depending on which image formats you want to work with. 

**The main file is: `public/src/core/GdGraphicsLibrary.php`**

This file is an example that uses the image processing with GD library.

### Installing dependencies

- You have to install **Lando**: https://docs.devwithlando.io/

If Lando's tools does not work for you, there is another way. You must install the environment manually: XAMP, Composer, Node.JS, NPM or Yarn and Gulp CLI.

For more information visit:

- XAMP: https://www.apachefriends.org/es/index.html
- Composer: https://getcomposer.org/
- Node and NPM: https://nodejs.org/es/
- Yarn: https://yarnpkg.com/es-ES/
- Gulp: https://gulpjs.com/

**Note:** If you work with Windows. To execute the commands, we recommend installing **Cygwin** http://www.cygwin.com/

**Note:** I recommend installing the following IDE for PHP Programming: Visual Studio Code (https://code.visualstudio.com/) or PHPStorm (recommended) (https://www.jetbrains.com/phpstorm/).

### Project skeleton

```
├─ assets/ # Front-end directory
│  ├─ fonts/
│  ├─ img/
│  ├─ js/
│  ├─ scss/
│  ├─ .htaccess.dist
│  └─ .htpasswd.dist
├─ gulp/
│  ├─ task/
│  └─ config.js # Paths and configuration Gulp system.
├─ private/
│  ├─ config/ # Environment configuration
│  └─ .htaccess
├─ public/ # Public directory
│  ├─ src/ # Source directory
│  ├─ upload/ # Uploading directory
│  ├─ browserconfig.xml
│  ├─ index.html
│  ├─ manifest.json
│  └─ phpinfo.php
├─ .babelrc
├─ .editorconfig
├─ .gitignore
├─ .jshintignore
├─ .jshintrc
├─ .lando.yml
├─ .stylelintignore
├─ .stylelintrc
├─ composer.json
├─ gulpfile.babel.js
├─ LICENSE
├─ package.json
└─ README.md
```

### Installing

1. Open your terminal and browse to the root location of your project.
2. Run `$lando start`.
	- The project has a .lando.yml file with all the environment settings.
	- The command starts the installation process when it finishes, you can see all the URLs to access.
3. If required. Run: `$lando composer install`
4. If required. Run: `$lando npm install --save-dev` or `$lando yarn install --dev`
5. End. Happy developing.

### Developing with NPM or Yarn and Gulp.

- Open your terminal and browse to the root location of your project.
- If required. Run: `$lando npm install --save-dev` or `$lando yarn install --dev` then: `$lando gulp [action]`
- To work with and compile your Sass and JS files on the fly start: `$lando gulp`
- Gulp actions commands list:
    - `$lando gulp clean` Delete all files.
    - `$lando gulp css` Compile SASS to CSS and validate SASS according Stylelint (https://stylelint.io/). Not concat.
    - `$lando gulp cssAssets` Copy CSS assets to public directory.
    - `$lando gulp cssWithConcat` Concat and compile SASS to CSS and validate SASS according Stylelint (https://stylelint.io/).
    - `$lando gulp fontAssets` Copy fonts assets to public directory.
    - `$lando gulp images` Copy and minify PNG, JPEG, GIF and SVG images with imagemin.
    - `$lando gulp imagesAssets` Copy and minify PNG, JPEG, GIF and SVG assets images with imagemin.
    - `$lando gulp js` Validate the code with JSHint. Minify the JS files.
    - `$lando gulp jsAssets` Copy JS assets to public directory.
    - `$lando gulp jsWithConcat` Validate the code with Jshint. Concat and minify the JS files.
    - `$lando gulp validateJs` Validate JS with JSHint (https://jshint.com/).
    - `$lando gulp validateScss` Validate SCSS according Stylint (https://stylelint.io/).
    - `$lando gulp watch` Compile SASS to CSS and concat and minify JS files in real-time.
- NPM actions commands list:
    - `$lando npm run gulp:dev` Compile for development environment
    - `$lando npm run gulp:prod` Compile for production environment

### Technologies and tools

The present project uses several technologies and tools for the automation and development process. For more information and learning visit the following links.

1. Git: https://git-scm.com/
2. Lando: https://docs.devwithlando.io/
3. Composer: https://getcomposer.org/
4. NPM: https://www.npmjs.com/
5. Yarn: https://yarnpkg.com/
6. Sass: https://sass-lang.com/
7. Gulp: https://gulpjs.com/
8. Babel: https://babeljs.io/
9. EditorConfig: https://editorconfig.org/
10. Stylelint: https://stylelint.io/
11. Jshint: https://jshint.com/
12. Human.txt: http://humanstxt.org/

**Note:** Thanks a lot of developers that to work on this projects.

### Others clarifications

1. It is possible that on Mac OS the Gulp tasks do not run the correct form. In this case install NodeJS, NPM and Gulp-cli in your OS and execute the tasks outside the Docker containers.

## Finally

More information on the following commits. If required.

I hope you find it useful.

Grettings **@jjpeleato**.