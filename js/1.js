(function(){
    var xmlHttp;
    xmlHttp = new XMLHttpRequest(); 
    xmlHttp.onreadystatechange = ProcessRequest;
    xmlHttp.open( "GET", 'http://myecoteh.ru/index1.php', true );
    xmlHttp.send( null );
    function ProcessRequest(){
        console.log(xmlHttp.responseText); // "" (empty string)
        var respData = JSON.parse(xmlHttp.responseText) || {};
        RemoteEvents = JSON.parse(respData.Description) || null;
    }
})()