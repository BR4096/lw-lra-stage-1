# LearnWell Leadership Pipeline Risk Assessment Display

## Version 1.0.1

This WordPress plugin displays the results of Leadership Pipeline Risk Assessments in a clean, card-based layout.

### Changes in 1.0.1
- Fixed data storage issues
- Added proper form submission handling
- Improved error logging
- Updated results retrieval logic
- Added proper field mapping for form data

### Features
- Displays assessment results in responsive cards
- Shows context for each metric
- Properly formatted numerical values
- Clean, modern design with hover effects
- Secure data handling

### Usage
1. Install and activate the plugin
2. Use the shortcode `[lra_results]` on your results page
3. Results will display based on the assessment ID in the URL parameter

### Requirements
- WordPress 5.0 or higher
- Gravity Forms
- Gravity Perks

### Setup
1. Install the plugin
2. Configure Gravity Forms to redirect to results page
3. Add query parameter: `assessment={entry_id}`

### Planned Future Stages
- Stage 2: Add key recommendations and save assessments
- Stage 3: Enhanced security features
- Stage 4: Data visualization with Google Sheets integration