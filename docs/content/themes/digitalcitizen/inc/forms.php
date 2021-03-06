<?php

add_action( 'wp_forms_register', 'register_my_form', 10, 0 );

function register_my_form() {
    wp_register_form( 'digitalcitizen-subscribe-form', 'subscribe_form_callback' );
    wp_register_form( 'digitalcitizen-contribute-form', 'contribute_form_callback' );
}

function subscribe_form_callback( $form ) {
    $form
        ->add_element(
            WP_Form_Element::create('text')
                ->set_name('first_name')
                ->set_label(__('First Name','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('text')
                ->set_name('last_name')
                ->set_label(__('Last Name','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('email')
                ->set_name('email-Primary')
                ->set_label(__('Email Address','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('submit')
                ->set_name('_qf_Edit_next')
                ->set_value(__('Submit','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('hidden')
                ->set_name('gid')
                ->set_value('51')
        )
        ->add_element(
            WP_form_Element::create('hidden')
                ->set_name('entryURL')
                ->set_value('https://supporters.eff.org/civicrm/profile/create?gid=51&amp;reset=1/field/add?reset=1&amp;amp;action=add&amp;amp;gid=51')
        );

    $form->add_validator('subscribe_form_validator', 10);

    $form->set_action('https://supporters.eff.org/civicrm/profile/create?gid=51&reset=1');
}

function subscribe_form_validator($submission, $form) {
    if($submission->get_value('first_name') == '') {
        $submission->add_error('first_name','This field is required');
    }
    if($submission->get_value('last_name') == '') {
        $submission->add_error('last_name','This field is required');
    }
    if($submission->get_value('email') == '') {
        $submission->add_error('email', 'This field is required');
    }
    if(!filter_var($submission->get_value('email'), FILTER_VALIDATE_EMAIL) ) {
        $submission->add_error('email', 'Please enter a valid email address');
    }
}

function contribute_form_callback( $form ) {
    $form
        ->add_element(
            WP_Form_Element::create('text')
                ->set_name('first_name')
                ->set_label(__('First Name','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('text')
                ->set_name('last_name')
                ->set_label(__('Last Name','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('email')
                ->set_name('email')
                ->set_label(__('Email Address','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('text')
                ->set_name('url')
                ->set_label(__('Submission URL','digitalcitizen'))
        )
        ->add_element(
            WP_form_Element::create('select')
                ->set_name('country')
                ->set_label(__('Country','digitalcitizen'))
                ->add_option("AF",__("Afghanistan","digitalcitizen"))
                ->add_option("AX",__("Åland Islands","digitalcitizen"))
                ->add_option("AL",__("Albania","digitalcitizen"))
                ->add_option("DZ",__("Algeria","digitalcitizen"))
                ->add_option("AS",__("American Samoa","digitalcitizen"))
                ->add_option("AD",__("Andorra","digitalcitizen"))
                ->add_option("AO",__("Angola","digitalcitizen"))
                ->add_option("AI",__("Anguilla","digitalcitizen"))
                ->add_option("AQ",__("Antarctica","digitalcitizen"))
                ->add_option("AG",__("Antigua and Barbuda","digitalcitizen"))
                ->add_option("AR",__("Argentina","digitalcitizen"))
                ->add_option("AM",__("Armenia","digitalcitizen"))
                ->add_option("AW",__("Aruba","digitalcitizen"))
                ->add_option("AU",__("Australia","digitalcitizen"))
                ->add_option("AT",__("Austria","digitalcitizen"))
                ->add_option("AZ",__("Azerbaijan","digitalcitizen"))
                ->add_option("BS",__("Bahamas","digitalcitizen"))
                ->add_option("BH",__("Bahrain","digitalcitizen"))
                ->add_option("BD",__("Bangladesh","digitalcitizen"))
                ->add_option("BB",__("Barbados","digitalcitizen"))
                ->add_option("BY",__("Belarus","digitalcitizen"))
                ->add_option("BE",__("Belgium","digitalcitizen"))
                ->add_option("BZ",__("Belize","digitalcitizen"))
                ->add_option("BJ",__("Benin","digitalcitizen"))
                ->add_option("BM",__("Bermuda","digitalcitizen"))
                ->add_option("BT",__("Bhutan","digitalcitizen"))
                ->add_option("BO",__("Bolivia, Plurinational State of","digitalcitizen"))
                ->add_option("BQ",__("Bonaire, Sint Eustatius and Saba","digitalcitizen"))
                ->add_option("BA",__("Bosnia and Herzegovina","digitalcitizen"))
                ->add_option("BW",__("Botswana","digitalcitizen"))
                ->add_option("BV",__("Bouvet Island","digitalcitizen"))
                ->add_option("BR",__("Brazil","digitalcitizen"))
                ->add_option("IO",__("British Indian Ocean Territory","digitalcitizen"))
                ->add_option("BN",__("Brunei Darussalam","digitalcitizen"))
                ->add_option("BG",__("Bulgaria","digitalcitizen"))
                ->add_option("BF",__("Burkina Faso","digitalcitizen"))
                ->add_option("BI",__("Burundi","digitalcitizen"))
                ->add_option("KH",__("Cambodia","digitalcitizen"))
                ->add_option("CM",__("Cameroon","digitalcitizen"))
                ->add_option("CA",__("Canada","digitalcitizen"))
                ->add_option("CV",__("Cape Verde","digitalcitizen"))
                ->add_option("KY",__("Cayman Islands","digitalcitizen"))
                ->add_option("CF",__("Central African Republic","digitalcitizen"))
                ->add_option("TD",__("Chad","digitalcitizen"))
                ->add_option("CL",__("Chile","digitalcitizen"))
                ->add_option("CN",__("China","digitalcitizen"))
                ->add_option("CX",__("Christmas Island","digitalcitizen"))
                ->add_option("CC",__("Cocos (Keeling) Islands","digitalcitizen"))
                ->add_option("CO",__("Colombia","digitalcitizen"))
                ->add_option("KM",__("Comoros","digitalcitizen"))
                ->add_option("CG",__("Congo","digitalcitizen"))
                ->add_option("CD",__("Congo, the Democratic Republic of the","digitalcitizen"))
                ->add_option("CK",__("Cook Islands","digitalcitizen"))
                ->add_option("CR",__("Costa Rica","digitalcitizen"))
                ->add_option("CI",__("Côte d'Ivoire","digitalcitizen"))
                ->add_option("HR",__("Croatia","digitalcitizen"))
                ->add_option("CU",__("Cuba","digitalcitizen"))
                ->add_option("CW",__("Curaçao","digitalcitizen"))
                ->add_option("CY",__("Cyprus","digitalcitizen"))
                ->add_option("CZ",__("Czech Republic","digitalcitizen"))
                ->add_option("DK",__("Denmark","digitalcitizen"))
                ->add_option("DJ",__("Djibouti","digitalcitizen"))
                ->add_option("DM",__("Dominica","digitalcitizen"))
                ->add_option("DO",__("Dominican Republic","digitalcitizen"))
                ->add_option("EC",__("Ecuador","digitalcitizen"))
                ->add_option("EG",__("Egypt","digitalcitizen"))
                ->add_option("SV",__("El Salvador","digitalcitizen"))
                ->add_option("GQ",__("Equatorial Guinea","digitalcitizen"))
                ->add_option("ER",__("Eritrea","digitalcitizen"))
                ->add_option("EE",__("Estonia","digitalcitizen"))
                ->add_option("ET",__("Ethiopia","digitalcitizen"))
                ->add_option("FK",__("Falkland Islands (Malvinas)","digitalcitizen"))
                ->add_option("FO",__("Faroe Islands","digitalcitizen"))
                ->add_option("FJ",__("Fiji","digitalcitizen"))
                ->add_option("FI",__("Finland","digitalcitizen"))
                ->add_option("FR",__("France","digitalcitizen"))
                ->add_option("GF",__("French Guiana","digitalcitizen"))
                ->add_option("PF",__("French Polynesia","digitalcitizen"))
                ->add_option("TF",__("French Southern Territories","digitalcitizen"))
                ->add_option("GA",__("Gabon","digitalcitizen"))
                ->add_option("GM",__("Gambia","digitalcitizen"))
                ->add_option("GE",__("Georgia","digitalcitizen"))
                ->add_option("DE",__("Germany","digitalcitizen"))
                ->add_option("GH",__("Ghana","digitalcitizen"))
                ->add_option("GI",__("Gibraltar","digitalcitizen"))
                ->add_option("GR",__("Greece","digitalcitizen"))
                ->add_option("GL",__("Greenland","digitalcitizen"))
                ->add_option("GD",__("Grenada","digitalcitizen"))
                ->add_option("GP",__("Guadeloupe","digitalcitizen"))
                ->add_option("GU",__("Guam","digitalcitizen"))
                ->add_option("GT",__("Guatemala","digitalcitizen"))
                ->add_option("GG",__("Guernsey","digitalcitizen"))
                ->add_option("GN",__("Guinea","digitalcitizen"))
                ->add_option("GW",__("Guinea-Bissau","digitalcitizen"))
                ->add_option("GY",__("Guyana","digitalcitizen"))
                ->add_option("HT",__("Haiti","digitalcitizen"))
                ->add_option("HM",__("Heard Island and McDonald Islands","digitalcitizen"))
                ->add_option("VA",__("Holy See (Vatican City State)","digitalcitizen"))
                ->add_option("HN",__("Honduras","digitalcitizen"))
                ->add_option("HK",__("Hong Kong","digitalcitizen"))
                ->add_option("HU",__("Hungary","digitalcitizen"))
                ->add_option("IS",__("Iceland","digitalcitizen"))
                ->add_option("IN",__("India","digitalcitizen"))
                ->add_option("ID",__("Indonesia","digitalcitizen"))
                ->add_option("IR",__("Iran, Islamic Republic of","digitalcitizen"))
                ->add_option("IQ",__("Iraq","digitalcitizen"))
                ->add_option("IE",__("Ireland","digitalcitizen"))
                ->add_option("IM",__("Isle of Man","digitalcitizen"))
                ->add_option("IL",__("Israel","digitalcitizen"))
                ->add_option("IT",__("Italy","digitalcitizen"))
                ->add_option("JM",__("Jamaica","digitalcitizen"))
                ->add_option("JP",__("Japan","digitalcitizen"))
                ->add_option("JE",__("Jersey","digitalcitizen"))
                ->add_option("JO",__("Jordan","digitalcitizen"))
                ->add_option("KZ",__("Kazakhstan","digitalcitizen"))
                ->add_option("KE",__("Kenya","digitalcitizen"))
                ->add_option("KI",__("Kiribati","digitalcitizen"))
                ->add_option("KP",__("Korea, Democratic People's Republic of","digitalcitizen"))
                ->add_option("KR",__("Korea, Republic of","digitalcitizen"))
                ->add_option("KW",__("Kuwait","digitalcitizen"))
                ->add_option("KG",__("Kyrgyzstan","digitalcitizen"))
                ->add_option("LA",__("Lao People's Democratic Republic","digitalcitizen"))
                ->add_option("LV",__("Latvia","digitalcitizen"))
                ->add_option("LB",__("Lebanon","digitalcitizen"))
                ->add_option("LS",__("Lesotho","digitalcitizen"))
                ->add_option("LR",__("Liberia","digitalcitizen"))
                ->add_option("LY",__("Libya","digitalcitizen"))
                ->add_option("LI",__("Liechtenstein","digitalcitizen"))
                ->add_option("LT",__("Lithuania","digitalcitizen"))
                ->add_option("LU",__("Luxembourg","digitalcitizen"))
                ->add_option("MO",__("Macao","digitalcitizen"))
                ->add_option("MK",__("Macedonia, the former Yugoslav Republic of","digitalcitizen"))
                ->add_option("MG",__("Madagascar","digitalcitizen"))
                ->add_option("MW",__("Malawi","digitalcitizen"))
                ->add_option("MY",__("Malaysia","digitalcitizen"))
                ->add_option("MV",__("Maldives","digitalcitizen"))
                ->add_option("ML",__("Mali","digitalcitizen"))
                ->add_option("MT",__("Malta","digitalcitizen"))
                ->add_option("MH",__("Marshall Islands","digitalcitizen"))
                ->add_option("MQ",__("Martinique","digitalcitizen"))
                ->add_option("MR",__("Mauritania","digitalcitizen"))
                ->add_option("MU",__("Mauritius","digitalcitizen"))
                ->add_option("YT",__("Mayotte","digitalcitizen"))
                ->add_option("MX",__("Mexico","digitalcitizen"))
                ->add_option("FM",__("Micronesia, Federated States of","digitalcitizen"))
                ->add_option("MD",__("Moldova, Republic of","digitalcitizen"))
                ->add_option("MC",__("Monaco","digitalcitizen"))
                ->add_option("MN",__("Mongolia","digitalcitizen"))
                ->add_option("ME",__("Montenegro","digitalcitizen"))
                ->add_option("MS",__("Montserrat","digitalcitizen"))
                ->add_option("MA",__("Morocco","digitalcitizen"))
                ->add_option("MZ",__("Mozambique","digitalcitizen"))
                ->add_option("MM",__("Myanmar","digitalcitizen"))
                ->add_option("NA",__("Namibia","digitalcitizen"))
                ->add_option("NR",__("Nauru","digitalcitizen"))
                ->add_option("NP",__("Nepal","digitalcitizen"))
                ->add_option("NL",__("Netherlands","digitalcitizen"))
                ->add_option("NC",__("New Caledonia","digitalcitizen"))
                ->add_option("NZ",__("New Zealand","digitalcitizen"))
                ->add_option("NI",__("Nicaragua","digitalcitizen"))
                ->add_option("NE",__("Niger","digitalcitizen"))
                ->add_option("NG",__("Nigeria","digitalcitizen"))
                ->add_option("NU",__("Niue","digitalcitizen"))
                ->add_option("NF",__("Norfolk Island","digitalcitizen"))
                ->add_option("MP",__("Northern Mariana Islands","digitalcitizen"))
                ->add_option("NO",__("Norway","digitalcitizen"))
                ->add_option("OM",__("Oman","digitalcitizen"))
                ->add_option("PK",__("Pakistan","digitalcitizen"))
                ->add_option("PW",__("Palau","digitalcitizen"))
                ->add_option("PS",__("Palestinian Territory, Occupied","digitalcitizen"))
                ->add_option("PA",__("Panama","digitalcitizen"))
                ->add_option("PG",__("Papua New Guinea","digitalcitizen"))
                ->add_option("PY",__("Paraguay","digitalcitizen"))
                ->add_option("PE",__("Peru","digitalcitizen"))
                ->add_option("PH",__("Philippines","digitalcitizen"))
                ->add_option("PN",__("Pitcairn","digitalcitizen"))
                ->add_option("PL",__("Poland","digitalcitizen"))
                ->add_option("PT",__("Portugal","digitalcitizen"))
                ->add_option("PR",__("Puerto Rico","digitalcitizen"))
                ->add_option("QA",__("Qatar","digitalcitizen"))
                ->add_option("RE",__("Réunion","digitalcitizen"))
                ->add_option("RO",__("Romania","digitalcitizen"))
                ->add_option("RU",__("Russian Federation","digitalcitizen"))
                ->add_option("RW",__("Rwanda","digitalcitizen"))
                ->add_option("BL",__("Saint Barthélemy","digitalcitizen"))
                ->add_option("SH",__("Saint Helena, Ascension and Tristan da Cunha","digitalcitizen"))
                ->add_option("KN",__("Saint Kitts and Nevis","digitalcitizen"))
                ->add_option("LC",__("Saint Lucia","digitalcitizen"))
                ->add_option("MF",__("Saint Martin (French part)","digitalcitizen"))
                ->add_option("PM",__("Saint Pierre and Miquelon","digitalcitizen"))
                ->add_option("VC",__("Saint Vincent and the Grenadines","digitalcitizen"))
                ->add_option("WS",__("Samoa","digitalcitizen"))
                ->add_option("SM",__("San Marino","digitalcitizen"))
                ->add_option("ST",__("Sao Tome and Principe","digitalcitizen"))
                ->add_option("SA",__("Saudi Arabia","digitalcitizen"))
                ->add_option("SN",__("Senegal","digitalcitizen"))
                ->add_option("RS",__("Serbia","digitalcitizen"))
                ->add_option("SC",__("Seychelles","digitalcitizen"))
                ->add_option("SL",__("Sierra Leone","digitalcitizen"))
                ->add_option("SG",__("Singapore","digitalcitizen"))
                ->add_option("SX",__("Sint Maarten (Dutch part)","digitalcitizen"))
                ->add_option("SK",__("Slovakia","digitalcitizen"))
                ->add_option("SI",__("Slovenia","digitalcitizen"))
                ->add_option("SB",__("Solomon Islands","digitalcitizen"))
                ->add_option("SO",__("Somalia","digitalcitizen"))
                ->add_option("ZA",__("South Africa","digitalcitizen"))
                ->add_option("GS",__("South Georgia and the South Sandwich Islands","digitalcitizen"))
                ->add_option("SS",__("South Sudan","digitalcitizen"))
                ->add_option("ES",__("Spain","digitalcitizen"))
                ->add_option("LK",__("Sri Lanka","digitalcitizen"))
                ->add_option("SD",__("Sudan","digitalcitizen"))
                ->add_option("SR",__("Suriname","digitalcitizen"))
                ->add_option("SJ",__("Svalbard and Jan Mayen","digitalcitizen"))
                ->add_option("SZ",__("Swaziland","digitalcitizen"))
                ->add_option("SE",__("Sweden","digitalcitizen"))
                ->add_option("CH",__("Switzerland","digitalcitizen"))
                ->add_option("SY",__("Syrian Arab Republic","digitalcitizen"))
                ->add_option("TW",__("Taiwan, Province of China","digitalcitizen"))
                ->add_option("TJ",__("Tajikistan","digitalcitizen"))
                ->add_option("TZ",__("Tanzania, United Republic of","digitalcitizen"))
                ->add_option("TH",__("Thailand","digitalcitizen"))
                ->add_option("TL",__("Timor-Leste","digitalcitizen"))
                ->add_option("TG",__("Togo","digitalcitizen"))
                ->add_option("TK",__("Tokelau","digitalcitizen"))
                ->add_option("TO",__("Tonga","digitalcitizen"))
                ->add_option("TT",__("Trinidad and Tobago","digitalcitizen"))
                ->add_option("TN",__("Tunisia","digitalcitizen"))
                ->add_option("TR",__("Turkey","digitalcitizen"))
                ->add_option("TM",__("Turkmenistan","digitalcitizen"))
                ->add_option("TC",__("Turks and Caicos Islands","digitalcitizen"))
                ->add_option("TV",__("Tuvalu","digitalcitizen"))
                ->add_option("UG",__("Uganda","digitalcitizen"))
                ->add_option("UA",__("Ukraine","digitalcitizen"))
                ->add_option("AE",__("United Arab Emirates","digitalcitizen"))
                ->add_option("GB",__("United Kingdom","digitalcitizen"))
                ->add_option("US",__("United States","digitalcitizen"))
                ->add_option("UM",__("United States Minor Outlying Islands","digitalcitizen"))
                ->add_option("UY",__("Uruguay","digitalcitizen"))
                ->add_option("UZ",__("Uzbekistan","digitalcitizen"))
                ->add_option("VU",__("Vanuatu","digitalcitizen"))
                ->add_option("VE",__("Venezuela, Bolivarian Republic of","digitalcitizen"))
                ->add_option("VN",__("Viet Nam","digitalcitizen"))
                ->add_option("VG",__("Virgin Islands, British","digitalcitizen"))
                ->add_option("VI",__("Virgin Islands, U.S.","digitalcitizen"))
                ->add_option("WF",__("Wallis and Futuna","digitalcitizen"))
                ->add_option("EH",__("Western Sahara","digitalcitizen"))
                ->add_option("YE",__("Yemen","digitalcitizen"))
                ->add_option("ZM",__("Zambia","digitalcitizen"))
                ->add_option("ZW",__("Zimbabwe","digitalcitizen"))
        )
        ->add_element(
            WP_form_Element::create('submit')
                ->set_name('submit')
                ->set_value(__('Submit','digitalcitizen'))
        )
        ->add_validator('contribute_form_validator', 10)
        ->add_processor('contribute_form_processor', 10 );
}

function contribute_form_validator($submission, $form){
    //Validation logic goes here
}

function contribute_form_processor( $submission, $form ) {
    $post = array(
        'post_title'     => "Oh Hello There",
        'post_status'    => 'publish',
        'post_type'      => 'submission',
        'post_author'    => '0'
    );
    $id = wp_insert_post( $post );
    $values = [];
    foreach( $form->get_children() as $element ) {
        if($element->type == "hidden" || $element->type == "submit") continue;
        add_post_meta($id, $element->get_attribute('name'), $submission->get_value($element->get_attribute('name')) );
    }
}

add_action( 'init', 'create_my_post_types' );

function create_my_post_types() {
    global $wp_roles;

    $caps = array(
        'publish_posts' => 'publish_submissions',
        'edit_posts' => 'edit_submissions',
        'edit_published_posts' => 'edit_published_submissions',
        'edit_others_posts' => 'edit_others_submissions',
        'delete_posts' => 'delete_submissions',
        'delete_others_posts' => 'delete_others_submissions',
        'read_private_posts' => 'read_private_submissions',
        'edit_post' => 'edit_submission',
        'delete_post' => 'delete_submission',
        'read_post' => 'read_submission',
    );

    register_post_type(
        'submission',
        array(
            'public' => false,
            'show_ui' => true,
            'menu_position' => 10,
            'map_meta_cap' => true,
            'supports' => array('custom-fields'),
            'capability_type' => 'submission',
            'capabilities' => $caps,
            'labels' => array(
                'name'               => _x( 'Submission', 'post type general name' ),
                'singular_name'      => _x( 'Submission', 'post type singular name' ),
                'add_new'            => _x( 'Add New', 'submission' ),
                'add_new_item'       => __( 'Add New Submission' ),
                'edit_item'          => __( 'Edit Submission' ),
                'new_item'           => __( 'New Submission' ),
                'all_items'          => __( 'All Submissions' ),
                'view_item'          => __( 'View Submission' ),
                'search_items'       => __( 'Search Submission' ),
                'not_found'          => __( 'No submissions found' ),
                'not_found_in_trash' => __( 'No submissions found in the Trash' ),
                'parent_item_colon'  => '',
                'menu_name'          => 'Submissions'
            )
        )
    );

    foreach($caps as $cap) {
        $wp_roles->add_cap( 'administrator', $cap );
    }
}

?>
