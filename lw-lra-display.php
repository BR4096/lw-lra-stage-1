<?php
/**
 * Plugin Name: LearnWell LRA Display
 * Description: Display Leadership Pipeline Risk Assessment results in a card layout
 * Version: 1.0.2
 */

// Previous code remains the same until display_results method

public function display_results($atts) {
    $entry_id = isset($_GET['assessment']) ? intval($_GET['assessment']) : 0;
    if (!$entry_id) {
        return '<p>No assessment specified.</p>';
    }

    // Get results and user data
    $results = $this->get_results_data($entry_id);
    $user_data = $this->get_user_data($entry_id);
    
    if (!$results || !$user_data) {
        return '<p>Assessment results not found. Please contact support if this error persists.</p>';
    }

    // Build the header section
    $output = sprintf(
        '<div class="lra-report-wrapper">
            <div class="lra-report-header">
                <h1>Leadership Pipeline Assessment Results</h1>
                <div class="lra-user-details">
                    <p>Created for: <strong>%s</strong></p>
                    <p>Role: <strong>%s</strong></p>
                    <p>Assessment Date: <strong>%s</strong></p>
                </div>
            </div>',
        esc_html($user_data->respondent_name),
        esc_html($user_data->job_title),
        esc_html(date('F j, Y', strtotime($user_data->created_at)))
    );

    // Add section title
    $output .= '<div class="lra-section-title">
                    <h2>Key Assessment Results</h2>
                    <p>Below are your organization\'s key metrics based on the assessment responses:</p>
                </div>';

    // Results cards (existing code)
    $output .= '<div class="lra-results-container">';
    // ... existing results cards code ...
    $output .= '</div>';

    // Add CTA section
    $output .= '<div class="lra-cta-section">
                    <h3>Want to Discuss Your Results?</h3>
                    <p>Book a complementary consultation to discuss your results and get personalized recommendations based on your organization\'s specific needs.</p>
                    <a href="https://lpa.learnwell.com/book-results-discussion" class="lra-cta-button">Book Your Results Discussion</a>
                </div>
            </div>';

    return $output;
}

private function get_user_data($entry_id) {
    global $wpdb;
    $assessment_id = gform_get_meta($entry_id, 'lpa_assessment_id');
    
    if (!$assessment_id) return false;
    
    $table_name = $this->prefix . 'lpa_assessments';
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$table_name} WHERE assessment_id = %d",
        $assessment_id
    ));
}