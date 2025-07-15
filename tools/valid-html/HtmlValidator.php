<?php

/**
 * HTML Syntax Validator Class
 * Provides comprehensive HTML syntax validation
 */
class HtmlValidator {
    
    private $errors = [];
    private $warnings = [];
    private $html;
    private $lines;
    
    /**
     * Constructor
     * @param string $html HTML content to validate
     */
    public function __construct($html) {
        $this->html = $html;
        $this->lines = explode("\n", $html);
    }
    
    /**
     * Perform comprehensive HTML validation
     * @return array Array containing 'errors' and 'warnings'
     */
    public function validate() {
        $this->errors = [];
        $this->warnings = [];
        
        $this->validateBasicStructure();
        $this->validateTagBalance();
        $this->validateAttributes();
        $this->validateSpecialCharacters();
        $this->validateDoctype();
        $this->validateMetaTags();
        $this->validateLinks();
        
        return [
            'errors' => $this->errors,
            'warnings' => $this->warnings
        ];
    }
    
    /**
     * Validate basic HTML structure
     */
    private function validateBasicStructure() {
        // Check for DOCTYPE
        if (!preg_match('/<!DOCTYPE\s+html/i', $this->html)) {
            $this->errors[] = [
                'type' => 'structure',
                'line' => $this->findLineContaining('<!DOCTYPE'),
                'message' => 'Missing DOCTYPE declaration',
                'severity' => 'error'
            ];
        }
        
        // Check for html tag
        if (!preg_match('/<html[^>]*>/i', $this->html)) {
            $this->errors[] = [
                'type' => 'structure',
                'line' => $this->findLineContaining('<html'),
                'message' => 'Missing <html> tag',
                'severity' => 'error'
            ];
        }
        
        // Check for head tag
        if (!preg_match('/<head[^>]*>/i', $this->html)) {
            $this->warnings[] = [
                'type' => 'structure',
                'line' => $this->findLineContaining('<head'),
                'message' => 'Missing <head> tag (recommended for proper HTML structure)',
                'severity' => 'warning'
            ];
        }
        
        // Check for body tag
        if (!preg_match('/<body[^>]*>/i', $this->html)) {
            $this->warnings[] = [
                'type' => 'structure',
                'line' => $this->findLineContaining('<body'),
                'message' => 'Missing <body> tag (recommended for proper HTML structure)',
                'severity' => 'warning'
            ];
        }
        
        // Check for closing html tag
        if (!preg_match('/<\/html>/i', $this->html)) {
            $this->errors[] = [
                'type' => 'structure',
                'line' => $this->findLineContaining('</html>'),
                'message' => 'Missing closing </html> tag',
                'severity' => 'error'
            ];
        }
    }
    
    /**
     * Validate tag balance (opening/closing tags)
     */
    private function validateTagBalance() {
        $openTags = [];
        $selfClosingTags = ['img', 'br', 'hr', 'input', 'meta', 'link', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'];
        
        foreach ($this->lines as $lineNumber => $line) {
            $lineNumber++; // Convert to 1-based indexing
            
            // Find opening tags
            preg_match_all('/<([a-zA-Z][a-zA-Z0-9]*)([^>]*)>/', $line, $matches, PREG_OFFSET_CAPTURE);
            foreach ($matches[1] as $index => $match) {
                $tagName = strtolower($match[0]);
                $fullTag = $matches[0][$index][0];
                
                // Skip self-closing tags
                if (preg_match('/\/>$/', $fullTag) || in_array($tagName, $selfClosingTags)) {
                    continue;
                }
                
                $openTags[] = [
                    'tag' => $tagName,
                    'line' => $lineNumber,
                    'fullTag' => $fullTag
                ];
            }
            
            // Find closing tags
            preg_match_all('/<\/([a-zA-Z][a-zA-Z0-9]*)>/', $line, $matches, PREG_OFFSET_CAPTURE);
            foreach ($matches[1] as $match) {
                $tagName = strtolower($match[0]);
                
                // Find matching opening tag
                $found = false;
                for ($i = count($openTags) - 1; $i >= 0; $i--) {
                    if ($openTags[$i]['tag'] === $tagName) {
                        array_splice($openTags, $i, 1);
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    $this->errors[] = [
                        'type' => 'tag_balance',
                        'line' => $lineNumber,
                        'message' => "Unexpected closing tag </$tagName> (no matching opening tag found)",
                        'severity' => 'error'
                    ];
                }
            }
        }
        
        // Check for unclosed tags
        foreach ($openTags as $tag) {
            $this->errors[] = [
                'type' => 'tag_balance',
                'line' => $tag['line'],
                'message' => "Unclosed tag <{$tag['tag']}> (missing closing tag)",
                'severity' => 'error'
            ];
        }
    }
    
    /**
     * Validate HTML attributes
     */
    private function validateAttributes() {
        foreach ($this->lines as $lineNumber => $line) {
            $lineNumber++;

            // Only process lines with tags that have attributes
            if (!preg_match_all('/<([a-zA-Z][a-zA-Z0-9]*)([^>]*)>/', $line, $tagMatches, PREG_SET_ORDER)) {
                continue;
            }

            foreach ($tagMatches as $tagMatch) {
                $tagName = strtolower($tagMatch[1]);
                $attrString = $tagMatch[2];

                // Skip self-closing and void elements
                if (preg_match('/\/$/', $attrString) || in_array($tagName, ['img', 'br', 'hr', 'input', 'meta', 'link', 'area', 'base', 'col', 'embed', 'source', 'track', 'wbr'])) {
                    // But still check attributes for img, input, etc.
                }

                // Skip data URIs in src/href attributes for nested quote check
                if (preg_match('/(src|href)\s*=\s*(["\"])data:/i', $attrString)) {
                    continue;
                }

                // Parse attributes using a robust regex
                if (preg_match_all('/\s([a-zA-Z_:][a-zA-Z0-9_\-:.]*)\s*=\s*("[^"]*"|\'[^"]*\'|[^\s"\'>]+)/', $attrString, $attrMatches, PREG_SET_ORDER)) {
                    $attrNames = [];
                    foreach ($attrMatches as $attrMatch) {
                        $attrName = $attrMatch[1];
                        $attrValue = $attrMatch[2];
                        $attrNames[] = $attrName;
                        // Check for unquoted attribute values
                        if (!(($attrValue[0] === '"' && substr($attrValue, -1) === '"') || ($attrValue[0] === "'" && substr($attrValue, -1) === "'"))) {
                            $this->errors[] = [
                                'type' => 'attributes',
                                'line' => $lineNumber,
                                'message' => 'Unquoted attribute value for "' . $attrName . '". All attribute values should be quoted',
                                'severity' => 'error'
                            ];
                        }
                        // Check for nested quotes inside quoted value
                        if ((($attrValue[0] === '"' && substr($attrValue, -1) === '"') || ($attrValue[0] === "'" && substr($attrValue, -1) === "'")) &&
                            (strpos(substr($attrValue, 1, -1), '"') !== false || strpos(substr($attrValue, 1, -1), "'") !== false)) {
                            $this->errors[] = [
                                'type' => 'attributes',
                                'line' => $lineNumber,
                                'message' => 'Malformed attribute value for "' . $attrName . '" (nested quotes)',
                                'severity' => 'error'
                            ];
                        }
                    }
                    // Check for duplicate attributes
                    $duplicates = array_diff_assoc($attrNames, array_unique($attrNames));
                    if (!empty($duplicates)) {
                        $this->errors[] = [
                            'type' => 'attributes',
                            'line' => $lineNumber,
                            'message' => 'Duplicate attributes found: ' . implode(', ', array_unique($duplicates)),
                            'severity' => 'error'
                        ];
                    }
                }
            }
        }
    }
    
    /**
     * Validate special characters in text content
     */
    private function validateSpecialCharacters() {
        foreach ($this->lines as $lineNumber => $line) {
            $lineNumber++;
            
            // Skip lines that are mostly HTML tags
            if (preg_match('/^[\s<>\/]*$/', $line)) {
                continue;
            }
            
            // Skip lines that contain HTML tags (these are not text content)
            if (preg_match('/<[^>]+>/', $line)) {
                continue;
            }
            
            // Check for unescaped special characters in actual text content only
            // Skip lines that contain HTML entities (like &copy;, &amp;, etc.)
            if (preg_match('/[<>&](?![a-zA-Z\/!])/', $line) && !preg_match('/&[a-zA-Z]+;|&#[0-9]+;|&#x[0-9a-fA-F]+;/', $line)) {
                $this->warnings[] = [
                    'type' => 'special_characters',
                    'line' => $lineNumber,
                    'message' => 'Unescaped special characters found. Consider using HTML entities (&lt;, &gt;, &amp;) for <, >, & respectively',
                    'severity' => 'warning'
                ];
            }
        }
    }
    
    /**
     * Validate DOCTYPE declaration
     */
    private function validateDoctype() {
        if (preg_match('/<!DOCTYPE\s+([^>]+)>/i', $this->html, $matches)) {
            $doctype = trim($matches[1]);
            
            // Check for valid DOCTYPE
            if (!preg_match('/html/i', $doctype)) {
                $this->errors[] = [
                    'type' => 'doctype',
                    'line' => $this->findLineContaining('<!DOCTYPE'),
                    'message' => 'Invalid DOCTYPE declaration: ' . $doctype,
                    'severity' => 'error'
                ];
            }
        }
    }
    
    /**
     * Validate meta tags
     */
    private function validateMetaTags() {
        if (preg_match('/<meta[^>]*>/i', $this->html)) {
            // Check for charset meta tag
            if (!preg_match('/<meta[^>]*charset[^>]*>/i', $this->html)) {
                $this->warnings[] = [
                    'type' => 'meta',
                    'line' => $this->findLineContaining('<meta'),
                    'message' => 'Missing charset meta tag (recommended for proper character encoding)',
                    'severity' => 'warning'
                ];
            }
            
            // Check for viewport meta tag
            if (!preg_match('/<meta[^>]*viewport[^>]*>/i', $this->html)) {
                $this->warnings[] = [
                    'type' => 'meta',
                    'line' => $this->findLineContaining('<meta'),
                    'message' => 'Missing viewport meta tag (recommended for responsive design)',
                    'severity' => 'warning'
                ];
            }
        }
    }
    
    /**
     * Validate links and references
     */
    private function validateLinks() {
        // Check for broken image references
        preg_match_all('/<img[^>]*src\s*=\s*["\']([^"\']+)["\'][^>]*>/i', $this->html, $matches);
        foreach ($matches[1] as $src) {
            if (strpos($src, 'http') !== 0 && strpos($src, 'data:') !== 0 && !file_exists($src)) {
                $this->warnings[] = [
                    'type' => 'links',
                    'line' => $this->findLineContaining($src),
                    'message' => 'Image source may be broken: ' . $src,
                    'severity' => 'warning'
                ];
            }
        }
        
        // Check for broken link references
        preg_match_all('/<a[^>]*href\s*=\s*["\']([^"\']+)["\'][^>]*>/i', $this->html, $matches);
        foreach ($matches[1] as $href) {
            if (strpos($href, 'http') !== 0 && strpos($href, '#') !== 0 && strpos($href, 'mailto:') !== 0 && !file_exists($href)) {
                $this->warnings[] = [
                    'type' => 'links',
                    'line' => $this->findLineContaining($href),
                    'message' => 'Link may be broken: ' . $href,
                    'severity' => 'warning'
                ];
            }
        }
    }
    
    /**
     * Find the line number containing a specific string
     * @param string $search String to search for
     * @return int|null Line number or null if not found
     */
    private function findLineContaining($search) {
        foreach ($this->lines as $lineNumber => $line) {
            if (strpos($line, $search) !== false) {
                return $lineNumber + 1; // Convert to 1-based indexing
            }
        }
        return null;
    }
    
    /**
     * Get formatted error report
     * @return string Formatted HTML report
     */
    public function getFormattedReport() {
        $report = '';
        
        if (!empty($this->errors)) {
            $report .= '<div class="error-section">';
            $report .= '<h3>Errors Found:</h3>';
            foreach ($this->errors as $error) {
                $report .= '<div class="error-item">';
                if ($error['line']) {
                    $report .= '<div class="error-line">Line ' . $error['line'] . ':</div>';
                }
                $report .= '<div class="error-message">' . htmlspecialchars($error['message']) . '</div>';
                $report .= '</div>';
            }
            $report .= '</div>';
        }
        
        if (!empty($this->warnings)) {
            $report .= '<div class="warning-section">';
            $report .= '<h3>Warnings:</h3>';
            foreach ($this->warnings as $warning) {
                $report .= '<div class="warning-item">';
                if ($warning['line']) {
                    $report .= '<div class="warning-line">Line ' . $warning['line'] . ':</div>';
                }
                $report .= '<div class="warning-message">' . htmlspecialchars($warning['message']) . '</div>';
                $report .= '</div>';
            }
            $report .= '</div>';
        }
        
        if (empty($this->errors) && empty($this->warnings)) {
            $report .= '<div class="success-message">';
            $report .= '<strong>✓ HTML Syntax is Valid!</strong><br>';
            $report .= 'No syntax errors or warnings found in the uploaded HTML file.';
            $report .= '</div>';
        }
        
        return $report;
    }
} 