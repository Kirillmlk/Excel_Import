# 🛠 Проект Laravel с динамическими рядами и импортом Excel

# 📌 Описание

Этот проект реализует систему управления задачами, проектами и динамическими рядами с поддержкой импорта данных из Excel. Используется паттерн Фабрика, консольные команды для обработки данных и валидация форм.

# 🚀 Возможности

📌 Меню и страницы с компонентами

📥 Формы импорта с прокидыванием в job

📊 Импорт данных из Excel через консольную команду

🏗 Фабрика для проектов с динамическими рядами

✅ Валидация данных

📝 Создание и управление задачами

📌 Пагинация списков

❌ Вывод фэйлдроус (ошибок)

⚡ Оптимизированный импорт динамичных рядов

📥 Установка и запуск


# Склонировать репозиторий (если не распакован вручную)
git clone https://github.com/Kirillmlk/Excel_Import
cd project

2️⃣ Установка зависимостей

composer install

3️⃣ Настройка .env

cp .env.example .env

Открыть .env и указать параметры подключения к базе данных.

4️⃣ Генерация ключа приложения

php artisan key:generate

5️⃣ Запуск миграций

php artisan migrate

6️⃣ Установка фронтенда

npm install

7️⃣ Запуск проекта

php artisan serve & vite

🛠 Основные команды

📊 Импорт данных из Excel

php artisan excel:import

🔄 Запуск обработки динамических рядов

php artisan dynamic:process

📌 Структура кода

📂 Модели и миграции → app/Models, database/migrations

📂 Контроллеры → app/Http/Controllers

🎨 Компоненты Vue → resources/js/Components

💻 Фронтенд → resources/js/

⚙️ Консольные команды → app/Console/Commands

🏗 Фабрики → database/factories


