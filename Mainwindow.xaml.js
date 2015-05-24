$(document).ready(function(){
function primer_Click(sender){
var sender = "primer";
    $("#"+sender).on("click",function(){
        alert("hola amor");
    });
}
primer_Click();
});