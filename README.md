Clone the repository into your local machine.

Open terminal and run composer install and npm install.

Fist create a database with any name into your system.

Create a new file ".env" into the root of the project folder.

From root of the project folder copy contents of .env.example into the newly created .env file.

Replace DB_DATABASE in the .env file with your newly created database name and then DB_USERNAME, DB_PASSWORD with your respective database credentials.

To run migration:-
    Run php artisan migrate from root of the project directory or visit:- http://127.0.0.1:8000/artisan-migrate in the browser
To seed database with fake data:-
    Run php artisan db:seed from root of the project directory or visit:- http://127.0.0.1:8000/artisan-db-seed in the browser
To seed only admin user with fake data:-
    Run php artisan db:seed --class=AdminSeeder from root of the project directory or visit:- http://127.0.0.1:8000/artisan-admin-seed in the browser. The admin table will be seeded with fake emails with 2 data and the password is "password" for all.

Now From root of your project folder open a terminal and than run "php artisan serve" and then in the browser visit:- http://127.0.0.1:8000/

To check mails 
    Replace MAIL_FROM_ADDRESS in the .env file with your email e.g admin@admin.com
    Than create an account for mailtrap https://mailtrap.io/signin and than after you signIn check for your SMTP username and password, replace these settings in your .env file MAIL_USERNAME and MAIL_PASSWORD.
    Now from your root directory run "php artisan command:check_product_stock" this will send a mail with products that have low quantity to the mailtrap inbox.
    
   ** Refer to this article if trouble setting up mailtrap account **
   https://medium.com/@christianjombo/setting-up-mailtrap-for-laravel-development-313133bb800c#:~:text=You%20can%20get%20your%20Mailtrap,is%20beside%20your%20Mailtrap%20inbox.&text=In%20the%20resulting%20page%2C%20copy,and%20add%20them%20to%20your%20.
 
    
    
