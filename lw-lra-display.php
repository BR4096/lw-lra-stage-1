<?php
/**
 * Plugin Name: LearnWell LRA Display
 * Description: Display Leadership Pipeline Risk Assessment results in a card layout
 * Version: 1.0.0
 * Author: LearnWell
 * License: GPL v2 or later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class LW_LRA_Display {
    private static $instance = null;
    private $prefix = 'zwFlSeMJu_';

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_shortcode('lra_results', array($this, 'display_results'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'lw-lra-styles',
            plugins_url('css/lw-lra-styles.css', __FILE__),
            array(),
            '1.0.0'
        );
    }

    private function get_result_context($metric, $value) {
        $contexts = array(
            'pipeline_health' => 'Indicates the overall health of your leadership pipeline based on succession readiness and skill development.',
            'decision_index' => 'Measures the effectiveness of decision-making processes and delegation within your organization.',
            'risk_level' => 'Quantifies potential leadership gaps and succession planning risks in dollar terms.',
            'growth_capacity' => 'Represents your organization\'s ability to scale leadership capabilities with business growth.',
            'leadership_density' => 'Shows the ratio of ready leaders to total leadership positions needed.'
        );
        
        return isset($contexts[$metric]) ? $contexts[$metric] : '';
    }

    private function get_results_data($assessment_id) {
        global $wpdb;
        
        $table_name = $this->prefix . 'lpa_results';
        $query = $wpdb->prepare(
            "SELECT * FROM {$table_name} WHERE assessment_id = %d",
            $assessment_id
        );
        
        return $wpdb->get_row($query);
    }

    private function format_value($metric, $value) {
        if ($metric === 'risk_level') {
            return '$' . number_format($value, 0);
        }
        return number_format($value, 1) . '%';
    }

    public function display_results($atts) {
        // Get assessment ID from URL parameter
        $assessment_id = isset($_GET['assessment']) ? intval($_GET['assessment']) : 0;
        if (!$assessment_id) {
            return '<p>No assessment specified.</p>';
        }

        // Get results from database
        $results = $this->get_results_data($assessment_id);
        if (!$results) {
            return '<p>Assessment results not found.</p>';
        }

        // Define metrics to display
        $metrics = array(
            'pipeline_health' => 'Pipeline Health',
            'decision_index' => 'Decision Index',
            'risk_level' => 'Risk Level',
            'growth_capacity' => 'Growth Capacity',
            'leadership_density' => 'Leadership Density'
        );

        // Build HTML output
        $output = '<div class="lra-results-container">';
        
        foreach ($metrics as $key => $label) {
            if (isset($results->$key)) {
                $value = $this->format_value($key, $results->$key);
                $context = $this->get_result_context($key, $results->$key);
                
                $output .= sprintf(
                    '<div class="lra-card">
                        <h3 class="lra-card-title">%s</h3>
                        <div class="lra-card-value">%s</div>
                        <p class="lra-card-context">%s</p>
                    </div>',
                    esc_html($label),
                    esc_html($value),
                    esc_html($context)
                );
            }
        }
        
        $output .= '</div>';
        
        return $output;
    }
}

// Initialize plugin
add_action('plugins_loaded', array('LW_LRA_Display', 'get_instance'));