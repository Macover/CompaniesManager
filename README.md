# Introduction

The CompaniesManager is a simple web application that is designed to control and organize companies. It allows users to see, create, edit and delete companies as well as its employees.

# Components
The application consists of the following main components:
Name	Email	Logo	Website
- Models:

	- Company: represents a company in the application and includes fields for storing information such as the company name, email, logo, and website.
	
	- Employee: represents an employee and includes fields for storing information such as the employee's first Name, last name, the company he belongs to, email and his phone number.

- Controllers:

	- CompaniesController: responsible for handling requests related to creating, editing, deleting and viewing companies.
	- EmployeesController: responsible for handling requests related to creating, editing, deleting and viewing employees.

# Architecture

The application is built on the Laravel framework and uses a MySQL database to store data. It communicates with the database using Eloquent, Laravel's ORM (Object-Relational Mapper).


# User Interface

The application has a clean and intuitive user interface, designed to make it easy for users to navigate and find the information they need.

![image](https://user-images.githubusercontent.com/61953764/209026463-a3838f8c-701b-4c73-8502-61a98a78a4c1.png)



# Installation and Setup


To install the Company Management application, follow these steps:

1. Clone the repository to your server:
	
    	git clone https://github.com/Macover/CompaniesManager.git
	

2. Navigate to the project directory:
	
    	cd CompaniesManager 
	
 
3. Install the dependencies:
	
    	composer install
	

4. Set up the database connection by copying the `.env.example` file to a new file called `.env` and updating the `DB_*` variables with your MySQL connection details.
5. Run the database migrations (you should use :fresh and --seed flag to run seeders as well):

	
    	php artisan migrate
	

6. Set up your web server to serve the application.

## Usage

To use the Companies Manager application:

1. Log in with these credentials below.
	
    	email: admin@admin.com
    	password: password
	
2. From the main dashboard, you can navigate throught the navigation menu to see the different options that the interface has.
3. To create a new company, click on the "Create Company" button.
4. To edit an existing company, click on the company name in the list of companies.
5. To manage employees, click on the "Employees" link in the navigation menu. From here, you can create and edit employee, assign a company, and view a list of all the employees in the application.

## Live Demo.

To see how the application works, you can click on the following link:



    http://companies-manager-v1.herokuapp.com/

