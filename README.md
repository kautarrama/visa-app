```markdown
# Applicant Management System

## About

This project is a simple Applicant Management System built with Symfony 6.4. It allows users to create, view, edit, and delete applicant information.

## Features

- **List Applicants**: View a list of all applicants.
- **Create New Applicant**: Add a new applicant to the system.
- **Edit Applicant**: Update the details of an existing applicant.
- **Delete Applicant**: Remove an applicant from the system.
- **Default Homepage**: The applicants list is set as the default homepage.

## Installation

To get started with this project, clone the repository and install the dependencies:

```bash
git clone [https://github.com/kautarrama/visa-app.git]
cd your-project-directory
composer install
```

## Usage

To run the Symfony server, use the following command:

```bash
symfony server:start
```

Navigate to `http://localhost:8000/` in your web browser to view the application.

## Configuration

Make sure to configure your `.env` file with the appropriate database settings:

```env
# .env
DATABASE_URL="localdatabase"
```

Run migrations to set up your database schema:

```bash
php bin/console doctrine:migrations:migrate
```

## Contributing

Contributions are welcome! Please feel free to submit a pull request.

## License

This project is licensed under the MIT License - see the LICENSE.md file for details.
