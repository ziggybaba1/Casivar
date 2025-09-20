<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🎲 Mini Lottery Betting API (Laravel + PostgreSQL)

A simplified backend system that demonstrates how a lottery betting platform works, built with **Laravel 12** and **PostgreSQL**.  
This project is designed to mimic core functionality of lottery betting systems while keeping the scope small and developer-friendly.

---

## Features

- **Authentication & Authorization**
  - User registration & login (JWT-based or Sanctum-based auth)
  - Role-based authorization with Policies & Gates

- **Wallet System**
  - Deposit / Withdraw funds
  - Transaction-safe credit & debit (using DB transactions)

- **Lottery Management**
  - Admin can define lotteries (name, schedule, odds, payout rules)
  - Manage draws & results

- **Betting Engine**
  - Users place bets on lotteries
  - Store tickets with status: `pending`, `won`, `lost`
  - Automatic settlement when results are posted

- **Results Engine**
  - Admin posts winning numbers
  - System evaluates bets and updates wallet balances

- **Reporting**
  - User: bet history, wins/losses, wallet activity
  - Admin: total bets, payouts, and revenue summary

---

## Tech Stack

- **Framework:** Laravel 12 (PHP 8.2+)
- **Database:** PostgreSQL
- **Auth:** Laravel Sanctum / Passport
- **Queue / Jobs:** Laravel Queues (Redis or Database driver)
- **Testing:** PHPUnit & Pest
- **Containerization (Optional):** Docker / Laravel Sail

---

## Project Structure
- **app/**
    - Models/ # User, Wallet, Lottery, Bet, Transaction, Result
    - Policies/ # Authorization policies
    - Services/ # Business logic (WalletService, BettingService)
- **Http/**
    - Controllers/ # REST API controllers
    - Requests/ # Form request validations
    - Providers/ # AuthServiceProvider, AppServiceProvider, etc.
- **database/**
    - migrations/ # PostgreSQL schema definitions
    - seeders/ # Demo data for testing

---

## Installation

1. **Clone the repository**
   - git clone https://github.com/ziggybaba1/casivar.git
   - cd casivar

2. **Install dependencies**
   composer install

3. **Copy environment file**
   cp .env.example .env

4. **Set PostgreSQL credentials in .env:**
   - DB_CONNECTION=pgsql
   - DB_HOST=127.0.0.1
   - DB_PORT=5432
   - DB_DATABASE=lottery_api
   - DB_USERNAME=postgres
   - DB_PASSWORD=secret

5. **Generate app key**
   php artisan key:generate

6. **Run migrations & seeders**
   php artisan migrate --seed

7. **Start server**
   php artisan serve

## Testing
- **Run automated tests:**
    php artisan test

## Future Enhancements
    WebSockets for real-time result updates

    Multi-currency wallet support

    Odds engine with configurable payout rules

    Docker Compose setup for quick dev environment
