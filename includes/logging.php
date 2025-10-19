<?php
/**
 * Logging and error handling for BCN Theme
 *
 * @package BCN_WP_Theme
 * @since 1.0.0
 */

namespace BCN\Theme;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Log levels
 */
const LOG_LEVEL_ERROR = 'error';
const LOG_LEVEL_WARNING = 'warning';
const LOG_LEVEL_INFO = 'info';
const LOG_LEVEL_DEBUG = 'debug';

/**
 * Log a message with context
 *
 * @param string $message Log message
 * @param string $level Log level
 * @param array $context Additional context
 */
function log_message($message, $level = LOG_LEVEL_INFO, $context = array()) {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }

    $timestamp = current_time('Y-m-d H:i:s');
    $context_string = !empty($context) ? ' | Context: ' . wp_json_encode($context) : '';
    $log_message = "[{$timestamp}] [BCN] [{$level}] {$message}{$context_string}";

    error_log($log_message);
}

/**
 * Log an error
 *
 * @param string $message Error message
 * @param array $context Additional context
 */
function log_error($message, $context = array()) {
    log_message($message, LOG_LEVEL_ERROR, $context);
}

/**
 * Log a warning
 *
 * @param string $message Warning message
 * @param array $context Additional context
 */
function log_warning($message, $context = array()) {
    log_message($message, LOG_LEVEL_WARNING, $context);
}

/**
 * Log info
 *
 * @param string $message Info message
 * @param array $context Additional context
 */
function log_info($message, $context = array()) {
    log_message($message, LOG_LEVEL_INFO, $context);
}

/**
 * Log debug info
 *
 * @param string $message Debug message
 * @param array $context Additional context
 */
function log_debug($message, $context = array()) {
    log_message($message, LOG_LEVEL_DEBUG, $context);
}

/**
 * Handle member onboarding errors
 *
 * @param string $error_code Error code
 * @param string $error_message Error message
 * @param array $context Additional context
 * @return WP_Error
 */
function handle_member_onboarding_error($error_code, $error_message, $context = array()) {
    log_error("Member onboarding failed: {$error_message}", array_merge($context, array('error_code' => $error_code)));
    
    return new \WP_Error(
        $error_code,
        $error_message,
        array_merge($context, array('status' => 400))
    );
}

/**
 * Handle member submission errors
 *
 * @param string $error_code Error code
 * @param string $error_message Error message
 * @param array $context Additional context
 * @return WP_Error
 */
function handle_member_submission_error($error_code, $error_message, $context = array()) {
    log_error("Member submission failed: {$error_message}", array_merge($context, array('error_code' => $error_code)));
    
    return new \WP_Error(
        $error_code,
        $error_message,
        array_merge($context, array('status' => 400))
    );
}

/**
 * Log successful member operations
 *
 * @param string $operation Operation performed
 * @param int $member_id Member post ID
 * @param array $context Additional context
 */
function log_member_success($operation, $member_id, $context = array()) {
    log_info("Member {$operation} successful", array_merge($context, array('member_id' => $member_id)));
}

/**
 * Log API requests
 *
 * @param string $endpoint API endpoint
 * @param string $method HTTP method
 * @param int $response_code Response code
 * @param array $context Additional context
 */
function log_api_request($endpoint, $method, $response_code, $context = array()) {
    $level = $response_code >= 400 ? LOG_LEVEL_ERROR : LOG_LEVEL_INFO;
    log_message(
        "API request: {$method} {$endpoint} - {$response_code}",
        $level,
        array_merge($context, array(
            'endpoint' => $endpoint,
            'method' => $method,
            'response_code' => $response_code,
        ))
    );
}

/**
 * Log database operations
 *
 * @param string $operation Database operation
 * @param string $table Table name
 * @param array $context Additional context
 */
function log_db_operation($operation, $table, $context = array()) {
    log_debug("Database operation: {$operation} on {$table}", $context);
}

/**
 * Log theme activation/deactivation
 *
 * @param string $action Action performed
 * @param array $context Additional context
 */
function log_theme_lifecycle($action, $context = array()) {
    log_info("Theme {$action}", $context);
}

/**
 * Log performance metrics
 *
 * @param string $operation Operation name
 * @param float $execution_time Execution time in seconds
 * @param array $context Additional context
 */
function log_performance($operation, $execution_time, $context = array()) {
    $level = $execution_time > 1.0 ? LOG_LEVEL_WARNING : LOG_LEVEL_DEBUG;
    log_message(
        "Performance: {$operation} took {$execution_time}s",
        $level,
        array_merge($context, array(
            'operation' => $operation,
            'execution_time' => $execution_time,
        ))
    );
}

/**
 * Log security events
 *
 * @param string $event Security event
 * @param array $context Additional context
 */
function log_security_event($event, $context = array()) {
    log_warning("Security event: {$event}", $context);
}

/**
 * Get log entries for admin display
 *
 * @param int $limit Number of entries to retrieve
 * @return array Log entries
 */
function get_log_entries($limit = 50) {
    if (!defined('WP_DEBUG_LOG') || !WP_DEBUG_LOG) {
        return array();
    }

    $log_file = WP_CONTENT_DIR . '/debug.log';
    if (!file_exists($log_file)) {
        return array();
    }

    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $bcn_logs = array();

    foreach (array_reverse($lines) as $line) {
        if (strpos($line, '[BCN]') !== false) {
            $bcn_logs[] = $line;
            if (count($bcn_logs) >= $limit) {
                break;
            }
        }
    }

    return $bcn_logs;
}

/**
 * Clear log entries
 */
function clear_logs() {
    if (!defined('WP_DEBUG_LOG') || !WP_DEBUG_LOG) {
        return false;
    }

    $log_file = WP_CONTENT_DIR . '/debug.log';
    if (file_exists($log_file)) {
        return file_put_contents($log_file, '') !== false;
    }

    return false;
}

/**
 * Add admin page for log viewing
 */
function add_log_admin_page() {
    add_management_page(
        __('BCN Logs', 'bcn-wp-theme'),
        __('BCN Logs', 'bcn-wp-theme'),
        'manage_options',
        'bcn-logs',
        __NAMESPACE__ . '\\render_log_admin_page'
    );
}
add_action('admin_menu', __NAMESPACE__ . '\\add_log_admin_page');

/**
 * Render log admin page
 */
function render_log_admin_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['clear_logs']) && wp_verify_nonce($_POST['_wpnonce'], 'bcn_clear_logs')) {
        if (clear_logs()) {
            echo '<div class="notice notice-success"><p>' . esc_html__('Logs cleared successfully.', 'bcn-wp-theme') . '</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>' . esc_html__('Failed to clear logs.', 'bcn-wp-theme') . '</p></div>';
        }
    }

    $logs = get_log_entries(100);
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('BCN Theme Logs', 'bcn-wp-theme'); ?></h1>
        
        <form method="post" style="margin-bottom: 20px;">
            <?php wp_nonce_field('bcn_clear_logs'); ?>
            <input type="submit" name="clear_logs" class="button" value="<?php esc_attr_e('Clear Logs', 'bcn-wp-theme'); ?>" onclick="return confirm('<?php esc_attr_e('Are you sure you want to clear all logs?', 'bcn-wp-theme'); ?>');" />
        </form>

        <div style="background: #f1f1f1; padding: 10px; font-family: monospace; font-size: 12px; max-height: 500px; overflow-y: auto;">
            <?php if (empty($logs)) : ?>
                <p><?php esc_html_e('No logs found.', 'bcn-wp-theme'); ?></p>
            <?php else : ?>
                <?php foreach ($logs as $log) : ?>
                    <div style="margin-bottom: 5px; padding: 5px; background: white; border-left: 3px solid #0073aa;">
                        <?php echo esc_html($log); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
}