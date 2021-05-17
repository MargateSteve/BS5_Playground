<?php

/**
 * Main Template
 *
 */
require_once '../../assets/Template_Class.php';
class T_Admin extends Template_Class {

    protected $_t_type = 'admin';
    
    public function render () {

        $this->bodyStart(); // T_Common
        
        $this->topNav ();
        
        echo '<div class="container-fluid">
                <div class="row d-flex">';
        $this->leftNav ();
        echo '<main class="flex-shrink-1">';
        $this->get_content (); // T_Common
        $this->footer ();
        echo '</main>';
        $this->rightNav ();
        
         echo '</div>';
         echo '</div>';
        
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
        
        $out = '<header class="navbar navbar-expand-md navbar-dark sticky-top bg-dark p-0 shadow">
            <span class="navbar-brand d-flex align-items-center me-0 px-3">
                  <a class="me-auto" href="#">Company name</a>
                  <i class="bi-justify left-toggle-large"></i>
                  <i class="bi-justify left-toggle-small"></i>
            </span>
    
            '.$nav_collapse.'
            <li class="nav-item text-nowrap order-1 order-md-2 ms-auto d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-caret-down-square"></i>
            </li>
            
            
    
    
            <li class="nav-item text-nowrap order-1 order-md-2">
                <i class="bi-sliders right-toggle me-2"></i>
            </li>
        </header>';

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
         echo '<footer class="row footer position-fixed bottom-0 bg-dark text-light py-1 w-100">
                <div class="container">
                  <span class="text-muted">Place sticky footer content here.</span>
                </div>
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

    public function leftNav () {
        $out = '<nav id="sidebarMenuLeft" class="d-flex flex-column px-3 pb-3 bg-dark sidebar left-nav">

                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="bi bi-bootstrap me-2"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="bi bi-bootstrap me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="bi bi-bootstrap me-2"></i>
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="#collapseExample" 
                               class="nav-link" 
                               data-bs-toggle="collapse" 
                               role="button" 
                               aria-expanded="false" 
                               aria-controls="collapseExample">
                              <i class="bi bi-bootstrap me-2"></i>
                              Products
                            </a>
                            <div class="sub-menu collapse" id="collapseExample">
                                <div class="list-group  list-group-flush">
                                        <a href="#" class="list-group-item">
                                            The current link item
                                        </a>
                                        <a href="#" class="list-group-item">A second link item</a>
                                        <a href="#" class="list-group-item">A third link item</a>
                                        <a href="#" class="list-group-item">A fourth link item</a>
                                </div>
                            </div>  
                        </li>
                        <li>
                            <a href="#" class="nav-link">
                                <i class="bi bi-bootstrap me-2"></i>
                                Customers
                            </a>
                        </li>
                    </ul>
                    <hr>

                    <div class="dropdown dropdown-bottom">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong>mdo</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark px-1 text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </nav> ';
        
        echo $out;
    }
    
        public function rightNav () {
        $out = '<nav id="sidebarMenuRight" class="d-flex flex-column px-3 pb-3 text-dark bg-light sidebar right-nav">
                    raaaaar
                </nav>';
        
        echo $out;
    }
    
    
}
