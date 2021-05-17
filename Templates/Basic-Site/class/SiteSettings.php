<?php

/**
 * Settings Core Class
 *
 * This file either contains or provides access to all of the required
 * settings and variables throughout the site.
 *
 * There are two different methods of storing these settings.
 *
 * Any that are fairly static get stored in one of a number of specific
 * functions. With these if it is likely that you will need more than
 * one of the settings contained at one time (such as db() which
 * contains all of the database connection settings) you just call the
 * function cold and return all of the elements - $db = SiteSettings::db().
 * For those where you may only need one of the elements (such as the css()
 * or js() functions), you call the class with a path to the element -
 * $css = SiteSettings::css('remote/bootstrap/v4').
 *
 * Any settings that may frequently change are stored in the settings table
 * in the database and maintained via /Admin/Settings. There is a function
 * here to call any of these so to call the 'site_name' setting from the
 * database, you would use $name = SiteSettings::get('site_name').
 *
 * @package Core
 * @author  Steve Ball <steve@follyball.co.uk>
 * @copyright Copyright (c) 2018 Steve Ball <steve@follyball.co.uk>
 */



class SiteSettings
{
    public static $debug_mode = true,
                  $_site_name = 'Framework';

    /**
     * Meta Tags
     *
     * Returns an array of meta tags as a $key=>$value pairing
     * where the key is the 'name' and the value is the 'content'.
     *
     * These get processed in a foreach loop in the head() function
     * in the base template (by default /app/core/Templates/Base.php).
     *
     * @return  array   Various meta tags
     */
    public static function meta_tags ($custom, $type='site') {
        $out ='';
        $description = 'Framework';
        if($type=='admin') {
            $description .= ' Admin';
        }
        $a = [
            'description' => $description,
            'author' => 'Steve Ball',
            'viewport' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
            'keyword' => 'Bootstrap,Admin,Template,PHP,MVC,Framework,jQuery,CSS,HTML,Dashboard'
        ];
        
        /*
            If any page-specific meta tags have been passed in from the view, they would have
            been set to $this->meta in the called template file (by default
            '/app/core/Templates/Main.php').
            We loop though these and for each one, overwrite the matching tag name in $tags.
         */
        if($custom) {
            foreach ($custom as $name => $content) {
                $a[$name] = $content;
            }
        }
        
        /*
            Finally, we loop through the tags array and create a meta tag for each one, adding it to the $out variable.
         */
        foreach ($a as $name => $content) {
            $out .= '<meta name="'.$name.'" content="'.$content.'"/>';
        }
        return $out;
    } // meta_tags ()

    /**
     * Available CSS files
     *
     * Contains an array of all css files that can be used within the
     * site and allows you to pick a single one to return.
     *
     * To call a file, call the function and as the $path, drill down to
     * the required file using / as a seperator.
     *
     * SiteSettings::css('local/admin') will return
     * <link rel="stylesheet" href="/includes/css/admin.css">
     *
     * SiteSettings::css('remote/bootstrap/v4') will return
     * <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     *
     * @param   string  $path   Array path to the required file
     * @return  string  The tag for the requested file
     */
    public static function css ($custom) {
        $sheets = [
            // Locally Hosted
            'local' => [
                'site' => '<link rel="stylesheet" type="text/css" href="../basic-site.css">',
                'vendors' => [
                ],
            ],
            // Remotely Hosted
            'remote' => [
                // Bootstrap Icons
                'bootstrap-icons' => [
                    'v1_5' => '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">'
                ],

                //Bootstrap - We have both versions 3 and 4 just in case 3 is still needed
                'bootstrap' => [
                    // Version 4.5 
                    'v5_0' => '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">',

                ]
            ]
        ];

        $default = ['first'=>['remote/bootstrap/v5_0','remote/bootstrap-icons/v1_5'],
                    'last'=>['local/site']];
        
        $a=$default['first'];
        if($custom) {
            $a = array_merge($a, $custom);
        }
        $a = array_merge($a, $default['last']);
        
        $o = '';
        foreach ($a as $value) {
            $o .= self::set_path($sheets, $value);
        }
        return $o;

    } // css ()
    
     /**
     * Available JS files
     *
     * Contains an array of all js files that can be used within the
     * site and allows you to pick a single one to return.
     *
     * To call a file, call the function and as the $path, drill down to
     * the required file using / as a seperator.
     *
     * SiteSettings::css('local/default') will return
     * <script src="default.js"></script>
     *
     * SiteSettings::css('remote/font-awesome-5') will return
     * <script defer src="https://use.fontawesome.com/releases/v5.0.4/js/all.js"></script>
     *
     * @param   string  $path   Array path to the required file
     * @return  string  The tag for the requested file
     */
    public static function js ($custom) {
        $files = [
            // Locally Hosted
            'local' => [
                'site' => '<script src="../basic-site.js" type="text/javascript"></script>',
                'vendors' => [
                ],
            ],
            // Remotely Hosted
            'remote' => [
                // JQuery
                'jquery' => '<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.js"></script>',
                //Bootstrap - We have both versions 3 and 4 just in case 3 is still needed
                'bootstrap' => [
                    'v5_0' => '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>',
                ]
            ]
        ];
        
            $default = ['first'=>['remote/bootstrap/v5_0','remote/jquery'],
                        'last'=>['local/site']];

        // Return the array element specified by $path using set_path() from this file
        
        $a=$default['first'];
        if($custom) {
            $a = array_merge($a, $custom);
        }
        $a = array_merge($a, $default['last']);
        $o = '';
        foreach ($a as $value) {
            echo $value;
            $o .= self::set_path($files, $value);
        }
        return $o;

    } // js ()
    
    /**
     * Get a specified element from an array
     *
     * Looks through the specified array for the path that has been
     * set and returns the value if found.
     *
     * Paths are set using / as a separator for each element to
     * drill down through.
     *
     * @param   array     $array   The array to choose from
     * @param   string    $path    The path to the array element
     * @return  string    The value of the element
     */
    private static function set_path ($array, $path) {

        /*
            Explode the $path and re-set it to itself.

            Looks at the$ path and classes / as a separator. It explodes
            that data so we now have an array conatining an element
            for each part of the path.
         */
        $path = explode('/', $path);

        /*
            Set the first part of the $path array to a parameter called
            $result and then unset it.

            $reuslt now contains the first level key of the passed in
            array.
         */
        $result = $array[$path[0]];
        unset($path[0]);

        /*
            Loop through the remaining elements in path and for each,
            if they exist, build upon result.

            If the path was 'remote/bootstrap/v4', the process would be
            $result = $array['remote']
            $result = $array['remote']['bootstrap']
            $result = $array['remote']['bootstrap']['v4']
            with the final one being the one returned.
         */
        foreach ($path as $bit) {
            // Check to see if the key exists
            if(isset($result[$bit])) {
                // If the key does exist, replace $result with the new key
                $result = $result[$bit];
            }
        } // foreach $path

        // Return the value of the element
        return $result;
    } // set_path
    
    


}
