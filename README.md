<p align="center"><a href="https://technobase.krd" target="_blank"><img src="public/img/technobase_logo.png" width="400" alt="TechnoBase Logo"></a></p>


# Laravel New Structure Project

This is a Laravel project with a custom design and structure, incorporating the Limitless Admin Template version 4. The project aims to provide a fully functional web application with a visually appealing and user-friendly interface.


## Features
The project follows a structured Laravel framework design combined with the customizations for the Limitless Admin Template. Here's an overview of the project's structure:

- Custom Design: The project utilizes a unique and custom design that sets it apart from the default Laravel appearance. The design is tailored to enhance the user experience and ensure a visually appealing interface.

- Limitless Admin Template v4: The project integrates the Limitless Admin Template version 4, a powerful and feature-rich admin template. This template offers a wide range of UI components, responsive layouts, and pre-built pages, providing flexibility and versatility for building various application modules.

- Full Functionality: The project is designed to deliver comprehensive functionality, encompassing key aspects of a web application. This includes user management, authentication and authorization, data management, CRUD operations, reporting, and more. The aim is to provide a robust foundation for building an application that meets your specific needs.

## Project Structure

The project follows a structured Laravel framework design combined with the customizations for the Limitless Admin Template. Here's an overview of the project's structure:

- **app**: This directory contains the core application logic, including controllers, models, and other PHP classes.

- **config**: Configuration files for the application, such as database settings, service providers, and application-specific settings.

- **database**: Contains database-related files, including migrations, seeders, and factories.

- **public**: The public directory contains the entry point to your application, along with assets such as CSS, JavaScript, and uploaded files.

- **resources**: This directory holds views, front-end assets, language files, and other resource-related files.

- **routes**: Contains route definitions for your application, mapping URLs to controller actions.

- **tests**: Directory for your application's test files.

- **vendor**: This directory contains the Composer dependencies for your project.

- **public/global_assets**: Customizations and assets specific to the Limitless Admin Template. This directory includes template-specific CSS, JavaScript, and other resources.
- **public/assets**: Customizations and assets specific to the Limitless Admin Template. This directory includes template-specific CSS, and other resources.



## Installation

1. Clone the project repository.
2. Ensure that Composer is installed on your system
3. Make sure you have Composer installed on your system. If not, download and install it from [https://getcomposer.org/](https://getcomposer.org/).

4. Navigate to the project's root directory in your terminal.

5. Run the following command to install the project dependencies:
   ```bash
   composer install
    ```

6. Copy the `.env.example` file and rename it to `.env`. You can do this by running the following command in your terminal:
   ```bash
   cp .env.example .env
   ```
7. Open the .env file and update the configuration values as required.

8. Generate an application key by running the following command in your terminal:
   ```bash
   php artisan key:generate
   ```
9. Run the following command to migrate the database tables:
   ```bash
   php artisan migrate
   ```
10. Run the following command to seed the database with the default data:
   ```bash
    php artisan db:seed
   ```
11. Run Serve the application locally
   ```bash
    php artisan serve
   ```
12. Open your browser and access the application URL. If you followed the installation steps correctly, you should see the application's home page. example (*http://localhost:8000*)

## Customization
To customize the application further, you can modify the templates, stylesheets, and JavaScript files located in the resources directory. Additionally, the Limitless Admin
