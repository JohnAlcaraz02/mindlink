# MindLink Deployment Guide

This guide covers multiple deployment options for the MindLink Mental Health Support Hub.

## Prerequisites

- Git repository (GitHub, GitLab, etc.)
- PostgreSQL database access
- Basic command line knowledge

---

## Option 1: Railway (Recommended for Beginners)

Railway provides easy deployment with a free tier and automatic PostgreSQL provisioning.

### Steps:

1. **Push your code to GitHub**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/yourusername/mindlink.git
   git push -u origin main
   ```

2. **Deploy to Railway**
   - Go to [railway.app](https://railway.app)
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose your repository
   - Railway will auto-detect Laravel and deploy

3. **Add PostgreSQL Database**
   - In your Railway project, click "New"
   - Select "Database" → "PostgreSQL"
   - Railway will automatically provision and connect it

4. **Set Environment Variables**

   In Railway project settings, add these variables:
   ```
   APP_NAME=MindLink
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:... (generate with: php artisan key:generate --show)
   APP_URL=https://your-app.railway.app

   DB_CONNECTION=pgsql
   DB_HOST=${{PGHOST}}
   DB_PORT=${{PGPORT}}
   DB_DATABASE=${{PGDATABASE}}
   DB_USERNAME=${{PGUSER}}
   DB_PASSWORD=${{PGPASSWORD}}

   SESSION_DRIVER=database
   QUEUE_CONNECTION=database
   CACHE_STORE=database
   ```

5. **Deploy**
   - Railway will automatically deploy
   - Run migrations: Settings → Variables → Add `RAILWAY_RUN_MIGRATIONS=true`
   - Or use the console: `php artisan migrate --force`

---

## Option 2: Render

Render offers free PostgreSQL and web service hosting.

### Steps:

1. **Push code to GitHub** (same as Railway)

2. **Create PostgreSQL Database**
   - Go to [render.com](https://render.com)
   - Dashboard → New → PostgreSQL
   - Note the connection details

3. **Create Web Service**
   - Dashboard → New → Web Service
   - Connect your GitHub repository
   - Configure:
     - Name: mindlink
     - Environment: Docker (or use native)
     - Build Command: `composer install --no-dev --optimize-autoloader`
     - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

4. **Environment Variables**
   ```
   APP_NAME=MindLink
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=(generate with: php artisan key:generate --show)
   APP_URL=https://mindlink.onrender.com

   DB_CONNECTION=pgsql
   DB_HOST=(from Render PostgreSQL)
   DB_PORT=5432
   DB_DATABASE=(from Render PostgreSQL)
   DB_USERNAME=(from Render PostgreSQL)
   DB_PASSWORD=(from Render PostgreSQL)
   ```

5. **Deploy & Migrate**
   - Render will auto-deploy
   - Run migrations in the Shell tab: `php artisan migrate --force`

---

## Option 3: Heroku

Classic platform with robust support (requires payment method but offers free credits).

### Steps:

1. **Install Heroku CLI**
   ```bash
   # Download from: https://devcenter.heroku.com/articles/heroku-cli
   ```

2. **Login & Create App**
   ```bash
   heroku login
   heroku create mindlink-app
   ```

3. **Add PostgreSQL**
   ```bash
   heroku addons:create heroku-postgresql:essential-0
   ```

4. **Configure Environment**
   ```bash
   heroku config:set APP_NAME=MindLink
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   heroku config:set APP_KEY=$(php artisan key:generate --show)
   heroku config:set LOG_CHANNEL=errorlog
   heroku config:set SESSION_DRIVER=database
   heroku config:set QUEUE_CONNECTION=database
   ```

5. **Deploy**
   ```bash
   git push heroku main
   heroku run php artisan migrate --force
   ```

6. **Open App**
   ```bash
   heroku open
   ```

---

## Option 4: VPS (DigitalOcean, Linode, Vultr)

For more control, deploy to a VPS running Ubuntu 22.04.

### Steps:

1. **Create Droplet/Server**
   - Ubuntu 22.04
   - At least 1GB RAM
   - Choose datacenter region

2. **SSH into Server**
   ```bash
   ssh root@your-server-ip
   ```

3. **Install Dependencies**
   ```bash
   # Update system
   apt update && apt upgrade -y

   # Install PHP 8.2
   apt install -y software-properties-common
   add-apt-repository ppa:ondrej/php -y
   apt update
   apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-common php8.2-mysql \
       php8.2-pgsql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd

   # Install Composer
   curl -sS https://getcomposer.org/installer | php
   mv composer.phar /usr/local/bin/composer

   # Install PostgreSQL
   apt install -y postgresql postgresql-contrib

   # Install Nginx
   apt install -y nginx

   # Install Git
   apt install -y git
   ```

4. **Setup Database**
   ```bash
   sudo -u postgres psql
   CREATE DATABASE mindlink;
   CREATE USER mindlink_user WITH PASSWORD 'your-secure-password';
   GRANT ALL PRIVILEGES ON DATABASE mindlink TO mindlink_user;
   \q
   ```

5. **Clone & Setup Application**
   ```bash
   cd /var/www
   git clone https://github.com/yourusername/mindlink.git
   cd mindlink

   # Install dependencies
   composer install --no-dev --optimize-autoloader

   # Setup environment
   cp .env.example .env
   nano .env  # Edit database credentials

   # Generate key
   php artisan key:generate

   # Set permissions
   chown -R www-data:www-data /var/www/mindlink
   chmod -R 755 /var/www/mindlink/storage
   chmod -R 755 /var/www/mindlink/bootstrap/cache

   # Run migrations
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Configure Nginx**
   ```bash
   nano /etc/nginx/sites-available/mindlink
   ```

   Add this configuration:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/mindlink/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;

       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

7. **Enable Site & Restart**
   ```bash
   ln -s /etc/nginx/sites-available/mindlink /etc/nginx/sites-enabled/
   nginx -t
   systemctl restart nginx
   systemctl restart php8.2-fpm
   ```

8. **Setup SSL (Optional but Recommended)**
   ```bash
   apt install -y certbot python3-certbot-nginx
   certbot --nginx -d your-domain.com
   ```

---

## Post-Deployment Checklist

After deploying to any platform:

- [ ] Database migrations completed (`php artisan migrate --force`)
- [ ] APP_KEY is generated and set
- [ ] APP_DEBUG is set to `false` in production
- [ ] Database credentials are correct
- [ ] File permissions are correct (if using VPS)
- [ ] SSL certificate is installed (for production)
- [ ] Test user registration with student email format
- [ ] Test admin login functionality
- [ ] Test mood check-in feature
- [ ] Test journal entries
- [ ] Test anonymous chat
- [ ] Verify college filtering works in admin dashboard

---

## Environment Variables Reference

Essential environment variables needed for deployment:

```env
# Application
APP_NAME=MindLink
APP_ENV=production
APP_KEY=base64:... (REQUIRED - generate with: php artisan key:generate --show)
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=mindlink
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# Session & Cache
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
```

---

## Troubleshooting

### Common Issues:

1. **500 Error after deployment**
   - Check APP_KEY is set
   - Run `php artisan config:clear`
   - Check file permissions (storage and bootstrap/cache)

2. **Database connection failed**
   - Verify database credentials
   - Ensure database exists
   - Check if PostgreSQL port is accessible

3. **Migrations not running**
   - Manually run: `php artisan migrate --force`
   - Check database user has sufficient privileges

4. **CSS/Assets not loading**
   - Since you're using CDN (Tailwind, Chart.js), this shouldn't be an issue
   - Verify APP_URL is set correctly

5. **Session errors**
   - Ensure sessions table exists: `php artisan session:table && php artisan migrate`
   - Check SESSION_DRIVER=database in .env

---

## Updating Your Deployment

When you make changes:

**Railway/Render:**
```bash
git add .
git commit -m "Update description"
git push origin main
# Automatic deployment will trigger
```

**Heroku:**
```bash
git add .
git commit -m "Update description"
git push heroku main
```

**VPS:**
```bash
cd /var/www/mindlink
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Need Help?

- Railway: [docs.railway.app](https://docs.railway.app)
- Render: [render.com/docs](https://render.com/docs)
- Heroku: [devcenter.heroku.com](https://devcenter.heroku.com)
- Laravel Deployment: [laravel.com/docs/deployment](https://laravel.com/docs/deployment)
