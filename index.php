<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.82.0">
        <title>BS5 Playground</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">

    </head>
    <body>
    
        <div class="col-lg-8 mx-auto p-3 py-md-5">
            <h1 class="text-primary">BS5 Playground</h1>
            <?php 
            $result = false;
            $dir ='examples';
            while($dirs = glob($dir . '/*', GLOB_ONLYDIR)) {
                $dir .= '/*';
                if(!$result) {
                    $result = $dirs;
                } else {
                    $result = array_merge($result, $dirs);
                }
            }
            ?>
            <h5>Default Bootstrap Examples</h5>
            <div class="row">
                <?php 
                foreach ($result as $key => $value) {
                    $parts = explode('/',$value);
 
                    if($parts[1] !== 'assets') {
                        
                        $is_rtl = strpos($parts[1], '-rtl');
                        $name = str_replace('-', ' ', $parts[1]);

                        if(!$is_rtl) {
                            echo '<div class="col-sm-6 col-md-4 col-xl-3 mb-3">';

                            echo '<img class="img-thumbnail mb-3" src="assets/img/example_thumbs/'.$parts[1].'.png" alt="" width="240" height="150" loading="lazy">';
                            echo '<h3 class="h5 mb-1"><a class="text-decoration-none" href="'.$value.'" class="text-decoration-none">'.ucwords($name).'</a>';
                            
                            if(!is_dir('examples/'.$name.'-rtl')) {
                               echo '</h3></div>';
                            }
                            
                        } else {
                            echo '<a href="'.$value.'" class="text-decoration-none float-end">RTL</a>';
                            echo '</h3></div>';
                            
                        }
                    }
                }
                
                ?>
            </div><!-- row -->    
            <footer class="pt-5 my-5 text-muted border-top">
                Created by the Bootstrap team &middot; &copy; 2021
            </footer>
        </div>
        <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
