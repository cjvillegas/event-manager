## Event Manager
This application is built on top of Laravel 7.x and VueJS 2.

### Getting Started
***
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

#### Prerequisites
***
Installation, server and testing requirements.

* PHP >= 7.1.3
* [Git](https://git-scm.com/downloads)
* [Composer](https://getcomposer.org/download/)
* [XAMPP](https://www.apachefriends.org/index.html), [WAMP](http://www.wampserver.com/en/) or [LAMP](https://bitnami.com/stack/lamp/installer) or any webserver that supports PHP >= 7.1.3

#### Application Setup
***
1. Using `git bash`, navigate to your web server&apos;s public directory
	* XAMPP => `cd <installation folder>/htdocs`
	* WAMP => `cd <installation folder>/www`
	* LAMP => ` cd <installation folder>/opt/bitnami/apache2/htdocs/` (**not sure**)

2. Clone repository and navigate to project folder `git clone https://github.com/cjvillegas/event-manager.git && cd event-manager`

3. Run `git checkout staging`. You might want to run `git pull origin staging`, so that you could pull recent updates from the staging branch.

4. Ask for a copy of the staging DB and import it to your MySQL. Or, you could instead create a DB manually and run the migration command `php artisan migrate`, and seed command `php artisan db:seed`, these will automatically populate the table for you.

5. Locate `.env.example` in project root directory, open and save it as `.env`. **Don&apos;t rename**. If it shows already exist warning, try to hit `space` then `backspace` and click save.

6. Modify the `.env` to match your local environment DB config. Example configuration below.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_manager
DB_USERNAME=root
DB_PASSWORD=
```
7. Setup virtual host.
	- Edit your webserver&apos;s vhosts file. (Modify path if necessary)
	
		XAMPP => `<xampp installation folder>apache/conf/extra/httpd-vhosts.conf`
		
		WAMP => `<wamp installation folder>bin/Apache#.#.#/conf/httpd`
		```
		<VirtualHost *:80>
    		DocumentRoot "C:/xampp/htdocs/event-manager/public"
			DirectoryIndex index.php
			ServerName aptsr.event-manager
    		ServerAlias aptsr.event-manager
    		<Directory "C:/xampp/htdocs/event-manager/public">
        		Options All
        		AllowOverride All
        		Order Allow,Deny
        		Allow from all
    		</Directory>
		</VirtualHost>
		```
	- Modify `host` file.
	
		Open `C:/Windows/System32/drivers/etc/hosts` and add the following,
		
		```
		127.0.0.1	 aptsr.event-manager
		```
		Note: **You need to have administrative access to edit this file.**
		Then restart your webserver&apos;s apache.

8. Run `composer install` to install needed dependencies.
9. Run `npm install` to install Node dependencies.
9. Run `composer dumpautoload` regenerate auto file.

11. Finally, visit this URL in your browser `http://event-manager/` to test if the installation is successful.
12. You can use these users to login `user_one/12341234` or `user_two/12341234`.