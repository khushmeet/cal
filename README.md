# API ENV SETUP
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/b98d6077faacf5521fba)

# Db dump and setup
* Dump Folder : db
* Setup : update .env with your mysql user pwd

 database.default.hostname = _YOUR_HOST_ <br>
 database.default.database = _YOUR_DB_NAME_ <br>
 database.default.username = _YOUR_DB_USERNAME_ <br>
 database.default.password = _YOUR_DB_PASSWORD_ <br>
 database.default.DBDriver = MySQLi  


## Summary

The idea of the app is that a user can register/login to the App and is able to create new notes and to update/delete previous ToDos. ToDos themselves are simple entity which has a title, description and timestamps.

**All routes are defined in app/Config/Routes**

## Frontend

### Design Choices
All controllers extend BaseController.

* Login screen : <br>
only accessible to guest users<br>
Once user is validated creates jwt and logged them in

* Register screen : <br>
accessible to guest users<br>


* ToDo list
 Display tasks 
 Add/delete/ edit tasks


## Directory Structure
```
| Directory               | Purpose                                     |
|:-----------------------:|:-------------------------------------------:|
| App\Controllers         | handles frontend request                    |
| App\view                | respond with the corresponding view         |
| public\assets\css       | contain entire frontend application styling |                        
| public\assets\css       | Contain entire frontend application styling |            
```

## Backend
### Design Choices
All controllers extend BaseAPIController.

#### Brief logic overview:

* Ensure the JSON Web Token is present and valid.
* Run a validation check.
* Convert response to an array.
* Display converted response to user.

## Namespace Breakdown
```
| Namespace               | Purpose                                     |
|:-----------------------:|:-------------------------------------------:|
| App\Controllers\API     | Assist with API endpints                    |
| App\Controllers\API     | Assist with API endpints                    |
| App\Models              | Assist with db operation                    |
| App\Traits              | Contain small repetative logic              |              
| App\Helpers             | Contain small repetative logic              |            
```


## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/contributing.md) section in the development repository.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
