# VT Documentation

This repository contains the documentation for the Comptan Interview Task, which involves creating authentication, importing CSV records into the database, reading data from an API, handling exceptions, and creating jobs to email all active users.

## Prerequisites

Before running the application, make sure to set up the following configurations in the `.env` file located in the `Comptan-Interview-Task` folder:

### Database Configuration:
```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
```

### Mail Configuration:
```plaintext
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=********
MAIL_PASSWORD=********
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 1. Create Authentication for Admins and Users

To access the login pages, use the following dedicated URLs:

- Admin login: `/admin`
- User login: `/`

The home routes are authorized by a custom middleware called `auth`. Ensure that this middleware is registered under the same name in `app/http/kernel.php`.

### Database
Separate database tables exist for admins (columns: id, email, username, and password) and users (columns: id, email, username, password, is_active).

### Middleware Authorization

After authentication in `AuthController` - `auth` method, a session variable (`role`) is set for:

- Users: Login route `/`, role=user
- If any request is made to the `/home` route, and the `role` session variable doesn't exist or its value is not `user`, the user will be automatically redirected to `/` for login.

- Admins: Login route `/admin`, role=admin
- If any request is made to the `/admin_home` route, and the `role` session variable doesn't exist or its value is not `admin`, the user will be automatically redirected to `/` for login.

### LOGIN
1. Checks if the request to login is from a User or an Admin.
2. Validates user credentials with the user table and redirects to `/home`.
3. Or validates Admin credentials with the Admin table and redirects to `/admin_home`.

Both users and admins can log in using their username and password or email and password.

## 2. Import CSV Records into the Database

The dedicated URL for this service is `/home`, accessible only to authorized users.

### `/home` route:
- Supports the `GET` method, allowing users to select a CSV file and submit it. Only CSV files are allowed for submission.

### `/csvupload` route:
- Supports the `POST` method.
- The system checks if the request contains a valid CSV file.
- The CSV file is converted to an array.
- The data is chunked into 300 records to be processed in batches by the Csv Processor Job.
- Each chunk is inserted into the database.
- Each record must have a unique identifier (e.g., ID, record_id).
- The required CSV columns are as follows:
  - Identifier (ID, record_id, etc.)
  - Name
  - Email
  - Phone
  - Address

## 3. Read Data from an API and Populate the Database

The dedicated URL for this service is `/read-dfa`. It only accepts JSON data. In case of a failed request, users will be redirected to a 404 error page, and an email will be sent to `tech@email.com`.

- Each record from the API is unique and stored in the entry table using the EntryProcessor Job.

## 4. Exception Handling

- If a page doesn't exist, users will be redirected to a 404 error page.
- In case of any fatal error, users will be routed to a 404 error page.
- In case of an exception, an email will be sent to `tech@email.com`.

## 5. Create Jobs to Email All Active Users

An email will be sent to every user whose `is_active` value is 1 in the user database table using a Mailer Job located in `Mailer.php` within the `App/Jobs` folder.

URL: `/mailer` (GET) - Returns a view to enter the subject and body, then submits the data to the `/mailer` route (POST).
