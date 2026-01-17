# WowDash Laravel 12

<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
    </a>
    <h3 align="center">User Management Dashboard</h3>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel-framework" alt="Latest Stable Version"></a>
</p>

## About WowDash

WowDash is a modern user management dashboard built with **Laravel 12** and **Livewire 4**. It provides a comprehensive solution for managing users, departments, and designations with a beautiful and responsive interface powered by **TailwindCSS 4**.

### Key Features

- 🔐 **Authentication System** - Login, registration, and password recovery
- 👥 **User Management** - Complete CRUD operations with role-based access
- 🏢 **Department Management** - Organize users by departments
- 💼 **Designation Management** - Manage job titles and positions
- 🖼️ **Profile Pictures** - User avatar upload with validation
- 📊 **Export Functionality** - Export data to PDF and Excel
- 🌍 **Multi-language Support** - Internationalization ready
- 📱 **Responsive Design** - Works seamlessly on all devices
- ⚡ **Real-time Updates** - Powered by Livewire 4

## Tech Stack

### Backend
- **Laravel 12** - PHP Framework
- **Livewire 4.0** - Dynamic Components
- **SQLite** - Database (configurable)
- **PHP 8.2+** - Minimum Requirement

### Frontend
- **TailwindCSS 4.0** - Utility-first CSS
- **Vite 7.0** - Asset Bundling
- **Alpine.js** - JavaScript interactions

### Packages
- `barryvdh/laravel-dompdf` - PDF generation
- `maatwebsite/excel` - Excel export
- `livewire/livewire` - Reactive components

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- Git

### Quick Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd wowdash-laravel-12
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start development server**
   ```bash
   # Simple development
   npm run dev-simple
   
   # Full development with hot reload
   npm run dev-full
   ```

### Using Composer Scripts

The project includes convenient composer scripts:

```bash
# Complete setup from scratch
composer run setup

# Development with all services
composer run dev

# Run tests
composer run test
```

## Default Credentials

After running the seeders, you can use these credentials:

- **Admin User**: `admin@wowdash.com` / `password`
- **Regular User**: `john@wowdash.com` / `password`

## Project Structure

```
├── app/
│   ├── Enums/           # User roles and status
│   ├── Http/
│   │   ├── Controllers/ # HTTP controllers
│   │   ├── Middleware/  # Custom middleware
│   │   └── Requests/    # Form request validation
│   ├── Livewire/        # Livewire components
│   ├── Models/          # Eloquent models
│   └── Providers/       # Service providers
├── database/
│   ├── factories/       # Model factories
│   ├── migrations/      # Database migrations
│   └── seeders/         # Database seeders
├── resources/
│   ├── views/           # Blade templates
│   └── js/              # JavaScript files
├── routes/              # Route definitions
└── storage/             # Application storage
```

## Available Routes

### Authentication
- `GET /login` - Login page
- `GET /register` - Registration page
- `GET /forgot-password` - Password recovery
- `GET /logout` - Logout

### Protected Routes
- `GET /` - Dashboard (requires auth)
- `GET /users` - User management (admin only)
- `GET /settings` - System settings (admin only)
- `GET /view-profile` - Profile view

### Utility
- `GET /lang/{locale}` - Language switcher

## User Roles

### Admin
- Full access to all features
- User management capabilities
- System settings access
- Export functionality

### User
- View own profile
- Basic dashboard access
- Limited functionality

## Development

### Adding New Features

1. **Create Livewire Component**
   ```bash
   php artisan make:livewire NewComponent
   ```

2. **Create Request Validation**
   ```bash
   php artisan make:request NewRequest
   ```

3. **Create Migration**
   ```bash
   php artisan make:migration create_new_table
   ```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter UserTest

# Generate coverage report
php artisan test --coverage
```

### Code Style

The project uses Laravel Pint for code formatting:

```bash
# Format code
./vendor/bin/pint

# Check style
./vendor/bin/pint --test
```

## Configuration

### Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="WowDash"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=wowdash
# DB_USERNAME=root
# DB_PASSWORD=

MAIL_MAILER=log
QUEUE_CONNECTION=database
CACHE_STORE=database
```

### File Uploads

- **Max file size**: 2MB
- **Allowed formats**: jpeg, png, jpg, gif, webp
- **Storage**: `storage/app/public/users`

## Security Features

- Password hashing with bcrypt
- CSRF protection
- Input validation and sanitization
- File upload validation
- Role-based access control
- SQL injection prevention via Eloquent

## Performance Optimizations

- Database query optimization
- Eager loading for relationships
- Database indexing
- Asset minification with Vite
- Caching strategies

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## Troubleshooting

### Common Issues

1. **Migration Errors**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Asset Issues**
   ```bash
   npm run build
   php artisan optimize:clear
   ```

3. **Permission Issues**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

## License

This project is open-sourced software licensed under the **MIT license**.

## Support

For support and questions:
- Create an issue in the repository
- Check the Laravel documentation
- Review Livewire documentation

---

**Built with ❤️ using Laravel 12 and Livewire 4** 
