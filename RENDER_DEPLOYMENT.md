# Deploy MindLink to Render - Step by Step Guide

This guide walks you through deploying MindLink to Render with a free PostgreSQL database.

---

## Prerequisites

- GitHub account
- Render account (sign up at [render.com](https://render.com) - free tier available)
- Your code ready in the `mindlink` directory

---

## Step 1: Push Your Code to GitHub

1. **Initialize Git and commit your code**
   ```bash
   git init
   git add .
   git commit -m "Initial commit - MindLink Mental Health Platform"
   ```

2. **Create a new repository on GitHub**
   - Go to [github.com/new](https://github.com/new)
   - Repository name: `mindlink`
   - Description: "Mental Health Support Hub for BatStateU"
   - Choose Public or Private
   - **Do NOT** initialize with README, .gitignore, or license (we have them)
   - Click "Create repository"

3. **Push to GitHub**
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/mindlink.git
   git branch -M main
   git push -u origin main
   ```

   Replace `YOUR_USERNAME` with your GitHub username.

---

## Step 2: Create PostgreSQL Database on Render

1. **Sign up/Login to Render**
   - Go to [render.com](https://render.com)
   - Click "Get Started" or "Sign In"
   - Sign in with GitHub

2. **Create PostgreSQL Database**
   - In your Render Dashboard, click "New +"
   - Select "PostgreSQL"
   - Configure:
     - **Name**: `mindlink-db`
     - **Database**: `mindlink`
     - **User**: `mindlink` (or leave default)
     - **Region**: Choose closest to your users (e.g., Singapore for Philippines)
     - **PostgreSQL Version**: 16 (latest)
     - **Instance Type**: Free
   - Click "Create Database"

3. **Save Database Connection Details**
   - Wait for database to provision (1-2 minutes)
   - Once ready, you'll see the connection details
   - **Important**: Copy the "Internal Database URL" - it looks like:
     ```
     postgresql://mindlink:password@dpg-xxx-a.singapore-postgres.render.com/mindlink
     ```
   - Keep this tab open, you'll need these values

---

## Step 3: Create Web Service on Render

1. **Create New Web Service**
   - Click "New +" again
   - Select "Web Service"
   - Click "Build and deploy from a Git repository"
   - Click "Next"

2. **Connect Your GitHub Repository**
   - If first time: Click "Connect GitHub" and authorize Render
   - Find and select your `mindlink` repository
   - Click "Connect"

3. **Configure Web Service**
   Fill in the following settings:

   **Basic Settings:**
   - **Name**: `mindlink`
   - **Region**: Same as database (e.g., Singapore)
   - **Branch**: `main`
   - **Root Directory**: (leave blank)
   - **Runtime**: `Docker`
   - **Instance Type**: `Free`

   **Build Settings:**
   Since we're using Docker, Render will automatically detect the Dockerfile.
   - Build Command: (leave blank - Docker handles this)
   - Start Command: (leave blank - Docker CMD handles this)

   Click "Advanced" to add environment variables

4. **Add Environment Variables**
   Click "Add Environment Variable" and add these one by one:

   ```
   APP_NAME=MindLink
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=GENERATE_THIS_BELOW
   APP_URL=https://mindlink.onrender.com
   APP_TIMEZONE=UTC

   DB_CONNECTION=pgsql
   DB_HOST=dpg-xxx-a.singapore-postgres.render.com
   DB_PORT=5432
   DB_DATABASE=mindlink
   DB_USERNAME=mindlink
   DB_PASSWORD=your_db_password

   SESSION_DRIVER=database
   SESSION_LIFETIME=120
   QUEUE_CONNECTION=database
   CACHE_STORE=database

   LOG_CHANNEL=errorlog
   LOG_LEVEL=error

   BROADCAST_CONNECTION=log
   FILESYSTEM_DISK=local
   ```

   **IMPORTANT**:
   - Replace DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD with values from Step 2
   - Or use the full Internal Database URL by parsing it

5. **Generate APP_KEY**
   - On your local machine, run:
     ```bash
     php artisan key:generate --show
     ```
   - Copy the output (example: `base64:aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890=`)
   - Paste it as the `APP_KEY` value in Render

6. **Create Web Service**
   - Review all settings
   - Click "Create Web Service"
   - Render will start building your Docker image

---

## Step 4: Wait for Deployment

1. **Monitor Build Progress**
   - You'll see build logs in real-time
   - Docker will install dependencies and build the image
   - This takes 5-10 minutes on the first deploy

2. **Watch for Success**
   - Look for: "Build successful"
   - Then: "Starting service"
   - Finally: "Your service is live"

3. **Check Deployment Status**
   - Top of page will show: "Live" with a green dot
   - Your app URL will be: `https://mindlink.onrender.com` (or similar)

---

## Step 5: Test Your Application

1. **Visit Your App**
   - Click the URL at the top of the Render dashboard
   - You should see the MindLink login page
   - If you see "500 Error", check logs (see Troubleshooting)

2. **Create Admin Account**
   - Click "Register"
   - Select "Administrator"
   - Use any email (e.g., `admin@mindlink.com`)
   - Create password
   - Submit

3. **Create Student Account**
   - Logout
   - Click "Register"
   - Select "Student"
   - Email: `21-12345@g.batstate-u.edu.ph` (must follow format)
   - Select a college
   - Create account

4. **Test Features**
   - ✅ Dashboard loads
   - ✅ Daily mood check-in works
   - ✅ Create journal entry
   - ✅ Update profile
   - ✅ Admin dashboard (login as admin)
   - ✅ College filtering in admin dashboard

---

## Step 6: Configure Custom Domain (Optional)

If you have a custom domain:

1. **Add Custom Domain**
   - In Render service settings
   - Scroll to "Custom Domains"
   - Click "Add Custom Domain"
   - Enter: `mindlink.yourdomain.com`

2. **Update DNS**
   - In your domain provider (GoDaddy, Namecheap, etc.)
   - Add CNAME record:
     - Name: `mindlink`
     - Value: `mindlink.onrender.com`

3. **Update APP_URL**
   - In Render environment variables
   - Change `APP_URL` to `https://mindlink.yourdomain.com`

---

## Troubleshooting

### Issue: "500 Internal Server Error"

**Possible causes:**
1. APP_KEY not set or invalid
2. Database connection failed
3. Migrations didn't run

**Fix:**
```bash
# Check Render logs (in your service dashboard)
# Look for specific error messages

# Common fixes:
# 1. Verify APP_KEY is set correctly
# 2. Check database credentials
# 3. Manually run migrations (see below)
```

### Issue: Database Connection Failed

**Fix:**
1. Go to PostgreSQL service in Render
2. Copy "Internal Database URL"
3. Parse it: `postgresql://USER:PASSWORD@HOST:PORT/DATABASE`
4. Update environment variables with correct values
5. Redeploy: Settings → Manual Deploy → "Deploy latest commit"

### Issue: Migrations Not Running

**Fix - Manual Migration:**
1. In your Render web service, click "Shell" tab
2. Click "Connect"
3. Wait for shell to load
4. Run:
   ```bash
   php artisan migrate --force
   ```
5. If successful, you'll see migration output

### Issue: CSS Not Loading

Since you're using CDN (Tailwind via CDN), this shouldn't happen. If it does:

**Fix:**
1. Check APP_URL matches your actual domain
2. Clear cache:
   ```bash
   # In Render shell
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### Issue: "Permission Denied" Errors

**Fix:**
The Dockerfile already sets permissions, but if needed:
```bash
# In Render shell
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Issue: Build Fails

**Common Docker build errors:**

1. **Composer install fails**: Check `composer.json` is valid
2. **PHP extension missing**: Dockerfile already includes all needed extensions
3. **Apache config error**: Check `docker/apache.conf` exists

**Fix:**
- Check build logs for specific error
- Ensure all files are committed to GitHub
- Trigger manual deploy

---

## Updating Your Deployment

When you make changes to your code:

```bash
# Make your changes locally
# Test them: php artisan serve

# Commit and push
git add .
git commit -m "Description of your changes"
git push origin main

# Render will automatically detect the push and redeploy!
```

**Auto-deploy settings:**
- Go to Settings → Build & Deploy
- Ensure "Auto-Deploy" is set to "Yes"

---

## Render Free Tier Limitations

**Be aware:**
- **Web Service**: Spins down after 15 minutes of inactivity
- **First request after sleep**: Takes 30-60 seconds to wake up
- **Database**: 1GB storage, 97 free instances
- **Bandwidth**: 100GB/month

**Upgrade to paid if needed:**
- Starter plan: $7/month (no spin down)
- Database: $7/month for 10GB

---

## Production Checklist

Before going live:

- [ ] APP_DEBUG is `false`
- [ ] APP_ENV is `production`
- [ ] APP_KEY is generated and set
- [ ] Database credentials are correct
- [ ] All migrations ran successfully
- [ ] Test user registration (student & admin)
- [ ] Test all main features
- [ ] SSL is enabled (automatic with Render)
- [ ] Custom domain configured (if applicable)
- [ ] Error logging is working

---

## Monitoring Your App

**View Logs:**
1. Go to your web service in Render
2. Click "Logs" tab
3. See real-time application logs

**View Metrics:**
1. Click "Metrics" tab
2. See CPU, memory, requests

**Email Alerts:**
1. Settings → Notifications
2. Add email for deployment failures

---

## Need Help?

- **Render Docs**: [render.com/docs](https://render.com/docs)
- **Render Community**: [community.render.com](https://community.render.com)
- **Laravel Deployment**: [laravel.com/docs/deployment](https://laravel.com/docs/deployment)

---

## Quick Reference: Environment Variables

Copy this template for easy reference:

```env
APP_NAME=MindLink
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...  # Generate with: php artisan key:generate --show
APP_URL=https://mindlink.onrender.com
APP_TIMEZONE=UTC

DB_CONNECTION=pgsql
DB_HOST=dpg-xxx.singapore-postgres.render.com
DB_PORT=5432
DB_DATABASE=mindlink
DB_USERNAME=mindlink
DB_PASSWORD=your_password_here

SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database
CACHE_STORE=database

LOG_CHANNEL=errorlog
LOG_LEVEL=error
```

---

**Congratulations! Your MindLink platform is now deployed on Render! 🎉**

Your app is live at: `https://mindlink.onrender.com`
