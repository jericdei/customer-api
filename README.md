# Customer API

This is the backend API of the Customer CRUD Full Stack Application.

## Technologies Used

- Runtime: PHP 8.3
- Framework: Laravel 11
- Model Searching: Laravel Scout
- Testing: Pest

## Running Locally

This application has an already-configured Docker Compose setup.

### Requirements

- Docker & Docker Compose
- [Just](https://github.com/casey/just) (Optional)

#### 1. Configure permissions

Make sure you have the following environment variables on your system to ensure that your host user and the container user has the same UID and GID.

```bash
# ~/.bashrc or ~/.zshrc

...
export UID=$(id -u)
export GID=$(id -g)
```
Don't forget to source your `.bashrc` or `.zshrc` file after editing!

```bash
source ~/.zshrc
# or
source ~/.bashrc
```

#### 2. Create an external Docker Network
```bash
# You can name it whatever you want!
docker network create mynetwork
```

#### 3. Create `.env` by copying the `.env.example` file

```bash
cp .env.example .env
```

Make sure to populate the `DOCKER_EXTERNAL_NETWORK_NAME` on your `.env` file with your created network name
```bash
DOCKER_EXTERNAL_NETWORK_NAME=mynetwork
```

#### 4. Run the containers

If you have `just` installed on your system, you can just run the following command on your terminal:

```bash
just start
```

Otherwise:
```bash
docker compose up -d
```

This should build the containers without any errors and start the application in http://localhost:81.

#### 5. Setup Laravel

Install Dependencies
```bash
just composer install
```
or
```bash
docker compose exec app composer install
```

Generate your `APP_KEY`
```bash
just artisan key:generate
```

or

```bash
docker compose exec app php artisan key:generate
```
Run the migrations and seeder

```bash
just artisan migrate:fresh --seed
```

or

```bash
docker compose exec app php artisan migrate:fresh --seed
```

That's it!

## Running feature tests

You can just run the tests using:

```bash
just artisan test
```

or

```bash
docker compose exec app php artisan test
```
