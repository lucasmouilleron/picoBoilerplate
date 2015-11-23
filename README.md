picoBoilerplate
===============

picoCMS is a lightweight flat file CMS.

![Screenshot](http://grabs.lucasmouilleron.com/Screen%20Shot%202015-11-23%20at%2015.49.30.png)

Features
--------
- A nice picoCMS web boiler plate
- Stack : picoCMS, twig, scss, requirejs, bootstrap, fontawesome
- Build : install, build, watch, composer, grunt, bower

Install requirements
--------------------
- Install NodeJS : http://nodejs.org/download
- `sudo npm install bower -g`
- `sudo npm install grunt -g`
- `sudo gem install sass`
- `sudo gem install --pre sass-css-importer`
- Install composer :
    - `curl -sS https://getcomposer.org/installer | php`
    - `mv composer.phar /usr/local/bin/composer`

Install
-------
- `curl -sS https://getcomposer.org/installer | php && composer install` (or `php composer.phar install`)
- `npm install`

Build
-----
- Edit the `package.json` file
- `grunt build` to build everything
- `grunt watch:scripts` while coding

Browserify, CommonJS, dependencies
----------------------------------
- Browserify is used to compile the app
- If module is not CommonJS, use `browserify-shim` (for shimming and deps) and `browser` (for aliases) in `package.json`
- If module is not available via bower or npm, use napa

Pico plugins
------------
- `myMetas` : 
    - adds custom metas in contents
    - metas defined in `config.php`
- `myNavigation` : 
    - adds custom navigation to templates 
    - users meta `status` wehter to display or not a page (`draft` is hidden, default status is `published`)
    - uses meta `order` (number)
- `myTags` :
    - adds `tags` to content
    - `tags.html` template must be defined to list all tags (use `{% for tag, tagPages in tags %}`)
    - `tag.html` template must be defined to list all pages of a tag (use `{% for page in pages %}` and `{{ meta.currentTag }}`)
- `myPlugin` :
    - example of a plugin running only on a template (on `before_render`, test `$template`)

Admin
-----
- ftp and edit `content` files

Credits
-------
Thanks to guys at http://picocms.org for their great CMS