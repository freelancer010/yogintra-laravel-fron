#!/bin/bash

# YogIntra AMP Validation Script
# This script validates AMP pages using the AMP Validator

echo "🚀 YogIntra AMP Validation Script"
echo "=================================="

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is required but not installed."
    echo "Please install Node.js from https://nodejs.org/"
    exit 1
fi

# Check if AMP Validator is installed
if ! command -v amphtml-validator &> /dev/null; then
    echo "📦 Installing AMP Validator..."
    npm install -g amphtml-validator
fi

# Base URL - change this to your local development URL
BASE_URL="http://localhost:8000"

# AMP Pages to validate
AMP_PAGES=(
    "$BASE_URL/amp"
    "$BASE_URL/contact/amp"
    "$BASE_URL/about/amp"
)

echo ""
echo "🔍 Validating AMP Pages..."
echo "=========================="

# Validate each AMP page
for page in "${AMP_PAGES[@]}"; do
    echo ""
    echo "Validating: $page"
    echo "-------------------"
    
    # Download the page and validate
    curl -s "$page" > temp_amp_page.html
    
    if [ $? -eq 0 ]; then
        amphtml-validator temp_amp_page.html
        if [ $? -eq 0 ]; then
            echo "✅ $page - VALID"
        else
            echo "❌ $page - INVALID"
        fi
    else
        echo "❌ Failed to fetch $page"
    fi
    
    # Clean up
    rm -f temp_amp_page.html
done

echo ""
echo "🎯 AMP Validation Complete!"
echo "=========================="
echo ""
echo "📋 Next Steps:"
echo "1. Fix any validation errors shown above"
echo "2. Test your AMP pages in Chrome DevTools"
echo "3. Use Google's AMP Test Tool: https://search.google.com/test/amp"
echo "4. Submit your AMP pages to Google Search Console"
echo ""
echo "💡 Tips:"
echo "- Add #development=1 to your AMP URLs for detailed debugging"
echo "- Check the browser console for additional validation messages"
echo "- Ensure all images have proper width/height attributes"
