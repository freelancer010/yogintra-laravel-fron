<?php
/**
 * API Connection Test Script
 * 
 * This script tests the connection to the trainer API to diagnose sitemap issues.
 * Run this script with: php scripts/test-api-connection.php
 */

echo "=== Testing API Connection for Trainer Data ===\n";
echo "Date/Time: " . date('Y-m-d H:i:s') . "\n";
echo "=========================================\n\n";

// API Configuration
$api_url = 'https://crm.yogintra.com/api/getTrainerSearchData';
$data = ['data' => ''];

echo "Connecting to: $api_url\n";
echo "Sending data: " . json_encode($data) . "\n\n";

try {
    // Initialize cURL session
    echo "Initializing cURL...\n";
    $ch = curl_init();
    
    // Set options
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
    // Execute cURL request
    echo "Sending request...\n";
    $start = microtime(true);
    $response = curl_exec($ch);
    $time = round(microtime(true) - $start, 2);
    
    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL ERROR: " . curl_error($ch) . "\n";
        echo "Error Code: " . curl_errno($ch) . "\n";
    } else {
        echo "Request completed in $time seconds\n";
        
        // Get HTTP status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "HTTP Status Code: $httpCode\n\n";
        
        // Parse response
        $trainers = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON Error: " . json_last_error_msg() . "\n";
            echo "Raw Response (first 500 chars):\n";
            echo substr($response, 0, 500) . "...\n";
        } else {
            if (is_array($trainers)) {
                echo "Successfully received " . count($trainers) . " trainers.\n\n";
                
                if (count($trainers) > 0) {
                    echo "First 3 trainers:\n";
                    $i = 0;
                    foreach ($trainers as $trainer) {
                        if ($i >= 3) break;
                        echo "- ID: " . ($trainer['id'] ?? 'N/A') . ", Name: " . ($trainer['name'] ?? 'N/A') . "\n";
                        echo "  URL that would be added to sitemap: " . url('/trainer/' . $trainer['id']) . "\n";
                        $i++;
                    }
                }
            } else {
                echo "ERROR: Response is not an array. Type received: " . gettype($trainers) . "\n";
            }
        }
    }
    
    curl_close($ch);
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n=========================================\n";
echo "Test completed at " . date('Y-m-d H:i:s') . "\n";

// Helper function to simulate Laravel's url() helper
function url($path) {
    // Get the hostname from server or use a default
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'www.yogintra.com';
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    
    // Ensure path starts with /
    if (substr($path, 0, 1) !== '/') {
        $path = '/' . $path;
    }
    
    return $protocol . '://' . $host . $path;
}
