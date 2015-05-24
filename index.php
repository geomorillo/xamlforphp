<?php

namespace test1;

class MainWindow {

    private $xmlFile;
    private $eventsFile;

    public function __construct() {
        $this->xmlFile = "MainWindow.xaml";
        $this->eventsFile = "Mainwindow.xaml.js";
        $this->InitializeComponent();
    }

    public function InitializeComponent() {
        $xml = simplexml_load_file($this->xmlFile) or die("Error: Cannot create object");
        $elements = array(
            "title" => $xml["Title"],
            "button" => $xml->Grid->Button
        );
        $this->generateEvents($elements);
        $this->generateWindow($elements);
    }

    function generateEvents($elements) {
        $object_sender = $elements["button"]["Name"];
        $event = $elements["button"]["Click"]; // just Click supported for now, have to figure out how to improve this part
        $file_event = $event . ".js";

        // 1 file per function
        if (!file_exists($file_event)) {

            $contents = "function $event(sender){\r\n" .
                    "var sender = \"$object_sender\";\r\n".
                    "    $(\"#\"+sender).on(\"click\",function(){\r\n" .
                    "    });\r\n" .
                    "}"; //object_sender button's name
            //create a new function and js file
            file_put_contents($file_event, $contents);
        }
        //regenerate MainWindow.xaml.js
        $function1 = file_get_contents($file_event); //reload functions

        $contents = "$(document).ready(function(){\r\n" .
                $function1 . "\r\n" .
                $event . "();\r\n" . //use the function
                "});";

        file_put_contents($this->eventsFile, $contents);
    }

    function generateWindow($elements) {
        $this->title = $elements["title"];
        $id_obj = $elements["button"]["Name"];
        echo "<!DOCTYPE html>\r\n" .
        "<html>\r\n" .
        "<head>\r\n" .
        "<meta charset=\"UTF-8\">\r\n" .
        "<title>$this->title</title>\r\n" .
        '<script src="Resources/js/jquery/jquery.js" type="text/javascript"></script>' . "\r\n" .
        '<link href="Resources/semantic/semantic.css" rel="stylesheet" type="text/css"/>' . "\r\n" .
        '<script src="Resources/semantic/semantic.js" type="text/javascript"></script>' . "\r\n" .
        '<script src="MainWindow.xaml.js" type="text/javascript"></script>' . "\r\n" .
        "</head>\r\n" .
        "<body>\r\n" .
        "<div id=\"$id_obj\" class=\"ui button\">" . "\r\n" .
        $elements["button"]["Content"] . "\r\n" .
        "</div>\r\n" .
        "</body></html>";
    }

}

$test1 = new \test1\MainWindow();
