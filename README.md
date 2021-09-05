# It's a first test task for Wisebits

## Installation

- `cp .env .env.local`
- `docker compose up -d`

NOTES: if you're using **NOT** default docker-compose file - set correct db parameters in .env.local

## Usage

- `docker exec -it app bash` - connect to the app container
- `bin/console doctrine:database:create --env=test`
- `bin/console d:m:m --env=test` => `yes` - it executes migrations at default db
- `bin/console doctrine:fixtures:load --env=test` => `yes` - it loads default data to blocks table
- `bin/phpunit` also outside of container `docker exec app bin/phpunit` - it runs tests which checks main functionality

NOTES: for `prod` or `dev` environment please don't use `--env` argument and set it via `APP_ENV` at `.env.local`

## Next step improvement

- write tests for each User actions (which require more time)
- implement roles and authorization for write more complete ActionLog 

### P.S.: Ready for feedback, and if it's possible, for discuss