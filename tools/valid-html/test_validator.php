<?php
require_once 'HtmlValidator.php';

// Read the sample_valid.html file
$htmlContent = file_get_contents('sample_valid.html');

echo "=== Testing sample_valid.html ===\n";
echo "File content length: " . strlen($htmlContent) . " characters\n\n";

// Create validator and run validation
$validator = new HtmlValidator($htmlContent);
$result = $validator->validate();

echo "=== Validation Results ===\n";
echo "Errors found: " . count($result['errors']) . "\n";
echo "Warnings found: " . count($result['warnings']) . "\n\n";

if (!empty($result['errors'])) {
    echo "=== ERRORS ===\n";
    foreach ($result['errors'] as $error) {
        echo "Line " . ($error['line'] ?? 'N/A') . ": " . $error['message'] . "\n";
    }
    echo "\n";
}

if (!empty($result['warnings'])) {
    echo "=== WARNINGS ===\n";
    foreach ($result['warnings'] as $warning) {
        echo "Line " . ($warning['line'] ?? 'N/A') . ": " . $warning['message'] . "\n";
    }
    echo "\n";
}

if (empty($result['errors']) && empty($result['warnings'])) {
    echo "✅ No errors or warnings found!\n";
}
?> 