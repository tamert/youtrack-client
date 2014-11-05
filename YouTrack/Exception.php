<?php
namespace YouTrack;

/**
 * A class extending the standard php exception.
 */
class Exception extends \Exception {
    /**
     * Constructor
     *
     * @param string $url The url that triggered the error.
     * @param array $response The output of <code>curl_getinfo($resource)</code>.
     * @param array $content The content returned from the url.
     */
    public function __construct($url, $response, $content)
    {
        $code = (int)$response['http_code'];
        $previous = NULL;
        $message = "Error for '" . $url . "': " . $response['http_code'];
        if (!empty($response['content_type']) && !preg_match('/text\/html/', $response['content_type'])) {
            if (substr(trim($content), 0, 1) != '<') {
                if (substr($content, 0, 4) == 'HTTP') {
                    $content = substr($content, strpos($content, "\r\n\r\n")+4);
                }
            }
            $xml = simplexml_load_string($content);
            $error = new Error($xml);
            $message .= ": " . $error->__get("error");
        }
        parent::__construct($message, $code, $previous);
    }
}
