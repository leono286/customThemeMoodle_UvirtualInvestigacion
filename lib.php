<?php
/**
 * @package   theme_uvirtualinvestigacion
 * @copyright 2017 leono286 - dhabernal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_uvirtualinvestigacion_process_css($css, $theme) {

    // Set the background image for the logo.
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_uvirtualinvestigacion_set_logo($css, $logo);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_uvirtualinvestigacion_set_customcss($css, $customcss);

    return $css;
}

/**
 * Adds the logo to CSS.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_uvirtualinvestigacion_set_logo($css, $logo) {
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_uvirtualinvestigacion_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $theme = theme_config::load('uvirtualinvestigacion');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Adds any custom CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $customcss The custom CSS to add.
 * @return string The CSS which now contains our custom CSS.
 */
function theme_uvirtualinvestigacion_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Returns an object containing HTML for the areas affected by settings.
 *
 * @param renderer_base $output Pass in $OUTPUT.
 * @param moodle_page $page Pass in $PAGE.
 * @return stdClass An object with the following properties:
 *      - navbarclass A CSS class to use on the navbar. By default ''.
 *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
 *      - footnote HTML to use as a footnote. By default ''.
 */
function theme_uvirtualinvestigacion_get_html_for_settings(renderer_base $output, moodle_page $page) {
    global $CFG;
    $return = new stdClass;
    static $theme;
    if(empty($theme))
    {
        $theme = theme_config::load('uvirtualinvestigacion');
    }

    $return->navbarclass = '';
    $return->heading = html_writer::tag('div', '', array('class' => 'logo'));

    $return->footnote = '';
    if (!empty($page->theme->settings->footnote)) {
        $return->footnote = '<div class="footnote text-center">'.format_text($page->theme->settings->footnote).'</div>';
    }

    $return->html_cient_inv = '';
    if (!empty($page->theme->settings->cient_inv_header) || !empty($page->theme->settings->cient_inv_section_customhtml)){
        $section_content = '';
        if (!empty($page->theme->settings->cient_inv_header)){
            $img = html_writer::empty_tag('img',array('src' => $theme->setting_file_url('cient_inv_header', 'cient_inv_header')));
            $section_content .= html_writer::tag('div', $img, array('class' => 'section_header'));
        }
        if (!empty($page->theme->settings->cient_inv_section_customhtml)){
            $section_content .= '<div class="section_content">'.format_text($page->theme->settings->cient_inv_section_customhtml).'</div>';
            $section_content .= html_writer::tag('div', get_string('afiliationsmodalcontent', 'theme_uvirtualinvestigacion'), array('id' => 'afiliationModal', 'class' => 'modal hide fade', 'tabindex' => '-1', 'role' => 'dialog', 'aria-labelledby' => 'AfiliationsModal', 'aria-hidden' => 'true'));
        }
        $return->html_cient_inv =  html_writer::tag('div', $section_content, array('id' => 'inv_cientifica', 'class' => 'area_section'));
    }

    $return->html_form_inv = '';
    if (!empty($page->theme->settings->form_inv_header) || !empty($page->theme->settings->form_inv_section_customhtml)){
        $section_content = '';
        if (!empty($page->theme->settings->form_inv_header)){
            $img = html_writer::empty_tag('img',array('src' => $theme->setting_file_url('form_inv_header', 'form_inv_header')));
            $section_content .= html_writer::tag('div', $img, array('class' => 'section_header'));
        }
        if (!empty($page->theme->settings->form_inv_section_customhtml)){
            $section_content .= '<div class="section_content">'.format_text($page->theme->settings->form_inv_section_customhtml).'</div>';
        }
        $return->html_form_inv =  html_writer::tag('div', $section_content, array('id' => 'formacion_para_inv', 'class' => 'area_section'));
    }

    $return->html_trans_innov = '';
    if (!empty($page->theme->settings->trans_innov_header) || !empty($page->theme->settings->trans_innov_section_customhtml)){
        $section_content = '';
        if (!empty($page->theme->settings->trans_innov_header)){
            $img = html_writer::empty_tag('img',array('src' => $theme->setting_file_url('trans_innov_header', 'trans_innov_header')));
            $section_content .= html_writer::tag('div', $img, array('class' => 'section_header'));
        }
        if (!empty($page->theme->settings->trans_innov_section_customhtml)){
            $section_content .= '<div class="section_content">'.format_text($page->theme->settings->trans_innov_section_customhtml).'</div>';
        }
        $return->html_trans_innov =  html_writer::tag('div', $section_content, array('id' => 'innovacion_y_trans', 'class' => 'area_section'));
    }

    $return->html_inv_mang = '';
    if (!empty($page->theme->settings->inv_mang_header) || !empty($page->theme->settings->inv_mang_section_customhtml)){
        $section_content = '';
        if (!empty($page->theme->settings->inv_mang_header)){
            $img = html_writer::empty_tag('img',array('src' => $theme->setting_file_url('inv_mang_header', 'inv_mang_header')));
            $section_content .= html_writer::tag('div', $img, array('class' => 'section_header'));
        }
        if (!empty($page->theme->settings->inv_mang_section_customhtml)){
            $section_content .= '<div class="section_content">'.format_text($page->theme->settings->inv_mang_section_customhtml).'</div>';
        }
        $return->html_inv_mang =  html_writer::tag('div', $section_content, array('id' => 'gestion_de_inv', 'class' => 'area_section'));
    }

    return $return;
}

/**
 * 
 * @deprecated since 2.5.1
 */
function uvirtualinvestigacion_process_css() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

/**
 * 
 * @deprecated since 2.5.1
 */
function uvirtualinvestigacion_set_logo() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

/**
 * 
 * @deprecated since 2.5.1
 */
function uvirtualinvestigacion_set_customcss() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}
