# Express

Restaurant Online Ordering Made Simple

## About

This project is written primarily in PHP for the server-side code. The front-end code is written in HTML, CSS, and JS. The CSS library used is Bootstrap, which give this project a nice look. No other theming was used besides vanilla Bootstrap 4.

The main purpose of this project is to allow a customer to order from a restaurant online and pickup their order in store. This project could be adapted for delivery services as well but that functionality is not currently impletemented.

In addition to the online ordering mechanism, there is an area where employees can login to accept orders (`employee.php`) and an area where managers can login to manage the system and employees' orders (`login.php`).

## Installation

#### SQL Database

Import the `database.sql ` file found in the root of this repo into your SQL server using a tool like phpMyAdmin or Sequel Pro. You then need to edit the `database.ini` file to reflect your database setup (database location, username, password, database name). In addition to this, you may have to edit several `.php` files to reflect the location of your `database.ini` file. For the sake of security, you should place the ```database.ini``` below the root of your web server so that the file is not publically accessible and not potentially exposing your SQL login details.

#### Server Files

All you need to do is upload the contents of the `server` folder to the root folder of your web server, and upload the `database.ini` file at least one folder below that or wherever you like so long as you edit the certain `.php` files that load from that file.

#### Configuring the Installation

##### Installation Info

You will want to configure your site by editing the first row in the `config` table of your database you just installed as follows:

| id              | 1                                                            |
| --------------- | ------------------------------------------------------------ |
| business_name   | Your business name                                           |
| business_slogan | Your business slogan                                         |
| theme_color     | Website theme (Ex: dark)                                     |
| order_time      | Time to prepare order in minutes (Ex: 15)                    |
| logo_enabled    | no (you can upload a logo in the admin panel)                |
| logo_width      | NULL                                                         |
| logo_height     | NULL                                                         |
| pos_enabled     | no (currently an unused variable that may be used in the future for a Point-of-Sale system) |
| express_enabled | yes (enables the online store)                               |
| email_address   | Admin email address                                          |
| currency        | Your currency (Ex: USD)                                      |

You will also need to edit the `hours` table with your business hours. The hour format required is `00:00` in military time. For the days closed, you can simply put a Yes or No in the cell. After this is completed you can edit the hours in the admin panel.

##### Admin Account

You will want to setup an admin account to manage data without using a tool like phpMyAdmin. To do this, create an entry in the `logins` table with the following information: an email, a bcrypt encrypted password (you can create one [here](https://php-password-hash-online-tool.herokuapp.com/password_hash)), a name, admin access (Yes or No), and permanent account (yes or no). The permanent flag makes it not possible to delete that account from the admin panel. Now you can login at `login.php`.

##### Usage

To use the site, have customers go to the root of your web server. This should automatically redirect them to the home page.

## License

This software is licensed under the MIT license and is available in LICENSE.md.