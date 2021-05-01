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
            <?php 
            foreach ($result as $key => $value) {
                $parts = explode('/',$value);
                if($parts[1] !== 'assets') {
                    $name = str_replace('-', ' ', $parts[1]);
                    $name = str_replace('rtl', ' RTL', $name);
                    $expectedPosition = strlen($name) - strlen('RTL');
                    if($key==0) {
                        echo '<a href="'.$value.'" class="text-decoration-none">'.ucwords($name).'</a>';
                    } else {
                        if(strrpos($name, 'RTL', 0) === $expectedPosition) {
                        echo ' <a href="'.$value.'" class="ms-4 text-decoration-none">RTL</a>';
                    } else {
                        echo '<br><a href="'.$value.'" class=" text-decoration-none">'.ucwords($name).'</a>';
                    }
                    }
                    

                }

            }
            ?>

            <footer class="pt-5 my-5 text-muted border-top">
                Created by the Bootstrap team &middot; &copy; 2021
            </footer>
        </div>
        <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
