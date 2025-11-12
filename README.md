# Payroll System

A Symfony application that calculates employee payday and payment dates based on the business rule: **Payday is the second-to-last day of the month, adjusted to Friday if it falls on a weekend**.

## Requirements

- Docker
- Docker Compose

## Quick Start

### With Docker (Recommended)

```bash
# Start the application
make up

# Run tests
make test

# Stop the application
make down
```

### Without Docker (Using Symfony CLI)

```bash
# Install dependencies
composer install

# Install assets
php bin/console importmap:install

# Start the server
symfony server:start

# Run tests (in another terminal)
php bin/phpunit
```

The application will be available at **http://localhost:8000**

## API Endpoint

**API Documentation (Swagger):** http://localhost:8000/api

### Calculate Payroll Dates

**POST** `/api/payrolls`

**Request Body:**

```json
{
    "month": 11,
    "year": 2025
}
```

**Response (201 Created):**

```json
{
    "payday": "2025-11-28T23:59:59+00:00",
    "makePaymentDay": "2025-11-24T23:59:59+00:00"
}
```

**Example:**

```bash
curl -X POST http://localhost:8000/api/payrolls \
  -H "Content-Type: application/json" \
  -d '{"month": 11, "year": 2025}'
```

## Frontend

Visit **http://localhost:8000** in your browser to use the web interface:

1. Select a month from the dropdown
2. Select a year from the dropdown
3. Click "Calculate Payday"
4. View the calculated payday and payment day

The frontend calls the API endpoint via JavaScript to display the results.

## Running Tests

```bash
make test
```

This runs the full test suite including:

- API endpoint validation tests
- Business logic tests (payday calculation)
- Edge case tests (weekend adjustments)

## Business Rules

### Payday Calculation

- Payday is the **second-to-last day of the month**
- If this date falls on a **Saturday**, payday is moved to **Friday**
- If this date falls on a **Sunday**, payday is moved to **Friday**

### Payment Day Calculation

- Payment day is **4 working days before payday**
- Weekends are excluded when counting working days

### Examples

| Month    | Last Day | Second-to-Last | Payday (Adjusted) | Payment Day |
| -------- | -------- | -------------- | ----------------- | ----------- |
| Nov 2025 | 30 (Sun) | 29 (Sat)       | 28 (Fri)          | 24 (Mon)    |
| Dec 2025 | 31 (Wed) | 30 (Tue)       | 30 (Tue)          | 24 (Wed)    |
| Jan 2025 | 31 (Fri) | 30 (Thu)       | 30 (Thu)          | 24 (Fri)    |

## Development Environment

The application runs in Docker containers:

- **App Container**: PHP 8.4 with Symfony
- **Database Container**: PostgreSQL 16 (for API Platform requirements)

All dependencies are installed automatically when you run `make up`.

## Project Structure

```
payroll-system/
├── src/
│   ├── Controller/       # UI and API controllers
│   ├── Dto/             # Data Transfer Objects
│   └── Form/            # Symfony Forms
├── templates/           # Twig templates (Frontend)
├── tests/               # PHPUnit tests
├── docker-compose.yaml  # Docker services
├── Dockerfile          # Container image
└── Makefile            # Commands
```

## Technologies

- PHP 8.4
- Symfony 7.3
- API Platform 4
- Carbon (date manipulation)
- PHPUnit (testing)
- Bootstrap 5 (UI)
- PostgreSQL 16
- Docker
