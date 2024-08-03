```markdown
# URL Shortening Service

This project is a URL shortening service built with Laravel. It provides two main endpoints: one to encode a long URL into a shortened URL and another to decode a shortened URL back to its original form.

## Features

- Encode a long URL into a short URL.
- Decode a short URL back to its original long URL.
- In-memory storage using cache for URL mappings.
- Implementation follows the SOLID principles and uses Repository and Service patterns.
- Unit and Feature tests for all functionalities.

## Requirements

- PHP 7.4 or higher
- Composer
- Laravel 8 or higher

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/url-shortening-service.git
cd url-shortening-service
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Set Up Environment Variables

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```



### 4. Run the Migrations (if using a database)

If you decide to use a database instead of cache, you can run migrations:

```bash
php artisan migrate
```

## Usage

### Run the Development Server

```bash
php artisan serve
```

The application will be accessible at `http://localhost:8000`.

### API Endpoints

#### 1. Encode URL

**Endpoint:** `POST /api/encode`

**Request Body:**

```json
{
    "url": "https://www.thisisalongdomain.com/with/some/parameters?and=here_too"
}
```

**Response:**

```json
{
    "short_url": "http://localhost:8000/shortKey"
}
```

#### 2. Decode URL

**Endpoint:** `POST /api/decode`

**Request Body:**

```json
{
    "short_url": "shortKey"
}
```

**Response:**

```json
{
    "url": "https://www.thisisalongdomain.com/with/some/parameters?and=here_too"
}
```

## Running Tests

### 1. Unit and Feature Tests

Run the tests using PHPUnit:

```bash
php artisan test
```

## Project Structure

- **app/Http/Controllers/API/UrlShortenerController.php:** Handles API requests.
- **app/Http/Requests/EncodeUrlRequest.php:** Handles validation for encoding URLs.
- **app/Http/Requests/DecodeUrlRequest.php:** Handles validation for decoding URLs.
- **app/Repositories/UrlShortenerRepositoryInterface.php:** Interface for URL repository.
- **app/Repositories/UrlShortenerRepository.php:** Implementation of the URL repository using cache.
- **app/Services/UrlShortenerService.php:** Service layer for encoding and decoding URLs.
- **tests/Feature/UrlShortenerTest.php:** Feature tests for the URL shortening service.

