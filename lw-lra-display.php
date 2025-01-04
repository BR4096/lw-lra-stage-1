<?php
/**
 * Leadership Readiness Assessment Display Handler
 * 
 * Handles the display and rendering of LRA form elements
 * 
 * @package LeadershipReadinessAssessment
 * @version 1.0.2
 */

if (!defined('ABSPATH')) {
    exit;
}

class LW_LRA_Display {
    
    private $wpdb;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        
        // Add hooks
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_filter('gform_field_content', array($this, 'render_custom_fields'), 10, 5);
    }
    
    /**
     * Enqueue required assets
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'lw-lra-styles',
            plugin_dir_url(__FILE__) . '../css/lw-lra-styles.css',
            array(),
            LW_LRA_VERSION
        );
        
        wp_enqueue_script(
            'lw-lra-scripts',
            plugin_dir_url(__FILE__) . '../js/lw-lra-scripts.js',
            array('jquery'),
            LW_LRA_VERSION,
            true
        );
    }
    
    /**
     * Render custom form fields
     */
    public function render_custom_fields($content, $field, $value, $entry_id, $form_id) {
        if (strpos($field->cssClass, 'lra-slider') !== false) {
            return $this->render_slider_field($content, $field, $value);
        }
        return $content;
    }
    
    /**
     * Render slider field
     */
    private function render_slider_field($content, $field, $value) {
        $field_id = $field->id;
        $input_id = "input_{$field->formId}_{$field_id}";
        
        ob_start();
        ?>
        <div class="question-card">
            <h3 class="question-title"><?php echo esc_html($field->label); ?></h3>
            <?php if (!empty($field->description)) : ?>
                <p class="question-description"><?php echo esc_html($field->description); ?></p>
            <?php endif; ?>
            
            <div class="slider-container">
                <div class="slider-value"><?php echo esc_html($value); ?></div>
                <input type="range"
                       id="<?php echo esc_attr($input_id); ?>"
                       name="input_<?php echo esc_attr($field_id); ?>"
                       value="<?php echo esc_attr($value); ?>"
                       min="0"
                       max="100"
                       step="5"
                       class="lra-range-slider"
                />
                <div class="slider-labels">
                    <span>0</span>
                    <span>100</span>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the display handler
new LW_LRA_Display();
