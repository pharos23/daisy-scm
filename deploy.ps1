# deploy.ps1

Write-Output "Starting deployment..."
cd "C:\daisy-scm"

git fetch origin
git reset --hard origin/main

# Install dependencies
composer install --no-interaction --prefer-dist

# Build assets
npm install
npm run build

# Laravel optimize
php artisan optimize

# Restart RoadRunner if needed
php artisan octane:reload

Write-Output "Deployment complete."

