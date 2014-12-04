<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="ProjectX" content="">
        <meta name="AMWN" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>ProjectX</title>

        <!-- Bootstrap core CSS -->
        <link href="./dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="./dist/css/bootstrap-table.css" rel="stylesheet">
        <link href="./dist/css/bootstrap-editable.css" rel="stylesheet">
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <script src="https://code.jquery.com/jquery-2.0.3.min.js"></script> 

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>  
                    </button>
                    <a class="navbar-brand" href="#">Project X</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
        
        
        
        <script>
            var geturl = '/ProjectZ/get';
            var updateurl = '/ProjectZ/update';

            $(document).ready(function() {

                $("form#myform").submit(function(event) {
                    event.preventDefault();
                    submit();
                });
                
                $.fn.editable.defaults.mode = 'inline';
            });

            function getdata(options) {
                $.ajax({
                    type: "POST",
                    url: options[0],
                    dataType: 'json',
                    data: {data: options},
                    cache: true,
                    beforeSend: function() {
                        if (localCache.exist(options)) {
                            createtable(localCache.get(options).responseJSON);
                            return false;
                        }
                        return true;
                    },
                    success: function(result, textStatus, jqXHR) {
                        localCache.set(options, jqXHR, '');
                        createtable(result);
                    },
                    error: function(result, jqXHR, textStatus) {
                        createtable(textStatus);
                    }

                });
            }

            function createtable(result) {
                $('#table').bootstrapTable({
                    data: result.data,
                    columns: result.columns,
                    pagination: true,
                    pageSize: 10,
                    pageList: [10, 25, 50, 100, 200],
                    search: true
                });
                $('.progress').hide(300);
                $(".progress-bar").animate({
                    width: "0%"
                });
                $('#table td').editable();
            }

            function submit() {
                $(".progress-bar").animate({
                    width: "100%"
                });
                $('.progress').show(100);
                $(".bootstrap-table").remove();
                $("#main").append("<table id=\"table\"> </table>");
                options = [action = geturl,
                    connector = $('#connector').val()
                ];
                getdata(options);
            }


            var localCache = {
                data: {},
                remove: function(url) {
                    delete localCache.data[url];
                },
                exist: function(url) {
                    return localCache.data.hasOwnProperty(url) && localCache.data[url] !== null;
                },
                get: function(url) {
                    console.log('Getting from cache for url' + url);
                    return localCache.data[url];
                },
                set: function(url, cachedData, callback) {
                    console.log('Setting in cache for url' + url);
                    localCache.remove(url);
                    localCache.data[url] = cachedData;
                    if ($.isFunction(callback))
                        callback(cachedData);
                }
            };

            function formattertext(value, row) {
                return '<div data-type="date" >' + value + '</div>';
            }

            


        </script>

        <div class="container" id="main" style="padding-top: 100px">
            <form role="form" id="myform" method="post">
                <div id="formname" class="form-group">
                    <label class="control-label" for="connector">Connector</label>
                    <input type="text" class="form-control" id="connector" placeholder="Bijvoorbeeld ProfitCountries">
                    <span id="formnameglyph"></span>
                </div>
            </form>
            <div class="progress" style="display: none">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                </div>
            </div>
          
            <?php
            error_reporting(-1);
            ini_set('display_errors', 'On');
            
            ?>


        </div><!-- /.container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./dist/js/bootstrap.min.js"></script>
        <script src="./dist/js/bootstrap-table.js"></script>
        <script src="./dist/js/bootstrap-editable.min.js"></script>
    
    
    </body>
</html>
