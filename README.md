# Try Catch

A self-hostable error & log tracking platform — a Laravel backend with a
dashboard for ingesting, browsing, and triaging errors from all your projects in one place.

Your apps ship errors to a per-project endpoint over a simple HTTP API; the dashboard surfaces them
by severity (`debug` -> `fatal`) with project, message, stack trace, device, and version metadata.

> **Flutter package:** A companion Flutter package makes integration a one-liner from your mobile
> apps — it captures exceptions and forwards them to your Try Catch instance automatically.
> **[github.com/anjumArnab/Try_Catch](https://github.com/anjumArnab/Try_Catch)**


## Features

- **Projects & API keys** — create a project to get a unique ingest endpoint and a secret API key
  (regenerate any time). Keys are stored encrypted at rest.
- **Log ingestion API** — a single `POST` endpoint per project, protected by API key and rate-limited.
- **Severity levels** — `debug`, `info`, `warning`, `error`, `fatal`, color-coded throughout the UI.
- **Dashboard** — project count, total errors logged, and a recent-errors feed.
- **Rich error detail** — message, stack trace, error type, device model, OS / Flutter / app version,
  custom payload, and client timestamp.
- **Auth** — email/password (via Laravel Breeze) and Google OAuth (via Socialite).

## Tech stack

- **Laravel 13** / **PHP 8.3**
- **MongoDB** (`mongodb/laravel-mongodb`)
- **Laravel Breeze** — Blade + Alpine.js + Tailwind CSS v3
- **Laravel Socialite** — Google OAuth
- **Vite** for asset bundling


## Getting started

### Prerequisites

- PHP 8.3+ with the [MongoDB PHP extension](https://www.php.net/manual/en/mongodb.installation.php)
- Composer
- Node.js & npm
- A MongoDB instance (local, or a free [MongoDB Atlas](https://www.mongodb.com/atlas) cluster)

### Installation

```bash
git clone <this-repo>
cd try-catch

# Install dependencies, copy env, generate key, build assets
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

Configure your database and (optionally) Google OAuth in `.env`:

```env
APP_NAME="Try Catch"

DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=try_catch
DB_USERNAME=
DB_PASSWORD=

# Max log ingests per minute, per project (defaults to 60)
LOG_INGEST_RATE_LIMIT=60

# Optional: Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

> Using MongoDB Atlas? Use the `mongodb+srv://` connection string for your host/credentials.

### Run it

```bash
composer dev
```

This starts the PHP server, queue worker, log tailer, and Vite together. The app is at
`http://127.0.0.1:8000`. Register an account from the landing page to get started.


## Sending errors (ingestion API)

Each project exposes one endpoint. After creating a project in the dashboard you'll have an
**endpoint slug** (e.g. `mobile-app-ab3kd`) and an **API key**.

```
POST /api/{endpoint}/log-error
```

**Authentication** — send the project's API key as either header:

```
X-Api-Key: <your-api-key>
# or
Authorization: Bearer <your-api-key>
```

**Rate limiting** — capped per project at `LOG_INGEST_RATE_LIMIT` requests/minute (default 60).

### Request body

| Field            | Type     | Required | Notes                                                        |
|------------------|----------|----------|--------------------------------------------------------------|
| `message`        | string   | YES       | max 10,000 chars                                             |
| `severity_level` | string   |          | one of `debug`, `info`, `warning`, `error`, `fatal` (default `error`) |
| `stack_trace`    | string   |          | max 50,000 chars                                             |
| `error_type`     | string   |          | e.g. `NullPointerException`                                  |
| `device_model`   | string   |          |                                                              |
| `os_version`     | string   |          |                                                              |
| `flutter_version`| string   |          |                                                              |
| `app_version`    | string   |          |                                                              |
| `custom_payload` | object   |          | any extra JSON metadata                                      |
| `timestamp`      | datetime |          | client-side time of the error                               |

### Example

```bash
curl -X POST https://your-host/api/mobile-app-ab3kd/log-error \
  -H "X-Api-Key: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "message": "RangeError: index out of bounds",
    "severity_level": "fatal",
    "error_type": "RangeError",
    "stack_trace": "#0 ...",
    "app_version": "1.4.2",
    "flutter_version": "3.24.0",
    "device_model": "Pixel 8",
    "os_version": "Android 15"
  }'
```

**Responses**

```jsonc
// 201 Created
{ "status": "ok", "error_id": "65f..." }

// 401 Unauthorized — missing/invalid API key
{ "status": "error", "message": "Invalid API key." }

// 404 Not Found — unknown endpoint slug
{ "status": "error", "message": "Unknown endpoint." }
```

### From Flutter

Rather than calling the API by hand, drop in the official package — it wires up global exception
handling and ships errors to your endpoint for you: **[github.com/anjumArnab/Try_Catch](https://github.com/anjumArnab/Try_Catch)**

## License

Open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
