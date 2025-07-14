# Configurable Variables
$SiteName = "daisy-scm"
$AppPath = "C:\daisy-scm"
$PublicPath = "$AppPath\public"
$IPAddress = "192.168.4.85"
$Port = 80

# Import IIS module
Import-Module WebAdministration

# Remove existing site with same name (optional, for fresh setup)
if (Test-Path "IIS:\Sites\$SiteName") {
    Remove-WebSite -Name $SiteName
    Write-Host "Removed existing site '$SiteName'."
}

# Create new IIS Site bound to local network IP
New-WebSite -Name $SiteName -Port $Port -IPAddress $IPAddress -PhysicalPath $PublicPath -Force
Write-Host "Site '$SiteName' created and bound to $IPAddress:$Port."

# Set folder permissions for IIS
$identity = "IIS_IUSRS"
$acl = Get-Acl -Path $AppPath
$permission = "$identity","Modify","ContainerInherit,ObjectInherit","None","Allow"
$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule $permission
$acl.AddAccessRule($accessRule)
Set-Acl -Path $AppPath -AclObject $acl
Write-Host "Set Modify permissions for IIS_IUSRS on $AppPath"

# Make storage and bootstrap/cache writable
$WritablePaths = @("$AppPath\storage", "$AppPath\bootstrap\cache")
foreach ($path in $WritablePaths) {
    if (Test-Path $path) {
        $acl = Get-Acl -Path $path
        $acl.AddAccessRule($accessRule)
        Set-Acl -Path $path -AclObject $acl
        Write-Host "Writable permissions applied to: $path"
    } else {
        Write-Host "Path not found: $path"
    }
}

# Create Laravel's storage symlink
Push-Location $AppPath
php artisan storage:link
Pop-Location

# Open Firewall Port (HTTP)
if (-not (Get-NetFirewallRule -DisplayName "IIS HTTP Port 80 for Laravel" -ErrorAction SilentlyContinue)) {
    New-NetFirewallRule -DisplayName "IIS HTTP Port 80 for Laravel" -Direction Inbound -Protocol TCP -LocalPort 80 -Action Allow
    Write-Host "Firewall rule added to allow HTTP traffic on port 80."
} else {
    Write-Host "Firewall rule already exists."
}

Write-Host "`n✅ Site '$SiteName' is now accessible on the local network at: http://$IPAddress"
