# MindLink - Mental Health Support Hub

A comprehensive mental health support platform for Batangas State University students, providing mood tracking, journaling, anonymous chat, and wellness resources.

## Features

- **User Authentication**: Secure registration and login with role-based access (Students and Administrators)
- **Student Email Validation**: Enforces BatStateU email format (XX-XXXXX@g.batstate-u.edu.ph)
- **College-Based Organization**: Support for 4 colleges (COE, CET, CICS, CAFAD)
- **Daily Mood Check-in**: Track emotional well-being with mood logging and visualization
- **Personal Journal**: Private journaling with mood tagging and reflection
- **Anonymous Chat**: Safe space for students to communicate anonymously
- **Resources Library**: Access to mental health resources and support information
- **Admin Dashboard**: Comprehensive analytics with college-specific filtering
  - View stress levels by college
  - Monitor user engagement and activity
  - Track mood trends and patterns
- **User Profiles**: Manage personal information and account settings

## Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Database**: PostgreSQL
- **Frontend**: Blade Templates + Tailwind CSS (CDN)
- **Charts**: Chart.js
- **Authentication**: Laravel built-in authentication

## Requirements

- PHP 8.2 or higher
- PostgreSQL
- Composer
- Git

## Local Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/mindlink.git
   cd mindlink
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   ```

4. **Configure database**

   Edit `.env` and update database credentials:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=mindlink
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**

   Open your browser and navigate to: `http://localhost:8000`

## User Roles

### Student
- Must register with BatStateU email format: `XX-XXXXX@g.batstate-u.edu.ph`
- Must select a college during registration
- Access to all student features (mood tracking, journal, chat, resources)

### Administrator
- Can use any email format for registration
- Access to admin dashboard with analytics
- Monitor student well-being by college
- View platform-wide statistics

## Project Structure

```
mindlink/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/AuthController.php
│   │   ├── AdminController.php
│   │   ├── DashboardController.php
│   │   ├── ProfileController.php
│   │   └── ...
│   └── Models/
│       ├── User.php
│       ├── MoodCheckin.php
│       └── ...
├── database/
│   └── migrations/
├── resources/
│   └── views/
│       ├── auth/
│       ├── admin/
│       ├── dashboard.blade.php
│       └── layouts/app.blade.php
├── routes/
│   └── web.php
└── public/
```

## Key Features Implementation

### Email Validation
Student emails are validated using regex pattern: `^\d{2}-\d{5}@g\.batstate-u\.edu\.ph$`

### College Selection
Students must select from:
- College of Engineering (COE)
- College of Engineering Technology (CET)
- College of Informatics and Computing Sciences (CICS)
- College of Architecture, Fine Arts and Design (CAFAD)

### Admin Dashboard Filtering
Administrators can filter all statistics by college to identify which colleges need more mental health support.

## Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions for various platforms:
- Railway (Recommended)
- Render
- Heroku
- VPS (DigitalOcean, Linode, Vultr)

## Security

- Password hashing using bcrypt
- CSRF protection on all forms
- Email validation for student accounts
- Session-based authentication
- Prepared statements for database queries

## Contributing

This is an academic project for Batangas State University. For issues or suggestions, please contact the development team.

## License

This project is developed for educational purposes at Batangas State University.

## Support

For technical support or questions about the platform, please contact your university's mental health services or IT department.

---

**Developed with ❤️ for BatStateU Student Wellness**
