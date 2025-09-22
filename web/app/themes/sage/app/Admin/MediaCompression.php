<?php

namespace App\Admin;

use App\Services\ImageProcessor;

class MediaCompression
{
    /**
     * Initialize the media compression functionality
     */
    public function __construct()
    {
        // Add compression fields to attachment details
        add_filter('attachment_fields_to_edit', [$this, 'addCompressionFields'], 10, 2);
        
        // Save compression fields
        add_filter('attachment_fields_to_save', [$this, 'saveCompressionFields'], 10, 2);
        
        // Add AJAX action for compression
        add_action('wp_ajax_compress_image', [$this, 'compressImage']);
        
        // Add compression column to media library
        add_filter('manage_media_columns', [$this, 'addCompressionColumn']);
        add_action('manage_media_custom_column', [$this, 'displayCompressionColumn'], 10, 2);
        
        // Add bulk action
        add_filter('bulk_actions-upload', [$this, 'registerBulkActions']);
        add_filter('handle_bulk_actions-upload', [$this, 'handleBulkActions'], 10, 3);
        
        // Add admin notices for bulk compression results
        add_action('admin_notices', [$this, 'displayBulkActionResults']);
    }
    
    /**
     * Add compression fields to attachment details
     */
    public function addCompressionFields($form_fields, $post)
    {
        // Only add to image attachments
        if (!wp_attachment_is_image($post->ID)) {
            return $form_fields;
        }
        
        $compressed = get_post_meta($post->ID, '_compressed_with_webp', true);
        $quality = get_post_meta($post->ID, '_compression_quality', true) ?: 80;
        $originalSize = get_post_meta($post->ID, '_original_size', true);
        $compressedSize = get_post_meta($post->ID, '_compressed_size', true);
        
        $html = '<div class="compression-controls">';
        
        // Add quality slider
        $html .= '<label for="attachment-compression-quality">Quality:</label>';
        $html .= '<input type="range" name="attachments[' . $post->ID . '][compression_quality]" 
                id="attachment-compression-quality" value="' . esc_attr($quality) . '" 
                min="10" max="100" step="5">';
        $html .= '<span class="quality-value">' . esc_html($quality) . '%</span>';
        
        // Add max size field
        $html .= '<label for="attachment-max-size">Target Max Size (KB):</label>';
        $html .= '<input type="number" name="attachments[' . $post->ID . '][max_size]" 
                id="attachment-max-size" value="100" min="50" max="1000">';
        
        // Add WebP conversion checkbox
        $html .= '<label><input type="checkbox" name="attachments[' . $post->ID . '][convert_webp]" 
                id="attachment-convert-webp" value="1" checked> Convert to WebP</label>';
        
        // Add compression button
        $html .= '<button type="button" class="button compress-image-button" 
                data-id="' . esc_attr($post->ID) . '">Compress Image</button>';
        
        // Show compression info if available
        if ($compressed) {
            $html .= '<div class="compression-info">';
            $html .= '<p>Image compressed: ' . esc_html(date('F j, Y', strtotime(get_post_meta($post->ID, '_compressed_date', true)))) . '</p>';
            
            if ($originalSize && $compressedSize) {
                $savingsPercent = round((($originalSize - $compressedSize) / $originalSize) * 100, 1);
                $html .= '<p>Original: ' . round($originalSize, 1) . ' KB / Compressed: ' . round($compressedSize, 1) . ' KB</p>';
                $html .= '<p>Saved: ' . esc_html($savingsPercent) . '% (' . round($originalSize - $compressedSize, 1) . ' KB)</p>';
            }
            
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        // Add AJAX script
        $html .= "
        <script type='text/javascript'>
        jQuery(document).ready(function($) {
            $('.compress-image-button').on('click', function() {
                var button = $(this);
                var id = button.data('id');
                var quality = $('#attachment-compression-quality').val();
                var maxSize = $('#attachment-max-size').val();
                var convertWebP = $('#attachment-convert-webp').is(':checked') ? 1 : 0;
                
                button.text('Compressing...').prop('disabled', true);
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'compress_image',
                        id: id,
                        quality: quality,
                        max_size: maxSize,
                        convert_webp: convertWebP,
                        nonce: '" . wp_create_nonce('compress_image') . "'
                    },
                    success: function(response) {
                        if (response.success) {
                            button.text('Compress Again');
                            $('.compression-info').remove();
                            button.after('<div class=\"compression-info\"><p>Image compressed successfully!</p>' +
                                '<p>Original: ' + response.data.old_size.toFixed(1) + ' KB / Compressed: ' + 
                                response.data.new_size.toFixed(1) + ' KB</p>' +
                                '<p>Saved: ' + response.data.savings + '% (' + 
                                (response.data.old_size - response.data.new_size).toFixed(1) + ' KB)</p></div>');
                            
                            // Improved thumbnail refresh approach
                            if (convertWebP) {
                                // Force thumbnail refresh for WebP converted images
                                var timestamp = new Date().getTime();
                                
                                // Find all thumbnails in the current view and update them
                                $('.wp-post-image, .thumbnail img, .details .image img, .attachment-preview img').each(function() {
                                    var imgSrc = $(this).attr('src');
                                    // Remove any existing cache-busting parameters
                                    imgSrc = imgSrc.split('?')[0]; 
                                    // Add timestamp to bust cache
                                    $(this).attr('src', imgSrc + '?t=' + timestamp);
                                });
                                
                                // Optional: reload the entire media frame after a short delay
                                setTimeout(function() {
                                    if (typeof wp !== 'undefined' && wp.media && wp.media.frame) {
                                        wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
                                        wp.media.frame.content.get().options.selection.reset();
                                    }
                                }, 500);
                            }
                        } else {
                            button.after('<div class=\"error\"><p>' + response.data + '</p></div>');
                        }
                        button.prop('disabled', false);
                    },
                    error: function() {
                        button.text('Compress Image').prop('disabled', false);
                        button.after('<div class=\"error\"><p>An error occurred during compression.</p></div>');
                    }
                });
            });
            
            // Update quality value display
            $('#attachment-compression-quality').on('input', function() {
                $('.quality-value').text($(this).val() + '%');
            });
        });
        </script>
        <style>
        .compression-controls {
            margin-top: 10px;
        }
        .compression-controls label {
            display: block;
            margin-top: 5px;
        }
        .compression-info {
            margin-top: 10px;
            padding: 8px;
            background: #f0f8ff;
            border-left: 4px solid #2271b1;
        }
        .compression-info p {
            margin: 5px 0;
        }
        </style>
        ";
        
        $form_fields['compression'] = [
            'label' => __('Image Compression', 'sage'),
            'input' => 'html',
            'html' => $html,
        ];
        
        return $form_fields;
    }
    
    /**
     * Save compression field values
     */
    public function saveCompressionFields($post, $attachment)
    {
        if (isset($attachment['compression_quality'])) {
            update_post_meta($post['ID'], '_compression_quality', $attachment['compression_quality']);
        }
        
        return $post;
    }
    
    /**
     * AJAX handler for image compression
     */
    public function compressImage()
    {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'compress_image')) {
            wp_send_json_error('Security check failed');
        }
        
        $id = intval($_POST['id']);
        $quality = intval($_POST['quality']);
        $maxSize = intval($_POST['max_size']);
        $convertWebP = (bool)$_POST['convert_webp'];
        
        // Check permissions
        if (!current_user_can('edit_post', $id)) {
            wp_send_json_error('Permission denied');
        }
        
        // Process the image
        $processor = new ImageProcessor();
        $result = $processor->process($id, [
            'quality' => $quality,
            'max_size' => $maxSize,
            'convert_webp' => $convertWebP
        ]);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }
        
        // Save compression date
        update_post_meta($id, '_compressed_date', current_time('mysql'));
        
        // Calculate savings percentage
        $savings = round((($result['old_size'] - $result['new_size']) / $result['old_size']) * 100, 1);
        
        wp_send_json_success([
            'old_size' => $result['old_size'],
            'new_size' => $result['new_size'],
            'savings' => $savings
        ]);
    }
    
    /**
     * Add a compression column to the media library
     */
    public function addCompressionColumn($columns)
    {
        $columns['compression'] = __('Compression', 'sage');
        return $columns;
    }
    
    /**
     * Display compression information in the custom column
     */
    public function displayCompressionColumn($column_name, $post_id)
    {
        if ($column_name !== 'compression' || !wp_attachment_is_image($post_id)) {
            return;
        }
        
        $compressed = get_post_meta($post_id, '_compressed_with_webp', true);
        
        if ($compressed) {
            $originalSize = get_post_meta($post_id, '_original_size', true);
            $compressedSize = get_post_meta($post_id, '_compressed_size', true);
            
            if ($originalSize && $compressedSize) {
                $savingsPercent = round((($originalSize - $compressedSize) / $originalSize) * 100, 1);
                echo esc_html($savingsPercent) . '% saved<br>';
                echo round($compressedSize, 1) . ' KB';
            } else {
                echo 'Compressed';
            }
        } else {
            echo '<span style="color:#999;">Not compressed</span>';
        }
    }
    
    /**
     * Register bulk actions
     */
    public function registerBulkActions($bulk_actions)
    {
        $bulk_actions['compress_images'] = __('Compress Images', 'sage');
        return $bulk_actions;
    }
    
    /**
     * Handle bulk compression
     */
    public function handleBulkActions($redirect_to, $action, $post_ids)
    {
        if ($action !== 'compress_images') {
            return $redirect_to;
        }
        
        $processor = new ImageProcessor();
        $processed = 0;
        $failed = 0;
        $total_saved = 0;
        
        foreach ($post_ids as $post_id) {
            if (!wp_attachment_is_image($post_id)) {
                continue;
            }
            
            $quality = get_post_meta($post_id, '_compression_quality', true) ?: 80;
            
            $result = $processor->process($post_id, [
                'quality' => $quality,
                'max_size' => 300,
                'convert_webp' => true
            ]);
            
            if (is_wp_error($result)) {
                $failed++;
            } else {
                $processed++;
                $total_saved += $result['old_size'] - $result['new_size'];
                update_post_meta($post_id, '_compressed_date', current_time('mysql'));
            }
        }
        
        $redirect_to = add_query_arg([
            'compressed' => $processed,
            'failed' => $failed,
            'total_saved' => round($total_saved / 1024, 2), // Convert to MB
        ], $redirect_to);
        
        return $redirect_to;
    }
    
    /**
     * Display bulk action results
     */
    public function displayBulkActionResults()
    {
        if (!empty($_REQUEST['compressed'])) {
            $processed = intval($_REQUEST['compressed']);
            $failed = intval($_REQUEST['failed']);
            $saved = floatval($_REQUEST['total_saved']);
            
            echo '<div class="notice notice-success is-dismissible"><p>';
            printf(
                __('Compression complete: %1$d images compressed, %2$d failed. Total saved: %3$.2f MB.', 'sage'),
                $processed,
                $failed,
                $saved
            );
            echo '</p></div>';
        }
    }
}