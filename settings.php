<?php
/**
 *
 * @package   theme_uvirtualinvestigacion
 *
 */ 
 

defined('MOODLE_INTERNAL') || die;
$settings = null;

if (is_siteadmin()) {

    $ADMIN->add('themes', new admin_category('theme_uvirtualinvestigacion', get_string('pluginname', 'theme_uvirtualinvestigacion')));

    $temp = new admin_settingpage('theme_uvirtualinvestigacion_general_section', get_string('general_section', 'theme_uvirtualinvestigacion'));
    $temp->add(new admin_setting_heading('theme_uvirtualinvestigacion_general_section', get_string('general_sectionsub', 'theme_uvirtualinvestigacion'),
    format_text(get_string('general_sectiondesc', 'theme_uvirtualinvestigacion'), FORMAT_MARKDOWN)));

    $ADMIN->add('theme_uvirtualinvestigacion', $temp);
    
    // Logo file setting.
    $name = 'theme_uvirtualinvestigacion/logo';
    $title = get_string('logo','theme_uvirtualinvestigacion');
    $description = get_string('logodesc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    // Custom CSS file.
    $name = 'theme_uvirtualinvestigacion/customcss';
    $title = get_string('customcss', 'theme_uvirtualinvestigacion');
    $description = get_string('customcssdesc', 'theme_uvirtualinvestigacion');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footnote setting.
    $name = 'theme_uvirtualinvestigacion/footnote';
    $title = get_string('footnote', 'theme_uvirtualinvestigacion');
    $description = get_string('footnotedesc', 'theme_uvirtualinvestigacion');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    /*********************************************/
    
    $temp = new admin_settingpage('theme_uvirtualinvestigacion_cient_inv', get_string('cient_inv_section', 'theme_uvirtualinvestigacion'));
    $temp->add(new admin_setting_heading('theme_uvirtualinvestigacion_cient_inv', get_string('cient_inv_sectionsub', 'theme_uvirtualinvestigacion'),
    format_text(get_string('cient_inv_sectiondesc', 'theme_uvirtualinvestigacion'), FORMAT_MARKDOWN)));
    
    $ADMIN->add('theme_uvirtualinvestigacion', $temp);
    
    // Section header file.
    $name = 'theme_uvirtualinvestigacion/cient_inv_header';
    $title = get_string('section_header','theme_uvirtualinvestigacion');
    $description = get_string('section_header_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'cient_inv_header');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    //Section custos HTML
    $name = 'theme_uvirtualinvestigacion/cient_inv_section_customhtml';
    $title = get_string('section_customhtml_title', 'theme_uvirtualinvestigacion');
    $description = get_string('section_customhtml_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    /*********************************************/
    
    $temp = new admin_settingpage('theme_uvirtualinvestigacion_form_inv', get_string('form_inv_section', 'theme_uvirtualinvestigacion'));
    $temp->add(new admin_setting_heading('theme_uvirtualinvestigacion_form_inv', get_string('form_inv_sectionsub', 'theme_uvirtualinvestigacion'),
    format_text(get_string('form_inv_sectiondesc', 'theme_uvirtualinvestigacion'), FORMAT_MARKDOWN)));
    
    $ADMIN->add('theme_uvirtualinvestigacion', $temp);
    
    // Section header file.
    $name = 'theme_uvirtualinvestigacion/form_inv_header';
    $title = get_string('section_header','theme_uvirtualinvestigacion');
    $description = get_string('section_header_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'form_inv_header');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    //Section custos HTML    
    $name = 'theme_uvirtualinvestigacion/form_inv_section_customhtml';
    $title = get_string('section_customhtml_title', 'theme_uvirtualinvestigacion');
    $description = get_string('section_customhtml_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    
    /*********************************************/
    
    $temp = new admin_settingpage('theme_uvirtualinvestigacion_trans_innov', get_string('trans_innov_section', 'theme_uvirtualinvestigacion'));
    $temp->add(new admin_setting_heading('theme_uvirtualinvestigacion_trans_innov', get_string('trans_innov_sectionsub', 'theme_uvirtualinvestigacion'),
    format_text(get_string('trans_innov_sectiondesc', 'theme_uvirtualinvestigacion'), FORMAT_MARKDOWN)));
    
    $ADMIN->add('theme_uvirtualinvestigacion', $temp);
    
    // Section header file.
    $name = 'theme_uvirtualinvestigacion/trans_innov_header';
    $title = get_string('section_header','theme_uvirtualinvestigacion');
    $description = get_string('section_header_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'trans_innov_header');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    //Section custos HTML
    $name = 'theme_uvirtualinvestigacion/trans_innov_section_customhtml';
    $title = get_string('section_customhtml_title', 'theme_uvirtualinvestigacion');
    $description = get_string('section_customhtml_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    /*********************************************/
    
    $temp = new admin_settingpage('theme_uvirtualinvestigacion_inv_mang', get_string('inv_mang_section', 'theme_uvirtualinvestigacion'));
    $temp->add(new admin_setting_heading('theme_uvirtualinvestigacion_inv_mang', get_string('inv_mang_sectionsub', 'theme_uvirtualinvestigacion'),
    format_text(get_string('inv_mang_sectiondesc', 'theme_uvirtualinvestigacion'), FORMAT_MARKDOWN)));
    
    $ADMIN->add('theme_uvirtualinvestigacion', $temp);
    
    // Section header file.
    $name = 'theme_uvirtualinvestigacion/inv_mang_header';
    $title = get_string('section_header','theme_uvirtualinvestigacion');
    $description = get_string('section_header_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'inv_mang_header');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    //Section custos HTML
    $name = 'theme_uvirtualinvestigacion/inv_mang_section_customhtml';
    $title = get_string('section_customhtml_title', 'theme_uvirtualinvestigacion');
    $description = get_string('section_customhtml_desc', 'theme_uvirtualinvestigacion');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

}
