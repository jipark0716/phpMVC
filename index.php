<?include getenv('autoload');?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <?include './partials/cdn.php';?>
        <title>nozzang</title>
    </head>
    <body>
        <div id="wrap">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" data-toggle="collapse" data-target="#app-navbar-collapse" class="navbar-toggle collapsed">
                            <span class="sr-only">Toggle Navigation</span>
                        </button>
                        <a href="javascript:void(loadContent('/home'))" class="navbar-brand">
                            NOZZANG
                        </a>
                    </div>
                    <div id="app-navbar-collapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="javascript:void(loadContent('/login'))">Login</a></li>
                            <li><a href="javascript:void(loadContent('/register'))">Register</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row" id="content">

                </div>
            </div>
        </div>
    </body>
</html>
