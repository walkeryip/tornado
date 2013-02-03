BOOTSTRAP = ./docs/assets/css/bootstrap.css
TORNADO_LESS = ./bootstrap/less/bootstrap.less
BOOTSTRAP_RESPONSIVE = ./docs/assets/css/bootstrap-responsive.css
TORNADO_RESPONSIVE_LESS = ./bootstrap/less/responsive.less
DATE=$(shell date +%I:%M%p)
CHECK=\033[32m✔\033[39m
HR=\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#


#
# BUILD DOCS
#

build:
	@echo "\n${HR}"
	@echo "Building Bootstrap..."
	@echo "${HR}\n"
	@jshint js/*.js --config js/.jshintrc
	@jshint js/tests/unit/*.js --config js/.jshintrc
	@echo "Running JSHint on javascript...             ${CHECK} Done"
	@recess --compile ${BOOTSTRAP_LESS} > ${BOOTSTRAP}
	@recess --compile ${BOOTSTRAP_RESPONSIVE_LESS} > ${BOOTSTRAP_RESPONSIVE}
	@echo "Compiling LESS with Recess...               ${CHECK} Done"
	@node docs/build
	@cp img/* docs/assets/img/
	@cp js/*.js docs/assets/js/
	@cp js/tests/vendor/jquery.js docs/assets/js/
	@echo "Compiling documentation...                  ${CHECK} Done"
	@cat js/bootstrap-transition.js js/bootstrap-alert.js js/bootstrap-button.js js/bootstrap-carousel.js js/bootstrap-collapse.js js/bootstrap-dropdown.js js/bootstrap-modal.js js/bootstrap-tooltip.js js/bootstrap-popover.js js/bootstrap-scrollspy.js js/bootstrap-tab.js js/bootstrap-typeahead.js js/bootstrap-affix.js > docs/assets/js/bootstrap.js
	@uglifyjs docs/assets/js/bootstrap.js -nc > docs/assets/js/bootstrap.min.tmp.js
	@echo "/**\n* Bootstrap.js v2.2.2 by @fat & @mdo\n* Copyright 2012 Twitter, Inc.\n* http://www.apache.org/licenses/LICENSE-2.0.txt\n*/" > docs/assets/js/copyright.js
	@cat docs/assets/js/copyright.js docs/assets/js/bootstrap.min.tmp.js > docs/assets/js/bootstrap.min.js
	@rm docs/assets/js/copyright.js docs/assets/js/bootstrap.min.tmp.js
	@echo "Compiling and minifying javascript...       ${CHECK} Done"
	@echo "\n${HR}"
	@echo "Bootstrap successfully built at ${DATE}."
	@echo "${HR}\n"
	@echo "Thanks for using Bootstrap,"
	@echo "<3 @mdo and @fat\n"

#
# RUN JSHINT & QUNIT TESTS IN PHANTOMJS
#

test:
	jshint js/*.js --config js/.jshintrc
	jshint js/tests/unit/*.js --config js/.jshintrc
	node js/tests/server.js &
	phantomjs js/tests/phantom.js "http://localhost:3000/js/tests"
	kill -9 `cat js/tests/pid.txt`
	rm js/tests/pid.txt

#
# CLEANS THE ROOT DIRECTORY OF PRIOR BUILDS
#

clean:
	rm -r bootstrap

#
# BUILD SIMPLE BOOTSTRAP DIRECTORY
# recess & uglifyjs are required
#

tornado:
	mkdir -p img
	mkdir -p css
	mkdir -p js
	recess --compile ${TORNADO_LESS} > css/tornado.css
	recess --compress ${TORNADO_LESS} > css/tornado.min.css
	recess --compile ${TORNADO_RESPONSIVE_LESS} > css/tornado-responsive.css
	recess --compress ${TORNADO_RESPONSIVE_LESS} > css/tornado-responsive.min.css
	rm js/tornado-combined.js*
	cat js/lib/mustache.js js/lib/prototype.js js/lib/jquery*.js js/tornado.js js/template-manager.js js/commandbar.js js/state.js js/panel-manager.js js/breadcrumbs.js js/navigationtree.js js/models/item.js js/models/label.js js/models/context.js js/models/tag.js js/models/list.js js/models/task.js js/models/user.js js/views/element.js js/views/tag-element.js js/views/context-element.js js/views/task-element.js js/views/list-element.js js/panels/panel.js js/panels/general-panel.js bootstrap/bootstrap/js/bootstrap.min.js js/lib/bootstrap-contextmenu.js > js/tornado-combined.js 
	uglifyjs js/tornado-combined.js -nc > js/tornado.min.tmp.js
	#echo "/*!\n* Bootstrap.js by @fat & @mdo\n* Copyright 2012 Twitter, Inc.\n* http://www.apache.org/licenses/LICENSE-2.0.txt\n*/" > bootstrap/js/copyright.js
	cat js/tornado.min.tmp.js > js/tornado.min.js
	rm js/tornado.min.tmp.js
	

#
# MAKE FOR GH-PAGES 4 FAT & MDO ONLY (O_O  )
#

gh-pages: bootstrap docs
	rm -f docs/assets/bootstrap.zip
	zip -r docs/assets/bootstrap.zip bootstrap
	rm -r bootstrap
	rm -f ../bootstrap-gh-pages/assets/bootstrap.zip
	node docs/build production
	cp -r docs/* ../bootstrap-gh-pages

#
# WATCH LESS FILES
#

watch:
	echo "Watching less files..."; \
	watchr -e "watch('less/.*\.less') { system 'make' }"


.PHONY: docs watch gh-pages