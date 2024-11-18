## harlekoy

---

### Getting Set Up

1. Clone the repository and navigate to the directory, then run the following commands:
```
cp .env.example .env
composer install
./vendor/bin/sail up -d
```

2. Run the database migrations:
```
./vendor/bin/sail artisan migrate
```

3. Run the queue to allow processing of attribute changes:
```
./vendor/bin/sail queue:listen --queue=batch-updates
```

4. To lint or test, simply run
```
#LINT
./vendor/bin/phpcs app tests

#TEST
./vendor/bin/sail artisan test
```
