# [Tornado v0.1.0](http://github.com/rasmushaglund/tornado)

The goal with tornado is to create a fully GTD-compatible manager that you can customize in any way you want to. 
You will be able to switch on/off features so that the same system can be used for basic and advanced users.

## Features
* Tasks
* Lists
* Contexts
** Support for multiple contexts in tasks and lists
* Tags
* Sub lists
* Share lists and tasks between users
* Deadline, energy, time available, priority
* Drag and drop to move lists and tasks
* Trash can to resurrect deleted tasks and lists
* Autocompleted navigation for finding lists, tags and contexts
* Multi-purpose command line for adding tasks and lists
** Support for adding multiple tags and contexts inline
** Support for adding sharing the item inline
* Activating/deactivating lists
* Parameter based panels for viewing items
** Example:
*** Show all lists that are active
*** Show all lists with tag #project that are not deleted and are active
*** Show all deleted tasks in list x with tag y and context z
* Show multiple panels at the same time

## Planned features
* Recurring tasks
* Delegate tasks
* Stuff 
** List of thoughts and fast notes that eventually become actions
* Posibility to create and save custom parameter based panels
* iCal support
* Support for separating todo-lists from ordinary lists (lists like "Movies to watch" or "My life goals" should not take focus from your every day tasks.)
* Settings panel to add and remove most major features (like tags, contexts, sub lists, drag and drop)
* View for displaying users

## Install
1. Install PHP and CakePHP
2. Import db.sql into your database (for example using phpmyadmin)
3. Edit config/database.php to point to your database with the corrent username and password
4. Change to full permissions for tmp/cache
5. Enable rewrite in your web server
6. You might have to edit CAKE_CORE_INCLUDE_PATH in webroot/index.php in order for tornado to know where you have installed CakePHP

## Contributing
Yes

## Author
**Rasmus Haglund**
+ http://github.com/rasmushaglund

## Copyright and license
