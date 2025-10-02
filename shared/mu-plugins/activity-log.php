<?php
/**
 * 000 Spamurai Guard (WSAL ONLY)
 * - Force-loads: wp-security-audit-log/wp-security-audit-log.php
 * - Only role "Spamurai" can see/use anything related.
 * - Everyone else (admins & all other roles) = no menus/pages/wizards/REST/AJAX/plugin rows.
 * - Suppresses update nags for WSAL.
 * - Emulates WSAL CLI (hide plugin + skip wizard) without WP-CLI.
 */
defined('ABSPATH') || exit;

const SPAMURAI_ROLE  = 'spamurai';
const WSAL_BASENAME  = 'wp-security-audit-log/wp-security-audit-log.php';

add_action('init', function () {
    if (!get_role(SPAMURAI_ROLE)) add_role(SPAMURAI_ROLE, 'Spamurai', ['read'=>true]);
}, 1);

function is_spamurai(): bool {
    $u = wp_get_current_user();
    return $u && in_array(SPAMURAI_ROLE, (array)$u->roles, true);
}

/* -------------------------------------------------------------------------- */
/* (A) FORCE-LOAD EXACTLY THESE TWO PLUGINS (if not already active/MU)        */
/* -------------------------------------------------------------------------- */
add_action('muplugins_loaded', function () {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';

    foreach ([WSAL_BASENAME] as $basename) {
        if (function_exists('is_plugin_active') && is_plugin_active($basename)) continue;

        $loaded = false;
        // Normal plugins dir
        $file = trailingslashit(WP_PLUGIN_DIR) . $basename;
        if (file_exists($file)) { include_once $file; $loaded = true; }

        // If someone parked it under mu-plugins in a subfolder, include that too
        if (!$loaded) {
            $mufile = trailingslashit(WPMU_PLUGIN_DIR) . $basename;
            if (file_exists($mufile)) { include_once $mufile; $loaded = true; }
        }

        // Fire activation hook once (per network) if we just loaded it
        if ($loaded) {
            $flag = 'spamurai_mu_forced_' . md5($basename);
            if (!get_site_option($flag)) {
                do_action('activate_' . $basename);
                update_site_option($flag, time());
            }
        }
    }
}, 1);

/* -------------------------------------------------------------------------- */
/* (B) WSAL: hide plugin + skip/kill wizards (CLI-equivalent, no WP-CLI)      */
/* -------------------------------------------------------------------------- */
add_action('plugins_loaded', function () {
    // Prefer WSAL Settings_Helper if present
    if (class_exists('\WSAL\Helpers\Settings_Helper')) {
        try { \WSAL\Helpers\Settings_Helper::set_option_value('hide-plugin', true); } catch (\Throwable $e) {}
        try { \WSAL\Helpers\Settings_Helper::set_option_value('redirect_on_activate', false); } catch (\Throwable $e) {}
        try { \WSAL\Helpers\Settings_Helper::delete_option_value('wsal_redirect_on_activate'); } catch (\Throwable $e) {}
        try { \WSAL\Helpers\Settings_Helper::set_option_value('freemius_state', 'skipped'); } catch (\Throwable $e) {}
    } else {
        // Fallback raw options (best-effort)
        delete_option('wsal_redirect_on_activate');
        update_option('wsal_redirect_on_activate', false);
        update_option('wsal_freemius_state', 'skipped');
        update_option('wsal_hide_plugin', 1);
    }
    if (function_exists('delete_site_transient')) delete_site_transient('update_plugins');
}, 9);

/* -------------------------------------------------------------------------- */
/* (C) Hiding/suppressing WSAL                                                */
/* -------------------------------------------------------------------------- */
function spamurai_plugin_basenames(): array { return [WSAL_BASENAME]; }

add_filter('all_plugins', function (array $plugins) {
    if (is_spamurai()) return $plugins;
    foreach (spamurai_plugin_basenames() as $b) unset($plugins[$b]);
    return $plugins;
}, 999);

$__hide_updates = static function ($transient) {
    if (!is_object($transient)) return $transient;
    foreach (spamurai_plugin_basenames() as $b) {
        unset($transient->response[$b], $transient->no_update[$b]);
    }
    return $transient;
};
add_filter('site_transient_update_plugins', $__hide_updates, 999);
add_filter('pre_set_site_transient_update_plugins', $__hide_updates, 999);

/* Hide MU + Drop-ins sections entirely for non-Spamurai (covers MU installs) */
add_filter('show_advanced_plugins', function ($show, $type) {
    if (is_spamurai()) return $show;
    if ($type === 'mustuse' || $type === 'dropins') return false;
    return $show;
}, 999, 2);

/* Also strip any MU rows that still sneak in */
add_action('pre_current_active_plugins', function () {
    if (is_spamurai()) return;
    global $wp_list_table;
    if (isset($wp_list_table->items) && is_array($wp_list_table->items)) {
        foreach ($wp_list_table->items as $k => $data) {
            $line = strtolower(is_array($data) ? implode(' ', $data) : (string)$data);
            if (strpos($line, 'wp-security-audit-log') !== false) {
                unset($wp_list_table->items[$k]);
            }
        }
    }
}, 999);

/* -------------------------------------------------------------------------- */
/* (D) Menus, pages, admin-bar, widgets — block for everyone but Spamurai      */
/* -------------------------------------------------------------------------- */
$__scrub_menus = function () {
    if (is_spamurai()) return;
    global $menu, $submenu;
    $kill = function ($arr) {
        foreach ((array)$arr as $k => $it) {
            $slug  = $it[2] ?? '';
            $title = $it[0] ?? '';
            // WSAL pages start with wsal-
            if (preg_match('/^(wsal\-)/i', (string)$slug) ||
                stripos((string)$title, 'WP Activity Log') !== false ||
                stripos((string)$title, 'WP Security Audit Log') !== false) {
                unset($arr[$k]);
            }
        }
        return $arr;
    };
    $menu = $kill($menu);
    foreach ((array)$submenu as $p => $items) $submenu[$p] = $kill($items);
};
add_action('admin_menu', $__scrub_menus, 1000);
add_action('network_admin_menu', $__scrub_menus, 1000);

add_action('admin_bar_menu', function ($bar) {
    if (is_spamurai() || !is_object($bar)) return;
    foreach (['wsal','wp-activity-log'] as $id) $bar->remove_node($id);
}, 1000);

add_action('wp_dashboard_setup', function () {
    if (is_spamurai()) return;
    global $wp_meta_boxes;
    foreach (['normal','side'] as $ctx) {
        foreach (['core','high','default','low'] as $pri) {
            if (empty($wp_meta_boxes['dashboard'][$ctx][$pri])) continue;
            foreach ($wp_meta_boxes['dashboard'][$ctx][$pri] as $id => $box) {
                $cid = is_array($box) && isset($box['id']) ? $box['id'] : $id;
                if (preg_match('/(wsal)/i', (string)$cid)) {
                    unset($wp_meta_boxes['dashboard'][$ctx][$pri][$id]);
                }
            }
        }
    }
}, 1000);

/* Direct hits to admin pages */
$__block_admin_pages = function () {
    if (!is_admin() || is_spamurai()) return;
    $page = (string)($_GET['page'] ?? '');
    if ($page && preg_match('/^(wsal\-)/i', $page)) {
        wp_die('Forbidden', 'Forbidden', 403);
    }
};
add_action('admin_init', $__block_admin_pages, 0);
add_action('network_admin_edit_', $__block_admin_pages, 0);

/* -------------------------------------------------------------------------- */
/* (E) REST & AJAX lockdown for those two plugins                              */
/* -------------------------------------------------------------------------- */
add_filter('rest_pre_dispatch', function ($result, $server, $request) {
    if (is_spamurai() || !($request instanceof WP_REST_Request)) return $result;
    $route = (string)$request->get_route();
    if (preg_match('~/(wp-activity-log|wsal)~i', $route))
        return new WP_Error('forbidden', 'Forbidden', ['status'=>403]);
    return $result;
}, 10, 3);

add_action('init', function () {
    if (wp_doing_ajax() && !is_spamurai()) {
        $action = (string)($_REQUEST['action'] ?? '');
        if ($action && preg_match('/^(wsal)/i', $action)) {
            wp_die('Forbidden', 'Forbidden', 403);
        }
    }
});

/* -------------------------------------------------------------------------- */
/* (F) JIT caps: grant Spamurai just-enough caps only on those plugin screens  */
/* -------------------------------------------------------------------------- */
add_filter('user_has_cap', function ($allcaps, $caps, $args, $user) {
    if (!is_spamurai()) {
        foreach (array_keys($allcaps) as $cap) {
            if (preg_match('/(wsal|activity[_-]?log)/i', $cap)) $allcaps[$cap] = false;
        }
        return $allcaps;
    }

    $req  = $_SERVER['REQUEST_URI'] ?? '';
    $page = (string)($_GET['page'] ?? '');
    $on_ui = (bool)(
        ($page && preg_match('/^(wsal\-)/i', $page)) ||
        (is_admin() && preg_match('/(wsal)/i', $req)) ||
        (wp_doing_ajax() && !empty($_REQUEST['action']) && preg_match('/^(wsal)/i', (string)$_REQUEST['action']))
    );
    if ($on_ui) {
        foreach (['manage_options','activate_plugins','update_plugins','wsal_view','wsal_manage','view_audit_log'] as $c) $allcaps[$c] = true;
    }
    return $allcaps;
}, 20, 4);

/* -------------------------------------------------------------------------- */
/* (G) Hide in Site Health > Info                                             */
/* -------------------------------------------------------------------------- */
add_filter('debug_information', function ($info) {
    if (is_spamurai()) return $info;
    foreach (['wp-plugins-mu','wp-mu-plugins','wp-dropins','wp-plugins-inactive','wp-plugins-active'] as $k) {
        if (isset($info[$k])) unset($info[$k]);
    }
    return $info;
}, 999);

/* -------------------------------------------------------------------------- */
/* (H) WP-CLI commands for WSAL export/status                                 */
/* -------------------------------------------------------------------------- */
if (defined('WP_CLI') && constant('WP_CLI') && class_exists('WP_CLI')) {
    if (!class_exists('WSAL_Custom_CLI')) {
        class WSAL_Custom_CLI {
            public function status() {
                $WPCLI = 'WP_CLI';
                call_user_func([$WPCLI, 'line'], 'Loader and CLI Tools for WSAL is active.');
                $wsal_loaded = class_exists('WpSecurityAuditLog');
                call_user_func([$WPCLI, 'line'], '---');
                call_user_func([$WPCLI, 'line'], 'Plugin Status:');
                call_user_func([$WPCLI, 'line'], 'WP Activity Log: ' . ($wsal_loaded ? 'Loaded' : 'Not Loaded'));
                call_user_func([$WPCLI, 'line'], '---');
            }

            public function export($args, $assoc_args) {
                $WPCLI = 'WP_CLI';
                if (!class_exists('\\WSAL\\Controllers\\Alert_Manager') || !class_exists('WpSecurityAuditLog')) {
                    call_user_func([$WPCLI, 'error'], 'WP Security Audit Log is not active or could not be loaded.');
                    return;
                }

                $count  = isset($assoc_args['count']) ? absint($assoc_args['count']) : 1000;
                $format = isset($assoc_args['format']) ? $assoc_args['format'] : 'json';

                $manager = new \WSAL\Controllers\Alert_Manager(\WpSecurityAuditLog::get_instance());
                $events  = method_exists($manager, 'get_alerts') ? $manager->get_alerts() : [];
                if (is_array($events) && $count > 0) $events = array_slice($events, 0, $count);

                if (empty($events)) {
                    call_user_func([$WPCLI, 'warning'], 'No activity log events found.');
                    return;
                }

                $output_data = [];
                foreach ($events as $event) {
                    // Handle both object and array formats
                    if (is_object($event)) {
                        $output_data[] = [
                            'alert_id'   => property_exists($event, 'id') ? $event->id : '',
                            'site_id'    => property_exists($event, 'site_id') ? $event->site_id : '',
                            'created_on' => method_exists($event, 'get_created_on') ? $event->get_created_on() : '',
                            'alert_code' => property_exists($event, 'alert_id') ? $event->alert_id : '',
                            'severity'   => method_exists($event, 'get_severity') ? $event->get_severity() : '',
                            'user_id'    => method_exists($event, 'get_user_id') ? $event->get_user_id() : '',
                            'username'   => method_exists($event, 'get_username') ? $event->get_username() : '',
                            'user_roles' => method_exists($event, 'get_user_roles') ? implode(', ', (array) $event->get_user_roles()) : '',
                            'source_ip'  => method_exists($event, 'get_source_ip') ? $event->get_source_ip() : '',
                            'message'    => method_exists($event, 'get_message') ? $event->get_message() : '',
                        ];
                    } elseif (is_array($event)) {
                        $output_data[] = [
                            'alert_id'   => $event['id'] ?? $event['alert_id'] ?? '',
                            'site_id'    => $event['site_id'] ?? '',
                            'created_on' => $event['created_on'] ?? '',
                            'alert_code' => $event['alert_id'] ?? $event['code'] ?? '',
                            'severity'   => $event['severity'] ?? '',
                            'user_id'    => $event['user_id'] ?? '',
                            'username'   => $event['username'] ?? '',
                            'user_roles' => $event['user_roles'] ?? '',
                            'source_ip'  => $event['source_ip'] ?? $event['client_ip'] ?? '',
                            'message'    => $event['message'] ?? $event['mesg'] ?? '',
                        ];
                    }
                }

                if ($format === 'json') {
                    call_user_func([$WPCLI, 'line'], json_encode($output_data, JSON_PRETTY_PRINT));
                    return;
                }

                if ($format === 'csv') {
                    $stdout = fopen('php://stdout', 'w');
                    if (!empty($output_data)) {
                        fputcsv($stdout, array_keys($output_data[0]));
                        foreach ($output_data as $row) fputcsv($stdout, $row);
                    }
                    fclose($stdout);
                    return;
                }

                call_user_func([$WPCLI, 'error'], 'Unsupported format. Use json or csv.');
            }
        }
    }

    call_user_func(['WP_CLI', 'add_command'], 'wsal-custom', 'WSAL_Custom_CLI');
}
