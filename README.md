## Practical Exam
Mortgage loan calculator web application using Laravel 10 and php8.3 with docker.

## Getting started
##### Clone repository
* ``git clone https://github.com/vilsonisaku/parctical-exam.git``
##### Start containers
* ``make start``

##### Install dependencies
* ``make composer-install``

##### Apply configured .env
* ``make apply-env``

##### Run Migrations and Seeders
* `` make migrate ``
* `` make db-seed ``

##### Run laravel 

* `` make serve ``

Open url in your host:
http://localhost:8080/

#### Run Unit Testing
* `` make test ``

To ssh into app container run: ```make ssh```