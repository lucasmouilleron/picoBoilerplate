picoBoilerplate
===============

picoCMS is a lightweight flat file CMS.

Features
--------
- A nice picoCMS web boiler plate
- Stack : picoCMS, twig, scss, requirejs, bootstrap, fontawesome
- Build : install, build, watch, composer, grunt, bower

Install
-------
- Install NodeJS : http://nodejs.org/download
- `sudo npm install bower -g`
- `sudo npm install grunt -g`
- `sudo gem install sass`
- `sudo gem install --pre sass-css-importer`
- Install composer :
    - `curl -sS https://getcomposer.org/installer | php`
    - `mv composer.phar /usr/local/bin/composer`
- `composer install`

Build
-----
- modify ```_build/config.json``` if needed
- ```cd _build```
- ```npm install && grunt build```

Bower
-----
- Add a requirejs module from bower :
    - `cd _build && bower install the_module --save`
    - Then, add path to `_dev/js/libs/vendor/the_module/path/to/jsFile` in `_dev/main.js` in path section and include module name in the `requirejs` call
- Add a css from bower : 
    - `cd _build && bower install the_module --save`
    - Then edit `_dev/scss/main.scss` and add @import `"CSS:../js/libs/vendor/the_module/the_css_path/the_css_file_without_extension";`
- Add a public resource from bower : 
    - `cd _build && bower install the_module --save`
    - Then edit `build/config.json` and update the `copyFiles` value so the files from the vendor path are copyied in the public `assets` folder

Pico plugins
------------
- Place in `plugins`
- It is possible to make a plugin run only on a template (on `before_render`, test `$template`)


Credits
-------
Thanks to guys at http://picocms.org for their great CMS