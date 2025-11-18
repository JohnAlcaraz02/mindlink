# Quick Start: Deploy MindLink in 10 Minutes

This guide will help you deploy MindLink to Railway (the easiest option) in under 10 minutes.

## Prerequisites

- GitHub account
- Railway account (sign up at [railway.app](https://railway.app) - free tier available)

---

## Step 1: Push Your Code to GitHub (2 minutes)

1. **Initialize Git** (if not already done)
   ```bash
   git init
   git add .
   git commit -m "Initial commit - MindLink Mental Health Platform"
   ```

2. **Create a new repository on GitHub**
   - Go to [github.com/new](https://github.com/new)
   - Name it: `mindlink`
   - Keep it private or public (your choice)
   - Don't initialize with README (we already have one)
   - Click "Create repository"

3. **Push your code**
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/mindlink.git
   git branch -M main
   git push -u origin main
   ```

---

## Step 2: Deploy to Railway (5 minutes)

1. **Go to Railway**
   - Visit [railway.app](https://railway.app)
   - Click "Login" and sign in with GitHub

2. **Create New Project**
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose your `mindlink` repository
   - Railway will start building automatically

3. **Add PostgreSQL Database**
   - In your project dashboard, click "+ New"
   - Select "Database" → "Add PostgreSQL"
   - Railway will automatically provision the database
   - The database credentials will be automatically linked to your app

4. **Configure Environment Variables**
   - Click on your web service (not the database)
   - Go to "Variables" tab
   - Click "Raw Editor"
   - Paste the following (Railway will auto-fill database vars):

   ```env
   APP_NAME=MindLink
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:GENERATE_THIS_BELOW
   APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

   DB_CONNECTION=pgsql
   DB_HOST=${{PGHOST}}
   DB_PORT=${{PGPORT}}
   DB_DATABASE=${{PGDATABASE}}
   DB_USERNAME=${{PGUSER}}
   DB_PASSWORD=${{PGPASSWORD}}

   SESSION_DRIVER=database
   QUEUE_CONNECTION=database
   CACHE_STORE=database
   LOG_CHANNEL=errorlog
   LOG_LEVEL=error
   ```

5. **Generate APP_KEY**
   - On your local machine, run:
     ```bash
     php artisan key:generate --show
     ```
   - Copy the output (it looks like: `base64:xxxxxxxxxxxxx`)
   - Paste it as the `APP_KEY` value in Railway

6. **Deploy & Migrate**
   - Railway will automatically redeploy
   - Once deployed, click on your service
   - Go to "Deployments" → Click latest deployment
   - Scroll down and click "View Logs"
   - Wait for deployment to complete

7. **Run Migrations**
   - In Railway, go to your service
   - Click the "⋮" menu → "Settings"
   - Scroll to "Deploy Command"
   - Set it to: `php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT`
   - This will run migrations on every deploy

   OR manually run migrations:
   - Click your service → "⋮" → "Shell"
   - Run: `php artisan migrate --force`

8. **Generate Domain**
   - Click "Settings" tab
   - Scroll to "Networking"
   - Click "Generate Domain"
   - Railway will give you a URL like: `mindlink.railway.app`

---

## Step 3: Test Your Deployment (3 minutes)

1. **Visit your app**
   - Click the generated domain URL
   - You should see the login page

2. **Create an admin account**
   - Click "Register"
   - Select "Administrator"
   - Fill in the form with any email
   - Create your account

3. **Create a student account**
   - Logout and register again
   - Select "Student"
   - Use format: `21-12345@g.batstate-u.edu.ph`
   - Select a college
   - Create account

4. **Test features**
   - ✅ Daily mood check-in
   - ✅ Journal entry
   - ✅ Profile update
   - ✅ Admin dashboard (login as admin)

---

## Common Issues & Fixes

### Issue: "500 Server Error"
**Fix**: Ensure APP_KEY is generated and set correctly
```bash
# Generate locally and copy to Railway
php artisan key:generate --show
```

### Issue: "Database connection failed"
**Fix**: Check that PostgreSQL database variables are linked
- Railway should auto-link `${{PGHOST}}`, `${{PGPORT}}`, etc.
- If not, manually copy from the PostgreSQL service

### Issue: "Migrations not running"
**Fix**: Run migrations manually via Railway shell
```bash
# In Railway shell
php artisan migrate --force
```

### Issue: "CSS not loading"
**Fix**: This shouldn't happen as Tailwind is via CDN, but check:
- APP_URL is set to your Railway domain
- Clear cache: `php artisan config:clear`

---

## Updating Your Deployment

When you make changes:

```bash
# Make your changes, then:
git add .
git commit -m "Description of changes"
git push origin main

# Railway will automatically deploy!
```

---

## Alternative: Deploy to Render (Same process)

If Railway doesn't work, Render is another excellent free option:

1. Go to [render.com](https://render.com)
2. Create New → PostgreSQL (free tier)
3. Create New → Web Service
4. Connect GitHub repo
5. Set build command: `composer install --no-dev`
6. Set start command: `php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT`
7. Add environment variables (same as Railway)
8. Deploy!

---

## Next Steps

- [ ] Customize branding (logo, colors)
- [ ] Add more wellness resources
- [ ] Set up email notifications (optional)
- [ ] Configure custom domain (optional)
- [ ] Set up SSL (automatic with Railway/Render)
- [ ] Add more mental health features

---

## Need Help?

- **Railway Docs**: [docs.railway.app](https://docs.railway.app)
- **Laravel Deployment**: [laravel.com/docs/deployment](https://laravel.com/docs/deployment)
- **Full Deployment Guide**: See [DEPLOYMENT.md](DEPLOYMENT.md)

---

**Congratulations! Your MindLink platform is now live! 🎉**
