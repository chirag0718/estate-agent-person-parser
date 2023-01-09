# Estate Agent Person Parser (Street Group)

A simple programme that reads CSV files from the local filesystem. This project was developed using Laravel and React JS in order to load a.csv file and show the data of the people whose names it contains.

## Laravel Configuration Guide

Use the composer manager to install Laravel. 

```bash
cd estate-agent-person-parser && composer install
```

## React Configuration Guide

Use the npm manager to install npm packages.

```bash
cd estate-agent-person-parser/react-project
npm install
```

## Database
Create database and add database and root and passsword name as shown in below.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=street_group
DB_USERNAME=root
DB_PASSWORD=
```bash

Once database configutation is done then after run migration command to create tables.
```bash
cd estate-agent-person-parser
php artisan migrate
```

## Run Server (Laravel and React Vite) and Go to URL: http://localhost:3000
```bash
// Laravel
cd estate-agent-person-parser
php artisan serve

// React
cd estate-agent-person-parser/react-project
npm run dev

```

## Author
Chiragkumar Patel

## License

[MIT](https://choosealicense.com/licenses/mit/)
