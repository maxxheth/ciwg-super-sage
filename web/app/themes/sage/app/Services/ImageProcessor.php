<?php

namespace App\Services;

class ImageProcessor
{
    /**
     * Default quality for WebP compression
     * 
     * @var int
     */
    protected $defaultQuality = 80;
    
    /**
     * Default max size in KB
     * 
     * @var int
     */
    protected $defaultMaxSize = 300;
    
    /**
     * Process an image with the specified settings
     * 
     * @param int $attachmentId The attachment ID
     * @param array $options Compression options
     * @return array|WP_Error The result or error
     */
    public function process($attachmentId, $options = [])
    {
        // Get attachment file path
        $filePath = get_attached_file($attachmentId);
        if (!$filePath || !file_exists($filePath)) {
            return new \WP_Error('missing_file', __('The uploaded file could not be found.', 'sage'));
        }
        
        // Skip if not an image
        if (!wp_attachment_is_image($attachmentId)) {
            return new \WP_Error('not_image', __('This file is not an image.', 'sage'));
        }
        
        // Get compression options with defaults
        $quality = isset($options['quality']) ? (int)$options['quality'] : $this->defaultQuality;
        $maxSize = isset($options['max_size']) ? (int)$options['max_size'] : $this->defaultMaxSize;
        $convertToWebP = isset($options['convert_webp']) ? (bool)$options['convert_webp'] : true;
        
        // Process the image
        $result = $this->convertAndCompress($filePath, $attachmentId, [
            'quality' => $quality,
            'maxSize' => $maxSize,
            'convertToWebP' => $convertToWebP
        ]);
        
        if (is_wp_error($result)) {
            return $result;
        }
        
        // Update attachment metadata
        update_post_meta($attachmentId, '_compressed_with_webp', '1');
        update_post_meta($attachmentId, '_compression_quality', $quality);
        update_post_meta($attachmentId, '_original_size', filesize($filePath) / 1024);
        update_post_meta($attachmentId, '_compressed_size', filesize($result) / 1024);
        
        // Generate WordPress metadata for the new file
        $metadata = wp_generate_attachment_metadata($attachmentId, $result);
        
        // Important: Update attachment metadata in WordPress database
        wp_update_attachment_metadata($attachmentId, $metadata);
        
        // Clean attachment cache to refresh thumbnails
        clean_attachment_cache($attachmentId);
        
        return [
            'metadata' => $metadata,
            'new_file' => $result,
            'old_size' => filesize($filePath) / 1024,
            'new_size' => filesize($result) / 1024,
        ];
    }
    
    /**
     * Convert image to WebP format and compress
     * 
     * @param string $filePath Original file path
     * @param int $attachmentId Attachment ID
     * @param array $options Processing options
     * @return string|WP_Error New file path or error
     */
    protected function convertAndCompress($filePath, $attachmentId, $options)
    {
        // Check if GD is available with WebP support
        if (!function_exists('imagewebp')) {
            return new \WP_Error('webp_not_supported', __('WebP conversion is not supported on this server.', 'sage'));
        }
        
        // Get image type
        $imageType = exif_imagetype($filePath);
        $image = null;
        
        // Create image resource based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($filePath);
                // Handle transparency
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($filePath);
                break;
            case IMAGETYPE_WEBP:
                // Already WebP, just need to check size and possibly compress
                $image = imagecreatefromwebp($filePath);
                break;
            default:
                return new \WP_Error('unsupported_image_type', __('The image type is not supported for WebP conversion.', 'sage'));
        }
        
        if (!$image) {
            return new \WP_Error('image_create_failed', __('Failed to create image resource.', 'sage'));
        }
        
        // Get original image dimensions for possible resizing of very large images
        $width = imagesx($image);
        $height = imagesy($image);
        
        // If image is very large, resize it to prevent memory issues
        $maxDimension = 2500;
        if ($width > $maxDimension || $height > $maxDimension) {
            if ($width > $height) {
                $newWidth = $maxDimension;
                $newHeight = intval($height * ($maxDimension / $width));
            } else {
                $newHeight = $maxDimension;
                $newWidth = intval($width * ($maxDimension / $height));
            }
            
            // Create a resized version
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency if needed
            if ($imageType === IMAGETYPE_PNG) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            }
            
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }
        
        // Create new file path
        $pathInfo = pathinfo($filePath);
        $newFilePath = $options['convertToWebP'] ? 
            $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp' :
            $filePath . '.compressed.' . $pathInfo['extension'];
        
        // Initial quality
        $quality = $options['quality'];
        $attempts = 0;
        $maxAttempts = 5;
        
        // Try compressing until file size is under the limit or max attempts reached
        while ($attempts < $maxAttempts) {
            // Save image in appropriate format
            if ($options['convertToWebP']) {
                imagewebp($image, $newFilePath, $quality);
            } else {
                switch ($imageType) {
                    case IMAGETYPE_JPEG:
                        imagejpeg($image, $newFilePath, $quality);
                        break;
                    case IMAGETYPE_PNG:
                        // PNG uses 0-9 compression level
                        $pngQuality = 9 - min(9, floor($quality / 10));
                        imagepng($image, $newFilePath, $pngQuality);
                        break;
                    case IMAGETYPE_GIF:
                        imagegif($image, $newFilePath);
                        break;
                    case IMAGETYPE_WEBP:
                        imagewebp($image, $newFilePath, $quality);
                        break;
                }
            }
            
            // Check file size
            $fileSize = filesize($newFilePath) / 1024; // Size in KB
            
            if ($fileSize <= $options['maxSize']) {
                break;
            }
            
            // Reduce quality for next attempt
            $quality = max(40, $quality - 10);
            $attempts++;
            
            if ($attempts >= $maxAttempts) {
                // We'll keep the last attempt even if it's over the limit
                break;
            }
        }
        
        // Free memory
        imagedestroy($image);
        
        // If we changed the format, update attachment
        if ($options['convertToWebP'] && $imageType !== IMAGETYPE_WEBP) {
            // Keep original as backup
            $backupPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.original.' . $pathInfo['extension'];
            copy($filePath, $backupPath);
            
            // Update attachment file
            unlink($filePath);
            update_attached_file($attachmentId, $newFilePath);
            
            // Update post mime type
            wp_update_post([
                'ID' => $attachmentId,
                'post_mime_type' => 'image/webp',
            ]);
        } else if (!$options['convertToWebP']) {
            // Replace original file but keep the extension
            copy($newFilePath, $filePath);
            unlink($newFilePath);
            $newFilePath = $filePath;
        }
        
        return $newFilePath;
    }
}