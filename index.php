<?php
// Get the PHP helper library from twilio.com/docs/php/install

require_once 'twilio-php-master/Twilio/autoload.php'; // Loads the library
use Twilio\Twiml;



$response = new Twiml;
$body = $_REQUEST['Body'];
function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function getSynonims($body)
{
    $url = 'https://www.googleapis.com/scribe/v1/research?key=AIzaSyDqVYORLCUXxSv7zneerIgC2UYMnxvPeqQ&dataset=dictionary&dictionaryLanguage=en&query='.$body;
    $ret = null;
    $data = file_get_contents($url);
    $data = object_to_array(json_decode($data));
    if (isset($data['data'][0]['dictionary']['definitionData']['0']['meanings'][0]['synonyms']))
        $synonyms = $data['data'][0]['dictionary']['definitionData']['0']['meanings'][0]['synonyms'];
    foreach ($synonyms as $key => $synonym) {
        $ret[$key] = $synonym['nym'];
    }
    return $ret;
}
if( $body == 'hello' ){
    $response->message('Hi!');
}else if( $body == 'bye' ){
    $response->message('Goodbye');
}else{
	
	 $response->getSynonims($body);
	 echo $response;
}
print $response;
echo $response;

?>