# Zadanie Rekrutacyjne Symfony 7 🚀

[![Wersja PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![Wersja Symfony](https://img.shields.io/badge/Symfony-7.0-green.svg)](https://symfony.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-brightgreen.svg)](https://www.docker.com/)

## 📋 Wprowadzenie

Nowoczesna aplikacja oparta na Symfony 7, zaprojektowana do efektywnego przetwarzania danych i integracji API. Zbudowana zgodnie z najlepszymi praktykami branżowymi i wykorzystująca najnowsze technologie, zapewniając łatwość utrzymania i skalowalność.

<h1>⚙️ Użyte Technologie</h1>

- PHP 8.1+
- Symfony 7.0
- Docker & Docker Compose
- MySQL 8.0.32
- Composer
- npm/yarn

## 🚀 Szybki Start

### Użycie Dockera (Zalecane)

```bash
# Klonowanie repozytorium
git clone https://github.com/Gharib84/zadanie-rekrutacyjne.git
cd zadanie-rekrutacyjne

# Uruchomienie kontenerów Docker
docker compose -f docker-compose.yaml up --build -d

# Dostęp do powłoki kontenera
docker compose -f docker-compose.yaml exec app bash

# Instalacja zależności
composer install
npm install  # lub yarn install
npm run dev

# Wykonanie migracji
php bin/console doctrine:migrations:migrate
```

### Konfiguracja Środowiska

Utwórz plik `.env` na podstawie `.env.dist`:

```dotenv
# Konfiguracja bazy danych
DATABASE_URL="mysql://app_task:test@db:3306/task_db?serverVersion=8.0.32&charset=utf8mb4"

# Dodaj inne zmienne środowiskowe według potrzeb
```

## 🗂️ Struktura Projektu

```
projekt/
├── config/          # Konfiguracja aplikacji
├── src/             # Kod źródłowy aplikacji
│   ├── Controller/  # Kontrolery obsługujące żądania
│   ├── Entity/      # Encje bazodanowe
│   └── Service/     # Logika biznesowa
├── templates/       # Szablony Twig
├── public/         # Katalog publiczny
├── migrations/     # Migracje bazy danych
└── tests/          # Testy
```

## 🛠️ Rozwój Projektu

### Lokalny Serwer Deweloperski

```bash
# Uruchomienie serwera deweloperskiego Symfony
php bin/console server:run

# Dostęp do aplikacji
# http://localhost:9980/
# http://localhost:9981/
```

### Zarządzanie Bazą Danych

```bash
# Utworzenie bazy danych
php bin/console doctrine:database:create

# Wykonanie migracji
php bin/console doctrine:migrations:migrate

# Wczytanie fixtures (jeśli dostępne)
php bin/console doctrine:fixtures:load
```

## 🧪 Testowanie

```bash
# Uruchomienie wszystkich testów
php bin/phpunit

# Uruchomienie konkretnego zestawu testów
php bin/phpunit --testsuite unit
```

## 🐳 Komendy Dockera

```bash
# Zbudowanie i uruchomienie kontenerów
docker compose -f docker-compose.yaml up --build -d

# Zatrzymanie kontenerów
docker compose -f docker-compose.yaml down

# Podgląd logów
docker compose -f docker-compose.yaml logs -f
```

## 📝 Współpraca nad Projektem

1. Wykonaj fork repozytorium
2. Utwórz branch dla swojej funkcjonalności (`git checkout -b funkcjonalnosc/super-feature`)
3. Zatwierdź zmiany (`git commit -m 'Dodano super funkcjonalność'`)
4. Wypchnij branch (`git push origin funkcjonalnosc/super-feature`)
5. Utwórz Pull Request

## 📞 Wsparcie

W razie pytań lub problemów:
- 📧 Email: mahmoudgharibsaid.100@gmail.com
- 💬 System zgłoszeń: [GitHub Issues](https://github.com/Gharib84/zadanie-rekrutacyjne/issues)

## 📜 Licencja

Projekt jest udostępniony na licencji MIT - szczegóły znajdziesz w pliku [LICENSE](LICENSE).