# ERP API

![ERP LOGO](https://pi.tv/images/factory/companies/200/200/3556_tegraglobal.jpg)

This project aims to be a solution to the management of orders received by customers, through EDI, Json or API Rest to our ERP System.

It is a tool for the planning department to be able to filter the orders that are going to be accepted or rejected.

## Installing the development environment

### Requirements
  * [Docker](https://www.docker.com/)
  * [Git](https://git-scm.com/)

### Steps

  * Clone the repository, and open **erp-api** directory
    ```sh
    $ git clone https://github.com/danieldczreload/erp-api.git
    $ cd erp-api
    ```
  * Rename **/.env-example** and **/docker/.env-example** to **.env**
  
  * Setting **/.env** file
    Change the Database variables, set **DB_CONNECTION=mysql** 
    and set the the other databases variables.
      ```.env
        DB_CONNECTION=mysql
        DB_DATABASE=erp_db
        DB_USERNAME=erp_user
        DB_PASSWORD=erp_password
    ```

 * Setting **/docker/.env** file
    Change the Database variables according to the values you set in **/.env**
    and provid a root password
      ```.env
        MYSQL_DATABASE=erp_db
        MYSQL_USER=erp_user
        MYSQL_PASSWORD=erp_password
        MYSQL_ROOT_PASSWORD=root_password
    ```

  * Build the image
    * Open a console
    * Navigate to **erp-api/docker**
    * Run **docker-compose up** command
    
  * Visit **http://localhost** and **login** with the credentials in the end of the **/.env** file
    ```.env
        EMAIL_ADMIN_SEEDER = "admin@mail.com"
        PASS_ADMIN_SEEDER = "12345678"
    ```


### Techs

ERP API use the followings technologies:

* [PHP 7+](https://www.php.net/)
* [JavaScript](https://www.javascript.com/)
* [Laravel](https://laravel.com/)
* [Docker](https://www.docker.com/)
* [Bootstrap](https://getbootstrap.com/)
* [Xdebug](https://xdebug.org/)
* [Apache](https://www.apache.org/)
* [Composer](https://getcomposer.org/)
* [SweetAlert](https://sweetalert.js.org/)
* [JSON Schema](https://json-schema.org/)
* [Power Automate](https://flow.microsoft.com/)



License
----
MIT
