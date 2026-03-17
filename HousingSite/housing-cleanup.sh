#!/bin/bash

echo "=== HOUSINGSITE CLEANUP - Removing Duplicate Files ==="

# Remove OLD files (keep the new ones in dashboard/ structure)
echo "1. Removing old admin files..."
rm -f resources/views/admin/dashboard.blade.php

echo "2. Removing old agent files..."
rm -f resources/views/agent/complete-profile.blade.php
rm -f resources/views/agent/dashboard.blade.php
rm -f resources/views/agent/profile.blade.php
rm -f resources/views/agent/manage-listings.blade.php
rm -f resources/views/agent/post.blade.php
rm -f resources/views/agent/listing/index.blade.php

echo "3. Removing old tenant files..."
rm -f resources/views/tenant/dashboard.blade.php

echo "4. Handling old agents files (backup then recreate as public profiles)..."
# Backup old agents files first
if [ -f "resources/views/agents/index.blade.php" ]; then
    cp resources/views/agents/index.blade.php resources/views/agents/index.blade.php.backup
    echo "   ✓ Backed up agents index"
fi
if [ -f "resources/views/agents/show.blade.php" ]; then
    cp resources/views/agents/show.blade.php resources/views/agents/show.blade.php.backup
    echo "   ✓ Backed up agents show"
fi

# Remove old agents files (they're admin views, we have them in dashboard/admin/agents/)
rm -f resources/views/agents/index.blade.php
rm -f resources/views/agents/show.blade.php

echo "5. Creating public agent profiles..."
# Create fresh public agent profile views
php artisan make:view agents/index
php artisan make:view agents/show

echo "6. Creating missing admin listings show view..."
php artisan make:view dashboard/admin/listings/show

echo "7. Removing empty directories..."
# Remove empty directories
rmdir resources/views/admin 2>/dev/null && echo "   ✓ Removed empty admin directory"
rmdir resources/views/agent 2>/dev/null && echo "   ✓ Removed empty agent directory"
rmdir resources/views/agent/listing 2>/dev/null && echo "   ✓ Removed empty agent/listing directory"
rmdir resources/views/tenant 2>/dev/null && echo "   ✓ Removed empty tenant directory"

echo ""
echo "=== FINAL STRUCTURE ==="
find resources/views -type f -name "*.blade.php" | grep -v ".backup" | sort

echo ""
echo "=== CLEANUP COMPLETE ==="
echo "Old duplicate files removed!"
echo "New organized structure is ready!"
