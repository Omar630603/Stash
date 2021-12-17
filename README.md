<p align="center"><a href="http://168.138.102.54/" target="_blank"><img src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/Logo%20with%20Name%20H.png?raw=true" width="400"></a></p>

<p align="center">Click on the logo to access the website</p>

## Stash:

Stash is a web-based project for a self-storage company. The web app is desiged to have three users

-   Branches of the company.
-   Customers.
-   Drivers who work in delivery for a given branch.

These users have different roles based on their needs. Customers can order Storage units and ask for delivery in a given branch. The branch later receives the order and approves it or disapproves it and many other features like making orders and deliveries and configuring them. The Drivers can see their schedules and work base on them.

## How to use Stash:

Accessing the web app can be done by clicking on the logo or cloning this repository and continue with the following commands.

-   After it has been cloned, copy .env.example into .env and configure it to your needs.
-   Install composer "composer install".
-   Generate key "php artisan key:generate".
-   Make a database based on the database name in the.env file.
-   Finally, run migrations "php artisan migrate:fresh --seed" and serve "php artisan serve" and that's after the local server and service are running like Apache and MySQL.

There are some entry data that can be used to see how it all works, this data can be seen in the seeder file. These data will go into the database once the command "php artisan migrate:fresh --seed" is launched. In order to prevent that, just simply remove the word "--seed".

## Development Team:

This project is the result of a college assignment and made by the following students:

<table style="border-collapse:separate;
		border-spacing:8px;
		padding:1px;
        border-radius: 5px;">
	<caption>TEAM</caption>
	<thead>
	<tr>
		<th>NAME</th>
        <th>GITHUB & NIM</th>
		<th>ROLE</th>
		<th>IMAGE</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>Omar Abdul-Raoof Taha Galleb Al-Maktary</td>
		<td><a href="https://github.com/Omar630603">@Omar630603</a>
            <br>1941720237
        </td>
		<td>Back-End<br> 
            Front-End<br>
            Data Analysis<br>  
            Deployment<br> 
            Design<br>
            Documentation<br>
            Project Manger
        </td>
        <td>
        <img style="border-radius: 100%;
        border: 3px solid #F89F5B;" src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/omar.jpeg?raw=true" width="200"></td>
	</tr>
	<tr>
		<td>M. Alif Ananda</td>
		<td><a href="https://github.com/ExplodedRiot">@ExplodedRiot</a>
            <br>1941720078
        </td>
		<td>
            Front-End<br>
            Design<br>
            Documentation
        </td>
        <td>
        <img style="border-radius: 100%;
        border: 3px solid #F89F5B;" src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/alif.jpeg?raw=true" width="200"></td>
	</tr>
	<tr>
		<td>De Roger Baggio B.</td>
		<td><a href="https://github.com/baggio18-droid">@baggio18-droid</a>
            <br>1941720238
        </td>
		<td>Data Analysis
            <br>Documentation
        </td>
        <td>
        <img style="border-radius: 100%;
        border: 3px solid #F89F5B;" src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/baggio.jpeg?raw=true" width="200"></td>
	</tr>
	<tr>
		<td>Rizki Irfan Maulana</td>
		<td><a href="https://github.com/venztt">@venztt</a>
            <br>1941720093
        </td>
		<td>Front-End<br>
            Documentation
        </td>
        <td>
        <img style="border-radius: 100%;
        border: 3px solid #F89F5B;" src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/rizki.jpeg?raw=true" width="200"></td>
	</tr>
	<tr>
		<td>Radithya Iqbal Prasaja</td>
		<td><a href="https://github.com/RadithyaIP">@RadithyaIP</a>
            <br>1941720072
        </td>
		<td>Front-End<br>
            Documentation<br>
        </td>
        <td>
        <img style="border-radius: 100%;
        border: 3px solid #F89F5B;" src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/radit.jpg?raw=true" width="200"></td>
	</tr>
	<tr>
		<td>Lelyta Salsabila</td>
		<td><a href="https://github.com/lelyta30">@lelyta30</a>
            <br>1941720026
        </td>
		<td>Documentation
        </td>
        <td>
        <img style="border-radius: 100%;
        border: 3px solid #F89F5B;" src="https://github.com/Omar630603/Stash/blob/main/storage/app/public/images/lely.jpeg?raw=true" width="200"></td>
	</tr>
	<tbody>
</table>
<p class="font-italic text-muted mb-0">&copy; Copyrights STASH. All rights reserved.</p>
<div style="height: 40px"></div>

## This Webapp is Using:

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Cubet Techno Labs](https://cubettech.com)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[Many](https://www.many.co.uk)**
-   **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
-   **[DevSquad](https://devsquad.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[OP.GG](https://op.gg)**
-   **[CMS Max](https://www.cmsmax.com/)**
-   **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
