picoBoilerplate
===============

picoCMS is a lightweight flat file CMS.

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
- `composer install`
- `cd build && npm install`

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
- `pico_editor` : 
    - admin interface on `/admin`
    - edit the admin password from `config.php`
    - bug fix : `$file = str_replace($this->settings['base_url'], "", strip_tags($file_url)); if($this->endsWith($file,"/")) $file .= "index";`

Admin
-----
- With plugin https://github.com/gilbitron/Pico-Editor-Plugin
- `http://thecmsurl.com/admin`

Credits
-------
Thanks to guys at http://picocms.org for their great CMS