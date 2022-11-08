# Adminpanel to manage companies

## Basically, project to manage companies and their employees. Mini-CRM.

1. Basic Laravel Auth: ability to log in as administrator

2. Use database seeds to create first user with email admin@admin.com and password "password"

3. CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.

4. Companies DB table consists of these fields: Name (required), email, logo (minimum 100x100), website
Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone

5. Use database migrations to create those schemas above

6. Store companies logos in storage/app/public folder and make them accessible from public

7. Use basic Laravel resource controllers with default methods - index, create, store etc.
Use Laravel's validation function, using Request classes

8. Use Laravel's pagination for showing Companies/Employees list, 10 entries per page

9. Use Laravel's starter kit for auth and basic theme, but remove ability to register
