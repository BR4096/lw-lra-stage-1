<?php
/**
 * LPA Results Handler
 * Version: 1.0.1
 */

class LPA_Minimal_Results {
    private $wpdb;
    private $prefix = 'zwFlSeMJu_';
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        
        // Add form submission handler
        add_action('gform_after_submission_2', array($this, 'handle_form_submission'), 10, 2);
    }
    
    public function handle_form_submission($entry, $form) {
        try {
            // Start transaction
            $this->wpdb->query('START TRANSACTION');
            
            // Store assessment data
            $assessment_id = $this->store_assessment($entry);
            if (!$assessment_id) {
                throw new Exception('Failed to store assessment data');
            }
            
            // Store metrics
            if (!$this->store_metrics($assessment_id, $entry)) {
                throw new Exception('Failed to store metrics data');
            }
            
            // Store results
            if (!$this->store_results($assessment_id, $entry)) {
                throw new Exception('Failed to store results data');
            }
            
            $this->wpdb->query('COMMIT');
            
            // Store the assessment ID in form meta
            gform_update_meta($entry['id'], 'lpa_assessment_id', $assessment_id);
            
        } catch (Exception $e) {
            $this->wpdb->query('ROLLBACK');
            error_log('LPA Error: ' . $e->getMessage());
            gform_update_meta($entry['id'], 'lpa_error', $e->getMessage());
        }
    }
    
    private function store_assessment($entry) {
        $data = array(
            'entry_id' => $entry['id'],
            'respondent_name' => $entry['24.3'] . ' ' . $entry['24.6'], // Combined first and last name
            'respondent_email' => $entry['3'],
            'job_title' => $entry['4'],
            'company_size' => $entry['5'],
            'tech_team_size' => intval($entry['6']),
            'business_model' => $entry['7'],
            'tech_complexity' => $entry['8']
        );
        
        $result = $this->wpdb->insert(
            $this->prefix . 'lpa_assessments',
            $data
        );
        
        return $result ? $this->wpdb->insert_id : false;
    }
    
    private function store_metrics($assessment_id, $entry) {
        $data = array(
            'assessment_id' => $assessment_id,
            'decision_effectiveness' => intval($entry['10']),
            'team_autonomy' => intval($entry['25']),
            'leadership_success' => intval($entry['36']),
            'ready_leaders' => intval($entry['27']),
            'dependencies' => intval($entry['28'])
        );
        
        return $this->wpdb->insert(
            $this->prefix . 'lpa_metrics',
            $data
        );
    }
    
    private function store_results($assessment_id, $entry) {
        $data = array(
            'assessment_id' => $assessment_id,
            'pipeline_health' => floatval($entry['40']),
            'decision_index' => floatval($entry['41']),
            'risk_level' => floatval($entry['42']),
            'growth_capacity' => floatval($entry['43']),
            'leadership_density' => floatval($entry['44'])
        );
        
        return $this->wpdb->insert(
            $this->prefix . 'lpa_results',
            $data
        );
    }
}

// Initialize the class
add_action('init', function() {
    new LPA_Minimal_Results();
});