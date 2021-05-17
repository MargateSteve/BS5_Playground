<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'SiteSettings.php';
class Template_Class {
    
    private $_body_class;

    protected $_content = '',
              $_css_files,
              $_js_files,
              $_headJs,
              $_meta,
              $_page_js,
              $_page_title;
    
    /**
     * Build the HTML down to the opening body tag and include extra css
     *
     * Creates the opening <doctype> and <html> tags, inserts the <head>
     * tag before finally creating the opening <body> tag. The closing <body>
     * and <html> tags are created in the bodyEnd() function.
     *
     * The <head> is created via the head() function and contains the global
     * css and meta tags as well as and page-specific ones requested when the
     * template was called.
	 *
	 * @return string 					Template to the opening <body> tag
	 */
    protected function bodyStart () {

        // Start off by specifying the doctype
        $out = ' <!doctype html>';

        // Open the html tag
        $out .= '<html lang="en" class="h-100">';

        /*
            Include the <head> section, including any page-specific css, js or meta tags.

            It uses the head() function from within this file, which access various $this variables set in the __construct() in T_Main, passed in via the view, so we do not need to pass any arguments in when calling it.
         */
        $out .= self::head ();

        // Open the body tag
        $out .= '<body class="'.$this->get_body_class ().'">';
        // Echo out everything created in the function
        echo $out;
    } // bodyStart()
    
    /**
	 * Finish the HTML
	 *
	 * @return string 					Template for the end of the HTML
	 */
    protected function bodyEnd () {

	/**
         * Include any extra js
         *
         * If a page needs any extra js apart from the default, this will
         * have been specified using an $include array when calling new T_Main_Template.
         *
         * These will be set using their Globals::get() reference
         *
         * @var array/null
         */
        $out = self::scripts ();

        if($this->_page_js) {
            $out .= '<script>$(document).ready(function(){';
            $out .= $this->_page_js;
            $out .= '});</script>';
        }

        // Close the body tag
        $out .= '</body>';

        // Close the html tag
        $out .= '</html>';

        // Echo out everything created in the function
        echo $out;

    } // bodyEnd()
    
    /**
	 * Build the <head> section
	 *
	 * Builds the entire <head> tag and includes any global or
	 * page specific css and meta tags.
	 *
	 * @return     string      <head> section
	 */
    private function head () {
        /*
            We build the contents of the <head> gradually so we create a $out
            variable containing the opening tag and concatenate to it as we go along.
         */
	$out = '<head>';

	/*
            Include the <meta> tags

            Each of the meta tags should initially be stored in the meta_tags()
            function in '/app/core/SiteSettings.php' with a default content to be used
            if an alternative is not set.

            For page specific meta tags, set a key/pairing array in the view as
            $params['meta'] with the name and content of each once you want to
            overwrite.

            You can also set global meta tags manually and this is required for any
            that do not use a name and content combination.
         */
        $out .=  ' <meta charset="utf-8">'
                . '<meta name="viewport" content="width=device-width, initial-scale=1">';

        /*
            As there may be overrides for some of the meta tags set in the page/view, we initially store the default meta tags in a $tags variable so it can be easily manipulated.
         */
        $out .= SiteSettings::meta_tags($this->_meta, $type=$this->_t_type);
 
	/*
            Set the Page Title

            If the page title has been passed in from the view, show the site name, set as 'site_name' in the database settings table followed by a colon and then the page title.
            Otherwise, it just shows the site name.

            You can change this to suit your needs.
         */
	$title = ($this->get_page_title ()) ? SiteSettings::$_site_name .': '.$this->get_page_title (): SiteSettings::$_site_name;
        $out .=  '<title>' . $title. '</title>';

	// Link the Favicon
	$out .=  '<link rel="shortcut icon" href="/favicon.ico">';

        /*
            Call in the stylesheets

            Again, you can have global style sheets as well as page-specific ones. Wherever they are set, they are called from the css() function in '/app/core/SiteSettings.php'.

            These are set in a multidimensional array and return the full stylesheet link as a string. When setting, simply set the path to the stylesheet separated by slashes so 'remote/bootstrap/v4' would return the string at 'remote' => 'bootstrap' => 'v4'.

            To include any globally, simply concatenate them to the $out variable.

            To include any page specific, pass them in via the view as a $params['css'] array, simply using the path string as outlined above.

            Note that you will need to be careful with the order of these to ensure there are no class name conflicts. As you can see, here we have set 'local/site' after everything else to ensure it is the last one called and therefore takes priority.

            Before anything else, we set any required global third party ones.
         */
        $out .= SiteSettings::css($this->_css_files, $type=$this->_t_type);

        if(isset($this->_headJs)) {
            if($this->_headJs) {
                $out .= '<script>'.$this->_headJs.'</script>';
            }
        }
        // Close the head tag
        $out .=  '</head>';

        // Echo the $out variable
		echo $out;

    } // head()
    
    private function get_body_class () {
        return (isset($this->_body_class)) ? $this->_body_class:'';
    }
    
    public function set_body_class($c) {
        $this->_body_class = $c;
    }
    
    public function set_meta($m) {
        $this->_meta = $m;
   } // set_content()

    public function set_css_files($c) {
         $this->_css_files = $c;
        
    } // set_content()

    public function set_js_files($j) {
        $this->_js_files = $j;
    } // set_content()
    
    public function set_page_js($j) {
        $this->_page_js = $j;
    } // set_content()

    public function set_headJs($j) {
        $this->_headJs = $j;
    } // set_content()
    
    /**
	 * Build the required scripts
	 *
	 * Builds any required js and third party scripts
	 *
	 * @return string          			<head> section
	 */
    private function scripts () {
        $out = '';
        $out .= SiteSettings::js($this->_js_files, $type=$this->_t_type);
        // Echo the $out variable
        echo $out;
    } // scripts()
    
    protected function get_content () {
        echo $this->_content;
    }
    
    public function set_user_alert() {
        $o = '<div class="row">';
        $o .= Session::flash('userAlert');
        $o .= '</div><!-- row -->';
        
        $this->_content .= $o;
    } // set_content()
    
    public function set_content($c) {
        $this->_content .= $c;
    } // set_content()
    
    protected function get_page_title () {
        return (isset($this->_page_title)) ? $this->_page_title:false;
    }

    protected function get_page_subtitle () {
        return (isset($this->_page_subtitle)) ? $this->_page_subtitle:false;
    }
    
    

    
    
}