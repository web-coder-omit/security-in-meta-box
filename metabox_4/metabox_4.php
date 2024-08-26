<?php
/**
 * Plugin Name: Metabox_4
 * Plugin URI:  Plugin URL Link
 * Author:      Plugin Author Name
 * Author URI:  Plugin Author Link
 * Description: This plugin make for pratice wich is "Metabox_4".
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: mb_4
 */
//Languages file loaded
function plugin_loaded_function(){
    load_plugin_textdomain('mb_4', false, dirname(__FILE__)."/languages");

}
add_action('plugins_loaded','plugin_loaded_function');

// Metabox registration
function metabox_registration_function(){
    add_meta_box('meta_box_4', __('Your Info:','mb_4'), 'metabox_4_function', 'post');
}
add_action("admin_init","metabox_registration_function");


// Metabox display
function metabox_4_function($post){
    wp_nonce_field("your_info", "your_info_varification");
    $lebal = __("Your name:","mb_4");
    $value = get_post_meta($post->ID,'save_meta_data',true);


    $lebal2 = __("Your number:","mb_4");
    $value2 = get_post_meta($post->ID,'save_meta_data2',true);
    $Meta_html = <<<EOD
        <div>
            <label for='your_name'>{$lebal}</label>
            <input value='{$value}'  id='your_name' type='text' name='your_name'/>

            <label for='your_name2'>{$lebal2}</label>
            <input value='{$value2}'  id='your_name2' type='number' name='your_number'/>
        </div>
    EOD;
    echo $Meta_html;
}

// Meta info save
function save_meta_meta_info_function($post_id){
    if(!isset($_POST['your_info_varification']) || !wp_verify_nonce($_POST['your_info_varification'],'your_info')){
        return;
    }
// Permissions to save
    if(!current_user_can('edit_post',$post_id)){
        return;
    }

//Autosave
if(defined('DOING_AUTOSAVE')&& DOING_AUTOSAVE){
    return;
}

    if(array_key_exists('your_name',$_POST)){
        update_post_meta($post_id,'save_meta_data', $_POST['your_name']);
    }

    if(array_key_exists('your_number',$_POST)){
        update_post_meta($post_id,'save_meta_data2', $_POST['your_number']);
    }

}
add_action('save_post','save_meta_meta_info_function');





















?>