<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>REST Server Tests</title>

    <style>

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
        background-color: #FFF;
        margin: 40px;
        font: 16px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
        word-wrap: break-word;
    }

    a {
        color: #039;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 24px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 16px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body {
        margin: 0 15px 0 15px;
    }

    p.footer {
        text-align: right;
        font-size: 16px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
</head>
<body>

<div id="container">
    <h1>REST Server Tests</h1>

    <div id="body">

        <h2><a href="<?php echo site_url(); ?>">Home</a></h2>

        <p>
            See the article
            <a href="http://net.tutsplus.com/tutorials/php/working-with-restful-services-in-codeigniter-2/" target="_blank">
                http://net.tutsplus.com/tutorials/php/working-with-restful-services-in-codeigniter-2/
            </a>
        </p>

        <p>
            The master project repository is
            <a href="https://github.com/chriskacerguis/codeigniter-restserver" target="_blank">
                https://github.com/chriskacerguis/codeigniter-restserver
            </a>
        </p>

        <h3><a href="<?php echo site_url('curl-test'); ?>">Accessing the REST Server Using the Curl Library</a></h3>
        <h3><a href="<?php echo site_url('rest-client-test'); ?>">Accessing the REST Server Using the Rest Client Library</a></h3>
        <h3><a href="<?php echo site_url('requests-client-test'); ?>">Accessing the REST Server Using the Requests HTTP Library</a></h3>
        <h3><a href="<?php echo site_url('guzzle-client-test'); ?>">Accessing the REST Server Using the Guzzle HTTP Client</a></h3>

        <h3>
            Click on the links below to check whether the REST server is working.
        </h3>

        <ol>
            <li><a href="<?php echo site_url('api/example/users'); ?>">Users</a> - defaulting to JSON</li>
            <li><a href="<?php echo site_url('api/example/users/format/csv'); ?>">Users</a> - get it in CSV</li>
            <li><a href="<?php echo site_url('api/example/users/id/1'); ?>">User #1</a> - defaulting to JSON  (users/id/1)</li>
            <li><a href="<?php echo site_url('api/example/users/1'); ?>">User #1</a> - defaulting to JSON  (users/1)</li>
            <li><a href="<?php echo site_url('api/example/users/id/1.xml'); ?>">User #1</a> - get it in XML (users/id/1.xml)</li>
            <li><a href="<?php echo site_url('api/example/users/id/1/format/xml'); ?>">User #1</a> - get it in XML (users/id/1/format/xml)</li>
            <li><a href="<?php echo site_url('api/example/users/id/1?format=xml'); ?>">User #1</a> - get it in XML (users/id/1?format=xml)</li>
            <li><a href="<?php echo site_url('api/example/users/1.xml'); ?>">User #1</a> - get it in XML (users/1.xml)</li>
            <li><a id="ajax" href="<?php echo site_url('api/example/users/format/json'); ?>">Users</a> - get it in JSON (AJAX request)</li>
            <li><a href="<?php echo site_url('api/example/users.html'); ?>">Users</a> - get it in HTML (users.html)</li>
            <li><a href="<?php echo site_url('api/example/users/format/html'); ?>">Users</a> - get it in HTML (users/format/html)</li>
            <li><a href="<?php echo site_url('api/example/users?format=html'); ?>">Users</a> - get it in HTML (users?format=html)</li>
        </ol>

    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

<script src="https://code.jquery.com/jquery-1.11.3.js"></script>

<script>
    // Create an 'App' namespace
    var App = App || {};

    // Basic rest module using an IIFE as a way of enclosing private variables
    App.rest = (function ($, window) {
        // Fields

        // Cache the jQuery selector
        var $_ajax = null;

        // Methods (private)

        // Called on Ajax done
        function ajaxDone(data) {
            // The 'data' parameter is an array of objects that can be iterated over
            window.alert(JSON.stringify(data, null, 2));
        }

        // Called on Ajax fail
        function ajaxFail() {
            window.alert('Oh no! A problem with the Ajax request!');
        }

        // On Ajax request
        function ajaxEvent($this) {
            $.ajax({
                    // URL from the link that was 'clicked' on
                    url: $this.attr('href')
                })
                .done(ajaxDone)
                .fail(ajaxFail);
        }

        // Bind event(s)
        function bind() {
            // Namespace the 'click' event
            $_ajax.on('click.app.rest.module', function (event) {
                event.preventDefault();

                // Pass this to the Ajax event function
                ajaxEvent($(this));
            });
        }

        // Cache the DOM node(s)
        function cacheDom() {
            $_ajax = $('#ajax');
        }

        // Public API
        return {
            init: function () {
                // Cache the DOM and bind event(s)
                cacheDom();
                bind();
            }
        };
    })(jQuery, window);

    // DOM ready event
    $(function () {
        // Initialise the App module
        App.rest.init();
    });

</script>

</body>
</html>
