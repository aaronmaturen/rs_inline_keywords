<?php
#
# Setup page for the sample plugin
#
# This page can be displayed by choosing Team Centre > Manage Plugins and clicking on Options
# for the sample plugin after it has been activated. It is used to override the default values
# of the plugin's configuration variables.
#
# In addition to this sample, there's also a template in the same directory as this file. You
# may find it an easier starting point for writing a setup page for your own plugin.
#

// Do the include and authorization checking ritual
include '../../../include/db.php';
include '../../../include/authenticate.php'; if (!checkperm('a')) {exit ($lang['error-permissiondenied']);}
include '../../../include/general.php';

// Specify the name of this plugin, the heading to display for the page and the
// optional introductory text.
$plugin_name = 'inline_keywords';
$page_heading = $lang['inline_keywords_heading'];
$page_intro = '<p>' . $lang['inline_keywords_frontm'] . '</p>';

// Build the $page_def array of descriptions of each configuration variable the sample uses.
// Each element of $page_def describes one configuration variable. Each description is
// created by one of the config_add_xxxx helper functions. See their definitions and
// descriptions in include/plugin_functions for more information.
//
// The sample plugin has four configuration variables:
//
// 1) $inline_keywords_pets_owned is a string array variable whose values are drawn from
//    the indices of the array $lang['inline_keywords_pet_type_list']. For the UI the textual
//    description for this variable is in $lang['inline_keywords_pets_owned']. We use
//    config_add_multi_select() because we want a multi-select UI for this variable.
// 2) $inline_keywords_favorite_pet_type is a string variable whose value is drawn from the indices
//    of the array $lang['inline_keywords_pet_type_list']. Its UI description is in
//    $lang['inline_keywords_favorite_pet_type']. We want a single-select UI.
// 3) $inline_keywords_favorite_pet_name is a string variable whose value is typed by the user.
//    The description for the UI is in $lang['inline_keywords_favorite_pet_name']
// 4) $inline_keywords_favorite_pet_living is a boolean variable. Normally the UI for a boolean
//    displays the choices "False" and "True" (in the local language) but here we
//    specify we want it to show "No" and "Yes" (in the local language).
  
$page_def[] = config_add_text_input('inline_keywords_usertype', $lang['inline_keywords_usertype'] );
$page_def[] = config_add_text_input('inline_keywords_background_colour', $lang['inline_keywords_background_colour']);
$page_def[] = config_add_boolean_select('inline_keywords_clear_fields_on_submit',$lang['inline_keywords_clear_fields_on_submit'], $lang['no-yes']);
// Do the page generation ritual
$upload_status = config_gen_setup_post($page_def, $plugin_name);
include '../../../include/header.php';
config_gen_setup_html($page_def, $plugin_name, $upload_status, $page_heading, $page_intro);
include '../../../include/footer.php';