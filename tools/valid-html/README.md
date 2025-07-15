# HTML Syntax Validator

A PHP web application that validates HTML files for syntax errors and provides detailed feedback on issues found.

## Features

- **File Upload Interface**: Clean, modern web interface for uploading HTML files
- **Comprehensive Validation**: Checks for various types of HTML syntax errors:
  - Missing DOCTYPE declaration
  - Unbalanced opening/closing tags
  - Unquoted attribute values
  - Malformed attributes with nested quotes
  - Duplicate attributes
  - Unescaped special characters
  - Missing recommended meta tags
  - Broken links and image references
- **Detailed Error Reporting**: Shows specific line numbers and descriptions for each error
- **Warning System**: Provides warnings for best practices (missing viewport meta tag, etc.)
- **File Information**: Displays file details including size and type
- **Responsive Design**: Works on desktop and mobile devices

## Requirements

- PHP 7.0 or higher
- Web server (Apache, Nginx, or PHP built-in server)
- File upload enabled in PHP configuration

## Installation

1. **Clone or download** the files to your web server directory
2. **Ensure file uploads are enabled** in your PHP configuration:
   - Set `file_uploads = On` in `php.ini`
   - Adjust `upload_max_filesize` and `post_max_size` as needed
3. **Set proper permissions** for the web server to read the files

## Usage

### Using PHP Built-in Server (Development)

1. Open a terminal in the project directory
2. Run: `php -S localhost:8000`
3. Open your browser and go to `http://localhost:8000`

### Using Apache/Nginx

1. Place the files in your web server's document root
2. Access the application through your web browser

## How to Use

1. **Upload HTML File**: Click "Choose File" and select an HTML file (.html or .htm)
2. **Validate**: Click "Validate HTML" button
3. **Review Results**: The application will display:
   - File information (name, size, type)
   - Errors found (with line numbers)
   - Warnings (best practices)
   - Success message if no issues found

## Sample Files

The application includes two sample HTML files for testing:

- `sample_valid.html` - A properly formatted HTML file with no syntax errors
- `sample_invalid.html` - An HTML file with various syntax errors for testing the validator

## Validation Features

### Error Detection
- **Missing DOCTYPE**: Checks for proper HTML5 DOCTYPE declaration
- **Tag Balance**: Ensures all opening tags have corresponding closing tags
- **Attribute Validation**: Checks for properly quoted attribute values
- **Special Characters**: Warns about unescaped HTML entities
- **Duplicate Attributes**: Detects repeated attributes in the same tag

### Warning System
- **Missing Meta Tags**: Warns about missing charset and viewport meta tags
- **Broken Links**: Checks for potentially broken image and link references
- **Best Practices**: Suggests improvements for better HTML structure

## File Structure

```
html-validator/
├── index.php              # Main application file
├── HtmlValidator.php      # HTML validation class
├── sample_valid.html      # Sample valid HTML file
├── sample_invalid.html    # Sample invalid HTML file
└── README.md             # This file
```

## Customization

### Adding New Validation Rules

To add new validation rules, modify the `HtmlValidator.php` class:

1. Add a new private method for your validation logic
2. Call the method from the `validate()` method
3. Add errors/warnings to the appropriate arrays

### Styling

The application uses inline CSS for simplicity. To customize the appearance:

1. Extract CSS to a separate file
2. Modify the styles in `index.php`
3. Add your own CSS classes and modify the HTML structure

## Security Considerations

- The application validates file types before processing
- File uploads are restricted to HTML files
- All output is properly escaped to prevent XSS attacks
- Temporary files are handled securely

## Limitations

- The validator focuses on syntax errors, not semantic validation
- Some complex HTML structures may not be perfectly parsed
- External link validation is basic and may not catch all broken links
- The application is designed for educational and development purposes

## Troubleshooting

### Common Issues

1. **File Upload Not Working**
   - Check PHP file upload settings in `php.ini`
   - Ensure the web server has write permissions

2. **Validation Not Working**
   - Check that `HtmlValidator.php` is in the same directory as `index.php`
   - Verify PHP error reporting is enabled for debugging

3. **Large Files Not Processing**
   - Increase `upload_max_filesize` and `post_max_size` in PHP configuration
   - Consider adding file size limits in the application

## Contributing

Feel free to submit issues, feature requests, or pull requests to improve the application.

## License

This project is open source and available under the MIT License. 