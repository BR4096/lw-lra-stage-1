<?php
/**
 * Leadership Pipeline Assessment Form Renderer
 * 
 * Handles custom rendering of assessment form fields
 */

class LPA_Form_Renderer {
    
    public function __construct() {
        add_filter('gform_field_content', array($this, 'custom_slider_field'), 10, 5);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }
    
    /**
     * Enqueue required assets for custom form elements
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'lpa-assessment-styles',
            LPA_PLUGIN_URL . 'assets/css/assessment.css',
            array(),
            LPA_VERSION
        );
        
        wp_enqueue_script(
            'lpa-assessment-scripts',
            LPA_PLUGIN_URL . 'assets/js/assessment.js',
            array('jquery'),
            LPA_VERSION,
            true
        );
    }
    
    /**
     * Render custom slider field
     */
    public function custom_slider_field($content, $field, $value, $entry_id, $form_id) {
        // Only modify number fields with our custom class
        if ($field->type !== 'number' || strpos($field->cssClass, 'lpa-slider') === false) {
            return $content;
        }
        
        $field_id = $field->id;
        $input_id = "input_{$form_id}_{$field_id}";
        
        $html = "<div class='question-card'>";
        $html .= "<h3 class='question-title'>{$field->label}</h3>";
        
        if (!empty($field->description)) {
            $html .= "<p class='question-description'>{$field->description}</p>";
        }
        
        $html .= "<div class='slider-container' data-min='0' data-max='100' data-step='5'>";
        $html .= "<div class='slider-value'>{$value}</div>";
        $html .= "<input type='range' 
                       id='{$input_id}' 
                       name='input_{$field_id}' 
                       value='{$value}' 
                       min='0' 
                       max='100' 
                       step='5' 
                       class='lpa-range-slider' 
                       oninput='updateSliderValue(this)' 
                 />";
        $html .= "</div>";
        $html .= "</div>";
        
        return $html;
    }
}
