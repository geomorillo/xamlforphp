<?php namespace test1;
class  MainWindow{
   
    private $xmlFile = "";
    public function __construct() {
        $this->xmlFile ="MainWindow.xaml";
        $this->InitializeComponent();
    }
    public function InitializeComponent() {
        $xml = simplexml_load_file($this->xmlFile) or die("Error: Cannot create object");
        $elements = array("title"=> $xml["Title"],"button" =>$xml->Grid->Button) ;
        $this->generateWindow($elements);        
    }
    function generateWindow($elements) {
        $this->title = $elements["title"];
        echo "<!DOCTYPE html>\r\n".
                "<html>\r\n".
                "<head>\r\n".
                "<meta charset=\"UTF-8\">\r\n".
               "<title>$this->title</title>\r\n".
                '<link href="Resources/semantic/semantic.css" rel="stylesheet" type="text/css"/>'."\r\n".
                '<script src="Resources/semantic/semantic.js" type="text/javascript"></script>'."\r\n".
                "</head>\r\n".
                "<body>\r\n".
                '<div class="ui button">'."\r\n".
                 $elements["button"]["Content"]."\r\n". 
                "</div>\r\n".
                "</body></html>";
    }   
}

$test1 = new \test1\MainWindow();
