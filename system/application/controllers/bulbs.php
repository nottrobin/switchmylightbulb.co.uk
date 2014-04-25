<?php

class Bulbs extends Controller {
    
    private $items_per_page = 15;
    
    function __construct() {
        parent::Controller();
    }
    
    // index - the default method for this controller
    // Simply redirects to all bulbs list
    // ---
    function index() {
        $arguments = func_get_args();
        redirect('/bulbs/search/all_fields/everything/' . implode('/',$arguments),'refresh');
    }
    
    // all - redirects to search that displays everything
    // ---
    function all($page = 1) {
        $this->data['records'] = new Model_non_energy_saving_bulb();
        $this->data['records']->get_paged($page,$this->items_per_page);
        $this->data['pageable_uri'] = '/bulbs/all';
        $this->data['title'] = 'All bulbs';
        $this->data['content_template'] = 'bulbs_all.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // find_replacements - Displays energy-saving equivalents.
    // Given the ID of a non-energy-saving bulb,
    // displays all equivalent energy-saving bulbs
    // ---
    function find_replacements($non_energy_saving_bulb_id) {
        // Get related energy saving bulbs
        $non_bulb = new Model_non_energy_saving_bulb();
        $non_bulb->get_by_id($non_energy_saving_bulb_id);
        $non_bulb->energy_saving_bulb->get_iterated();
        
        // Print the new page
        $this->data['includes_adapter'] = false;
        foreach($non_bulb->energy_saving_bulb as $record) {
            if($record->requires_adapter) {$this->data['includes_adapter'] = true;}
        }
        $this->data['title'] = 'Energy-saving replacements for ' . $non_bulb->name;
        $this->data['record'] = $non_bulb;
        $this->data['content_template'] = 'bulbs_find_replacements.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // search - search non-energy-saving bulbs.
    // Matches the the chosen field name to the search term.
    // ---
    function search($field = 'all-fields', $search = 'everything', $page = 1) {
        // includes /advanced maybe?
        // search by any or multiple of the different bulb properties
        if(intval($page)) {$page = intval($page);}
        else {show_error('Invalid page number');}
        
        if(!empty($_POST)) {
            // If we have been sent post data
            // Get search and fields from post data
            if(isset($_POST['search'])) {$search = $_POST['search'];}
            if(isset($_POST['field'])) {$field = $_POST['field'];}
            
            // Check the search string doesn't just contain the placeholder text
            if($search == 'search for bulbs' || $search == '') {$search = 'everything';}
            
            redirect('/bulbs/search/'.$field.'/'.str_replace(' ','_',$search), 'refresh');
        } else {
            // If search came in on the URL replace underscores
            $search = str_replace('_',' ',$search);
        }

        // Validation
        // ==========
        
        // If we haven't been sent post data...
        $url_field_names = array(
            'all_fields','name','wattage','voltage','fitting_cap','length_mm','diameter','rated_life',
            'energy_rating','lumen_out','to_be_banned','colour_temp','dimmable','typical_price',
            'beam_angle','intensity','no_leds','equivalent_to'
        );
        
        // Check URL was decoded correctly
        if(
            empty($field) ||
            !preg_match('/^('.implode('|',$url_field_names).')$/i',$field)
        ) {
            // URL structure is wrong. Print error message.
            
            show_error("Unrecognised URL structure. Search controller requires the following URL structure (the part in square brackets [...] is optional):<br/>
                /bulbs/search/<em>&lt;field-name&gt;</em>/<em>&lt;search-string&gt;</em>[/page/<em>&lt;page-number&gt;</em>]<br/>
                <br/>
                <em>&lt;field-name&gt;</em> should be one of:<br/>
                '" . implode("', '",$url_field_names) . "'.");
        }
        
        $this->data['records'] = new Model_non_energy_saving_bulb();
        
        // Prepare search string
        if($search == 'everything') {$actual_search = '';}
        else {$actual_search = $search;}
        
        // Prepare search
        foreach(explode(' ',$actual_search) as $word) {
            $this->_compile_where($word,$field);
        }
        
        // Execute search
        $this->data['records']->get_paged($page,$this->items_per_page);
        
        // Display results
        $this->data['search'] = $search;
        $this->data['field'] = $field;
        $this->data['uri'] = $this->uri;
        $this->data['pageable_uri'] = '/bulbs/search/'.$field.'/'.$search;
        $this->data['title'] = 'Search results';
        $this->data['content_template'] = 'bulbs_search.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // information - Display information about a bulb
    // ---
    function information($bulb_type,$bulb_id) {
        // load the correct model for this bulb type
        if($bulb_type == 'energy_saving') {$this->data['record'] = new Model_energy_saving_bulb();}
        else if($bulb_type == 'non_energy_saving') {$this->data['record'] = new Model_non_energy_saving_bulb();}
        else {show_error('Unrecognised bulb type: '.$bulb_type);}
        
        // Retrieve the data
        $this->data['record']->get_by_id($bulb_id);
        
        // Load the view
        $this->data['bulb_type'] = $bulb_type;
        $this->data['title'] = $this->data['record']->name;
        $this->data['content_template'] = 'bulbs_information.php';
        $this->load->view('main_wrapper',$this->data);
    }
    
    // Admin functions
    // ===============
    
    function add() {
        // requires admin status. Maybe we just need a field in "user" called "admin?"
    }
    
    // _compile_where - helper function for "search" method
    // ---
    function _compile_where($word,$field) {
        if($field == 'all_fields' || $field == 'name') {$this->data['records']->or_where("name like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'wattage') {$this->data['records']->or_where("wattage like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'voltage') {$this->data['records']->or_where("voltage like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'fitting_cap') {$this->data['records']->or_where("fitting_cap like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'length_mm') {$this->data['records']->or_where("length_mm like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'diameter') {$this->data['records']->or_where("diameter like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'rated_life') {$this->data['records']->or_where("rated_life like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'energy_rating') {$this->data['records']->or_where("energy_rating like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'lumen_out') {$this->data['records']->or_where("lumen_out like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'to_be_banned') {
            if(preg_match('/^(true|1)$/',$word)) {$this->data['records']->or_where("to_be_banned = 1");}
            if(preg_match('/^(false|0)$/',$word)) {$this->data['records']->or_where("to_be_banned = 0");}
        }
        if($field == 'all_fields' || $field == 'colour_temp') {$this->data['records']->or_where("colour_temp like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'dimmable') {
            if(preg_match('/^(true|1)$/',$word)) {$this->data['records']->or_where("dimmable = 1");}
            if(preg_match('/^(false|0)$/',$word)) {$this->data['records']->or_where("dimmable = 0");}
        }
        if($field == 'all_fields' || $field == 'typical_price') {$this->data['records']->or_where("typical_price like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'beam_angle') {$this->data['records']->or_where("beam_angle like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'intensity') {$this->data['records']->or_where("intensity like '%" . $word . "%'");}
        if($field == 'all_fields' || $field == 'no_leds') {$this->data['records']->or_where("no_leds like '%" . $word . "%'");}
        
    }
}
