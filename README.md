# [Tornado v0.1.0](http://github.com/rasmushaglund/tornado)

The goal with tornado is to create a fully GTD-compatible manager that you can customize in any way you want to. 
You will be able to switch on/off features so that the same system can be used for basic and advanced users.

## Features
* Contexts (for both tasks and lists, support for multiple contexts)
* Tags
* Lists
* Lists in lists (sub projects)
* One-line-super-command-line for quickly adding tasks and lists

## Planned features
* Sharing of lists/tasks between users
* Recurring tasks
* Delegate tasks
* Create views with multiple lists
** For example you can create a view named "Work" with all lists with context @work and all lists with tag #important ordered by date of completion.
** Views will be fully configurable and involve: sorting, expressions, filtering etc
* Support for separating todo-lists with ordinary lists (lists like "Movies to watch" or "My life goals" should not take focus from your every day tasks.)
* Stuff (List of thoughts and fast notes that eventually become tasks)
* GMail integration (mail pop up in "stuff" and when a task is created the mail will be archived)
* Calendar integration (get tasks based on some criteria in your calendar)
* Posibility to sort tasks based on current energy, time available (GTD)

## Install
1. Install PHP and CakePHP
2. Import db.sql into your database (for example using phpmyadmin)
3. Edit config/database.php to point to your database with the corrent username and password
4. Change to full permissions for tmp/cache
5. Enable rewrite in your web server
6. You might have to edit CAKE_CORE_INCLUDE_PATH in webroot/index.php in order for tornado to know where you have installed CakePHP

## Contributing

## Author
**Rasmus Haglund**
+ http://github.com/rasmushaglund

## Copyright and license
