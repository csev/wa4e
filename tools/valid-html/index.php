<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Syntax Validator</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .upload-form {
            text-align: center;
            margin-bottom: 30px;
        }
        .file-input {
            margin: 20px 0;
        }
        .submit-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .results {
            margin-top: 30px;
        }
        .error-list {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
        }
        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
            color: #155724;
        }
        .error-item {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #fff;
            border-left: 4px solid #dc3545;
            border-radius: 3px;
        }
        .error-line {
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            color: #721c24;
        }
        .warning-section {
            margin-top: 20px;
        }
        .warning-section h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        .warning-item {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #fff;
            border-left: 4px solid #ffc107;
            border-radius: 3px;
        }
        .warning-line {
            font-weight: bold;
            color: #856404;
        }
        .warning-message {
            color: #856404;
        }
        .file-info {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>HTML Syntax Validator</h1>
        
        <div class="upload-form">
            <form method="POST" enctype="multipart/form-data">
                <div class="file-input">
                    <label for="htmlFile">Select HTML file to validate:</label><br>
                    <input type="file" id="htmlFile" name="htmlFile" accept=".html,.htm" required>
                </div>
                <button type="submit" class="submit-btn">Validate HTML</button>
            </form>
        </div>

        <?php
        // Include the HTML validator class
        require_once 'HtmlValidator.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['htmlFile'])) {
            $uploadedFile = $_FILES['htmlFile'];
            
            // Check for upload errors
            if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
                echo '<div class="error-list">';
                echo '<strong>Upload Error:</strong> ';
                switch ($uploadedFile['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        echo 'File too large (exceeds upload_max_filesize)';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        echo 'File too large (exceeds MAX_FILE_SIZE)';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        echo 'File was only partially uploaded';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        echo 'No file was uploaded';
                        break;
                    default:
                        echo 'Unknown upload error';
                }
                echo '</div>';
            } else {
                // Validate file type
                $allowedTypes = ['text/html', 'application/xhtml+xml'];
                $fileType = mime_content_type($uploadedFile['tmp_name']);
                
                if (!in_array($fileType, $allowedTypes) && !preg_match('/\.(html|htm)$/i', $uploadedFile['name'])) {
                    echo '<div class="error-list">';
                    echo '<strong>Invalid file type:</strong> Please upload an HTML file (.html or .htm)';
                    echo '</div>';
                } else {
                    // Read the HTML content
                    $htmlContent = file_get_contents($uploadedFile['tmp_name']);
                    
                    if ($htmlContent === false) {
                        echo '<div class="error-list">';
                        echo '<strong>Error:</strong> Could not read the uploaded file';
                        echo '</div>';
                    } else {
                        // Display file info
                        echo '<div class="file-info">';
                        echo '<strong>File:</strong> ' . htmlspecialchars($uploadedFile['name']) . '<br>';
                        echo '<strong>Size:</strong> ' . number_format($uploadedFile['size']) . ' bytes<br>';
                        echo '<strong>Type:</strong> ' . htmlspecialchars($fileType);
                        echo '</div>';
                        
                        // Use the HtmlValidator class for comprehensive validation
                        $validator = new HtmlValidator($htmlContent);
                        $validationResult = $validator->validate();
                        
                        // Display the formatted report
                        echo '<div class="results">';
                        echo $validator->getFormattedReport();
                        echo '</div>';
                    }
                }
            }
        }


        ?>
    </div>
</body>
</html> 