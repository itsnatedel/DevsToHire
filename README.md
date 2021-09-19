# DevsToHire

DevsToHire is part of the work I've done in the context of my end of studies' project. 
It is aimed to be **a platform where freelancers and professionals meet and help each other**.

The goal of this website is to give the opportunity to :
* **Freelancers**
    * to improve their visibility online
    * to boost their reputation on the web
    * to give them the opportunity to earn money off their passions and hobbies
* **Companies**
    * to find new recruits
    * to get their tasks done
      
Most job and task offers present on the application will allow freelancers to **work at home**, as it has become a booming requirement in employment searches since the COVID pandemic.

## How to get started
<p align="center">
This project has been entirely made with the help of the <a href="https://laravel.com/" target="_blank">Laravel framework</a>
    
To get the project up and running, make sure to follow these steps :
1. Get the project on your machine
    * Download the project <a href="https://github.com/mvker/DevsToHire/archive/refs/heads/master.zip">here</a>
    * Or clone it with `git clone https://github.com/mvker/DevsToHire.git`
1. Open the downloaded folder in your terminal and run 
    * `php composer install`
    * **You might get an error where your terminal isn't able to find `composer`**
        * In case that happens, go to <a href="https://getcomposer.org/download/" target="_blank">Composer website</a> and run the script on the top of the page
        * When that's done, run `php composer.phar install`
1. Get the .env file ready
    * `cp .env.example .env`
1. Generate an encryption app key
    * `php artisan key:generate`
1. Configure the database
    * DB_USERNAME should be `root`
    * DB_PASSWORD should be `root`
    * DB_DATABASE should be `devstohire`
    * DB_PORT should be `3306`
    * DB_HOST should be `127.0.0.1` or `localhost`
1. Fill the Database with tables and a set of data
    * `php artisan migrate --seed`
    
**This should be it !** Make sure to run the local server by running `php artisan serve` and you should be good to go !
</p>

## Licenses

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

DevsToHire is an open-sourced application licensed under the [MIT license](https://opensource.org/licenses/MIT).
