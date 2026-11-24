# challenge 2020
this is a school project.
We had to invent a crazy challenge or world record. We had to make a website where a cummunity can come together and help eachother to beat the new record.

## The minimum requirements
- A respresentation of my challegne
- A form where you could rate and sort posts of others
- Three diffenerent functionalities 
- You had to upload videos and sort them in a datbase

## languages
This is made with PHP, Javascript, PHPmyadmin.

## Run locally

Requires PHP with PDO SQLite and Fileinfo. Create a database outside the web root,
then start the PHP development server from the repository root:

```sh
export CHALLENGE_DB=/absolute/path/to/challenge.sqlite
php deploy/init-db.php "$CHALLENGE_DB"
php -S 127.0.0.1:8000
```

The database starts with an empty feed. The original repository includes video
files but has no database dump linking them to accounts or recorded times.
Vimexx keeps the database in `~/.challenge` and preserves new uploads during deploys.
