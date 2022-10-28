# Trunk Based Development - Feature Flags Workshop - PHPCon 2022

W ramach warsztatu będziemy pracować z prostą aplikacją.
Do działania będzie potrzebny systemu z obsługą:

- `composer`
- `docker`
- `docker-compose`

Aplikacja ma 3 proste endpoint'y, które zwracają zahardcodowane dane.
Aplikacja ma też gotowe podstawowe testy jednostkowe.

## Przygotowanie

### 1. zainstalowanie zależności

`cd main && composer install`

### 2. uruchomienie testów jednostkowych

`composer run tests`

### 3. uruchomienie aplikacji

`php -S 127.0.0.1:8080 public/index.php`

Strona główna:
- http://127.0.0.1:8080/

Endpoint Listy produktów:
- http://127.0.0.1:8080/products

Endpoint konkretnego produktu:
- http://127.0.0.1:8080/products/1
- http://127.0.0.1:8080/products/2
- http://127.0.0.1:8080/products/3 (404)

### 4. uruchomienie aplikacji z pomocą docker-compose

- `cd ..`
- `docker-compose build`
- `docker-compose create`
- `docker-compose start`

Strona główna:
- http://127.0.0.1:8181/

Endpoint Listy produktów:
- http://127.0.0.1:8181/products

Endpoint konkretnego produktu:
- http://127.0.0.1:8181/products/1
- http://127.0.0.1:8181/products/2
- http://127.0.0.1:8181/products/3 (404)

## Jesteś gotowy

Jeśli wszystko działa, jesteś gotowy, by rozpocząć warsztat. 
Treści zadań oraz wszystkie wymagane informacje otrzymasz w trakcie szkolenia.
