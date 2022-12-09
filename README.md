## Table of Contents

-   [Introduction](#introduction)
-   [Prerequisites](#prerequisites)
-   [Tech Stack](#tech-stack)
-   [Getting started](#getting-started)
-   [Development](#development)
-   [Deployment](#deployment)
-   [Resources](#resources)

## Introduction

The Movie-Quote-Upgraded is a website, where for each you can see and post movies and quotes and react to them.
This is backend. [getting started](#getting-started).

<p align="center">
  <img src="public/assets/Screenshot from 2022-12-09 18-52-00.png" width="350" title="hover text">
</p>
<p align="center">
  <img src="public/assets/Screenshot from 2022-12-09 18-52-20.png" width="350" title="hover text">
</p>

## Prerequisites

-   PHP@8.1.9 and up
-   MYSQL@8 and up
-   npm@6.14.17 and up
-   composer@2.4 and up

## Tech Stack

-   [Laravel@9.x](https://laravel.com/docs/9.x) - back-end framework
-   [tailwindcss](https://tailwindcss.com/docs/installation) - front-end

## Getting started

1\. First, you need to clone movie-quotes-upgraded from github:

```sh
git clone https://github.com/RedberryInternship/lasha-muzashvili-epic-movie-quotes-back.git
```

```sh
cd lasha-muzashvili-epic-movie-quotes-back/
```

2\. Next step requires you to run _composer install_ in order to install all the dependencies.

```sh
composer install
```

3\. after you have installed all the PHP dependencies, it's time to install all the JS dependencies:

```sh
npm install
```

Then you need to add storage to public link:

```sh
php artisan storage:link
```

4\. Now we need to set our env file. Go to the root of your project and execute this command.

```sh
cp .env.example .env
```

And now you should provide **.env** file all the necessary environment variables.

after setting up **.env** file, execute:

```sh
php artisan config:cache
```

in order to cache environment variables.

```sh
php artisan migrate
```

4\. Now execute in the root of your project following:

```sh
  php artisan key:generate
```

Which generates auth key.

##### Now, you should be good to go!

## Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

Now if you finished setting up both, front and backend, you can log in and add new movies and quotes.

## Resources

-   [drawSQL Diagram]()
-   [design](https://www.figma.com/file/5uMXCg3itJwpzh9cVIK3hA/Movie-Quotes-Bootcamp-assignment?node-id=335%3A24052&t=0tXCamJUwZXQIabA-0)
