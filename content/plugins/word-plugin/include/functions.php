<?php

function wsgc_include_template($template, $wsgc_errors, $wsgc_success_message) {
    include_once(HTML5_POSTER_GENERATOR_PATH . "/templates/$template.php");
}

function wsgc_is_empty($field) {
    $full_field_name = wsgc_get_full_field_name($field);

    return !isset($_POST[$full_field_name]) || empty($_POST[$full_field_name]);
}

function wsgc_get_full_field_name($name) {
    return "wordsearch-game-creator-$name";
}

function wsgc_get_post_data($name) {
    return stripslashes(wsgc_is_empty($name) ? "" : $_POST[ wsgc_get_full_field_name($name) ]);
}

function wsgc_mark_as_activation() {
    add_option('Activated_Plugin', 'wordsearch-game-creator');
}

function wsgc_is_activation() {
    return is_admin() && get_option('Activated_Plugin') == 'html5-demotivational-poster';
}

function wsgc_create_select_options($options, $field_name) {
    $selected = wsgc_get_post_data($field_name);
    $options_html = "";
    foreach ($options as $name => $value) {
        $options_html .= "<option value='$value' ";
        if ($selected === $value)
            $options_html .= "selected";
        $options_html .= ">$name</option>";
    }

    return $options_html;
}
