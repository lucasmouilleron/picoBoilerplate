module.exports = function(grunt) {

  /////////////////////////////////////////////////////////////////////////
  grunt.initConfig({
    pkg: grunt.file.readJSON("package.json"),
    cfg: grunt.file.readJSON("package.local.json"),
    availabletasks: {
      tasks: {
        options: {
          sort: true,
          filter: "include",
          tasks: ["default","install", "cleanup","compile:images","watch","build","watch:scripts", "compile:scripts", "compile:styles", "watch:styles"]
        }
      }
    },
    shell: {
      options: {
        stdout: true,
        stderr: true,
        stdin: true
      },
      install: {
        command: function() {
          return "npm install";
        }
      },
    },
    browserify: {
      watch: {
        files: {
          "<%=pkg.config.dirs.js%>/_build.js": ["<%=pkg.config.dirs.js%>/main.js"],
        },
        options: {
          watch: true
        }
      },
      compile: {
        files: {
          "<%=pkg.config.dirs.js%>/_build.js": ["<%=pkg.config.dirs.js%>/main.js"],
        }
      }
    },
    uglify: {
      options: {
        report: "min",
        mangle: false
      },
      dist: {
        files: {
          "<%=pkg.config.dirs.js%>/_build.js": ["<%=pkg.config.dirs.js%>/_build.js"]
        }
      }
    },
    compass: {
      compile: {
        options: {
          httpPath: "<%=cfg.baseURL%>",
          sassDir: "<%=pkg.config.dirs.sass%>",
          cssDir: "<%=pkg.config.dirs.css%>",
          imagesDir: "<%=pkg.config.dirs.img%>",
          fontsDir: "<%=pkg.config.dirs.fonts%>",
          cacheDir: ".sass-cache",
          outputStyle:"compressed",
          relativeAssets:true,
          lineComments:false,
          force: true,
          raw: "preferred_syntax = :sass\n",
          environment: "production",
          require: ["sass-css-importer"]
        }
      }
    },
    watch: {
      sass: {
        files: ["<%=pkg.config.dirs.sass%>/**/*.scss"],
        tasks: ["compile:styles"]
      },
      fake: {
        files: ["fake"],
        tasks: ["default"]
      }
    },
    clean: {
      options: { 
        force: true 
      },
      default: {
        src: "<%=pkg.config.cleanFiles%>"
      }
    },
    copyFiles: {
      main: {
        files: "<%=pkg.config.copyFiles%>"
      }
    },
    autoprefixer: {
      options: {
       browsers: ["last 2 version"]
     },
     default: {
       files: [{
        expand: true, 
        cwd: "<%=pkg.config.dirs.css%>/",
      src: "{,*/}*.css",
      dest: "<%=pkg.config.dirs.css%>/"
    }]
  }
}
});

  /////////////////////////////////////////////////////////////////////////
  grunt.loadNpmTasks("grunt-available-tasks");
  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-compass");
  grunt.loadNpmTasks("grunt-contrib-clean");
  grunt.loadNpmTasks("grunt-autoprefixer");
  grunt.loadNpmTasks("grunt-shell");
  grunt.loadNpmTasks("grunt-contrib-uglify");
  grunt.loadNpmTasks("grunt-browserify");

  /////////////////////////////////////////////////////////////////////////
  grunt.registerTask("default", "These help instructions",["availabletasks"]);
  grunt.registerTask("cleanup", "Clean project",["clean:default"]);
  grunt.registerTask("install", "Install the project",["shell:install", "copyFiles:main"]);
  grunt.registerTask("watch:styles", "Compile sass files",["watch:sass"]);
  grunt.registerTask("compile:scripts", "Compile js files",["browserify:compile","uglify:dist"]);
  grunt.registerTask("watch:scripts", "Watch and compile js files",["browserify:watch", "watch:fake"]);
  grunt.registerTask("compile:styles", "Watch and compile sass files",["compass:compile","autoprefixer"]);
  grunt.registerTask("build", "Build all (scripts + styles)",["install", "compile:styles","compile:scripts"]);

  /////////////////////////////////////////////////////////////////////////
  grunt.task.registerMultiTask("copyFiles", function() {
    var path = require("path");
    for(file in this.data.files) {
      var filesCopy = grunt.file.expand(file);
      for(fileCopy in filesCopy) {
        var from = filesCopy[fileCopy];
        var to = path.join(this.data.files[file], path.basename(from));
        grunt.log.ok("Copying "+from+" to "+to)
        grunt.file.copy(from, to);
      }
    }
  });
};