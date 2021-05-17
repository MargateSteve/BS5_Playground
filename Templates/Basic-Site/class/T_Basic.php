<?php

/**
 * Main Template
 *
 */
require_once '../../assets/Template_Class.php';
class T_Basic extends Template_Class {

    protected $_t_type = 'admin';
    
    public function render () {

        $this->bodyStart(); // T_Common
        $this->header ();
        $this->topNav ();
        
        echo '<main class="flex-grow-1">
                <div class="container-lg h-100">
                  <div class="bg-light p-2 h-100">';
        $this->get_content (); // T_Common
       
        echo '    </div><!-- main content -->
                </div>
              </main>';
        $this->footer ();
        $this->bodyEnd (); // T_Common

    } // render()
    
    /**
      * Build the top navigation menu
      *
      * Sets the static parts of the menu and turns Globals::get('menus/main_top_nav')
      * in the required links and dropdowns
      *
      * @return string 	nav
      */
    public function topNav () {
        // Main Site Top Navigation Menu

        $test_dropdown = [
            'Link 1' => ['link', './Link1'],
            'Link 2' => ['link', './Link2'],
            'Link 3' => ['link', './Link3'],
        ];

        $nav_items_left = [
            'Home' => ['link', '/', 'active'],
            'Link' => ['link', './Link'],
            'Disabled' => ['link', './Link', 'disabled', 'mr-auto'],
            'Dropdown' => [
                'dropdown', $test_dropdown, 'dropdown-menu-md-right'
			],

        ]; // $nav_items

        $out = '';

        $toggle_button = '<button type="button" class="navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon" style="height: 1.1em;"></span><!-- span .navbar-toggler-icon --></button>';

        $menu_left = '';

        foreach ($nav_items_left as $key => $value) {

 	    // 'type' is set as 'link'
            if($value[0] == 'link') {
                /*
                    Build a <li> with the class of .nav-item
                    Inside this put an <a> with a value of $value[1] (the link)
                    and a display of $key (the link name)
                 */
                $class_left = (isset($value[2])) ? ' '.$value[2]: '';
                $menu_left .= '<li class="nav-item';
                $menu_left .= (isset($value[3])) ? ' '.$value[3]:'';
                $menu_left .= '">';
                $menu_left .= '<a class="nav-link '.$class_left.'" href="'.$value[1].'">'.$key.'</a><!-- '.$key.' link -->';
                $menu_left .= '</li>';
            }

 	    // 'type' is set as 'dropdown'
            if($value[0] == 'dropdown') {
 		/*
                    Build a <li> with the class of .nav-item dropdown .

                    Inside this, build an <a> with a class of dropdown-toggle. This
                    will then use the Bootstap toggle class.
                    Set the id to the $key (the link name) appended with '_menu'. This
                    will be to target the correct dropdown menu. Also set the display to $key.

                    Build a <div> with the class of .dropdown-menu. Give it an
                    aria-labelledby of $key appended with '_menu' so it matches
                    the <a> that triggers it.

                    Finally, inside the div, loop through the links (stored in $value[1]) and creat an <a> for each one.
                 */
                $menu_left .= '<li class="nav-item dropdown">';
                $menu_left .= '<a id="'.$key.'_menu" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.$key.'</a><!-- '.$key.'_menu trigger -->';
                $menu_left .= '<div class="dropdown-menu';
                $menu_left .= (isset($value[2])) ? ' '.$value[2]:'';
                $menu_left .= '" aria-labelledby="'.$key.'_menu">';

                foreach ($value[1] as $links => $link) {
                    $menu_left .= '<a class="dropdown-item" href="'.$link['1'].'">'.$links.'</a><!-- a .dropdown-item -->';
                }

                $menu_left .= '</div><!-- '.$key.'_menu dropdown  -->';
                $menu_left .= '</li>';
             }
         }

        $nav_collapse = '<div class="collapse navbar-collapse order-2 order-md-1" id="navbarsExample04">  
                <ul class="nav collapse d-flex flex-column flex-md-row flex-grow-1 justify-content-start px-3">
                    '.$menu_left.'
                </ul>

                <ul class="nav d-flex flex-column flex-md-row flex-grow-1 justify-content-end px-3">
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="#">Sign out</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdown02">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                </ul>
            </div>';
        
        $out = '<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
            <div class="container-lg">
                <a class="navbar-brand" href="#">Navbar</a>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">No Collapse</a>
                    </li>
                </ul>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown link
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- navbar-collapse -->
            </div><!-- container -->
        </nav><!-- navbar -->';

 		echo $out;
     } // topNav()
     
     



    public function set_page_title($t) {
        return '<div class="col-12"><h1 class="mb-0">'.$t.'</h1></div>';
    } // set_page_title()

    public function set_page_subtitle($t) {
        return '<div class="col-12"><h2 class="text-secondary mb-0">'.$t.'</h2></div>';
    } // set_page_subtitle()

    /**
      * Build footer
      *
      * Sets the page footer
      *
      * @return string 	footer
      *
      * TODO: Finish this off
    */
    public function footer () {
         echo '<footer class="footer fixed-bottom bg-dark">
            <div class="container text-white ">Footer content.</div><!-- div .container-fluid text-white  -->
        </footer>';
     } // footer()
     
    public function render_titles($d) {
        if(isset($d['page_title']) || isset($d['page_subtitle'])) {
            $this->_page_title = $d['page_title'];
            $o = '';
            foreach (['title', 'subtitle'] as $value) {
                if (isset($d['page_'.$value])) {
                    $f_name = 'set_page_'.$value;
                    $o .= $this->$f_name($d['page_'.$value]);
                }
            }
            $o .= '<!-- page title -->';

            $this->set_content($o);
        }
    }

    public function set_crumbs($d=null) {
        if(isset($d['crumbs'])) {
            $o = '';
            $home = 'Home';
            $site = '/';
            $o .= '<div class="col-12">';
            $o .= '<nav aria-label="breadcrumb" class="mb-1 " role="navigation">';
            $o .= '<ol class="breadcrumb  py-0 px-2 mb-2">';
            $o .= '<li class="breadcrumb-item"><a href="'.$site.'">'.$home.'</a></li>';

            foreach ($d['crumbs'] as $key => $value) {
                if($value) {
                    $o .=  '<li class="breadcrumb-item"><a href="'.$site.$value.'">'.$key.'</a></li>';
                } else {
                    $o .= '<li class="breadcrumb-item active">'.$key.'</li>';
                }
            }

            $o .= '</ol>';
            $o .= '</nav>';
            $o .= '</div>';
            $this->set_content($o);
        }
    }

    public function header () {
        $out = '<header id="header" class="">
            <div class="container-lg text-light pb-1">
                <div class="row">
                    <div class="col">
                        <h1 class="title">Heading</h1>
                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- container -->
        </header>';
        
        echo $out;
    }

    
    
}
