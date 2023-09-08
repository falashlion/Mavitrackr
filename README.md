
# Title / Repository Name
* MAVITRACKr
* https://bitbucket.org/moocafrica/kpi/src/master/
## About / Synopsis

* This is the backend design for the MAVITRACKr application builed to facilitate effective performance management within Maviance
* Project status: Version 1.0.0/project MVP
## Table of contents

> * [Title / Repository Name](#title--repository-name)
>   * [About / Synopsis](#about--synopsis)
>   * [Table of contents](#table-of-contents)
>   * [Installation](#installation)
>   * [Usage](#usage)
>     * [Screenshots](#screenshots)
>     * [Features](#features)
>   * [Code](#code)
>     * [Content](#content)
>     * [Requirements](#requirements)
>     * [Build](#build)
>     * [Deploy (how to install build product)](#deploy-how-to-install-build-product)
>   * [Resources (Documentation and other links)](#resources-documentation-and-other-links)
>   * [Contributing / Reporting issues](#contributing--reporting-issues)
>   * [License](#license)
>   * [About Nuxeo](#about-nuxeo)

## Installation

* The following are required
* Docker installed
* PHP 8.2.0 and above
* Laravel 10.0
* Composer
* Mysql 8.0
## Usage
* Apis are used in the integration with a frontend to perform performance management for empleyees within a company.
### Screenshots

### Features
* User creation and manipulation of user information.
* creation of SMART  goals and all its related components.
* Goal scoring and viewing.
## Code

> *[Build Status](https://bitbucket.org/moocafrica/kpi/src/master/)

### Content

Description, sub-modules organization...

### Requirements


### Build
* clone the project repository (https://bitbucket.org/moocafrica/kpi/src/master/)
* get into root directory of the kpi folder that was just created in your local machine
* open a terminal in this root directory and run the command ./vendor/bin/sail up.
* accept all propmts for the installation and wwait for the project to download completely 
* When its fully installed run the command docker-compose up to start the project containers
* Run the command php artisan serve  and accept the prompt to create the database.
* Run php artisan db:seed to seed the database with the required data to start using the application.



Build options:

* ...

### Deploy (how to install build product)

* Follow the build commands above

## Resources (Documentation and other links)

## Contributing / Reporting issues

Link to JIRA component (or project if there is no component for that project). Samples:

* [Link to component]
* [Link to project]

## License


