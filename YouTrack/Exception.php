<?php
namespace YouTrack;

/**
 * A class extending the standard php exception.
 */
class Exception extends \Exception
{
    /**
     * @var Error
     */
    protected $youTrackError;

    /**
     * Constructor
     *
     * @param string $url The url that triggered the error.
     * @param array $response The output of <code>curl_getinfo($resource)</code>.
     * @param string $content The content returned from the url.
     */
    public function __construct($url, $response, $content)
    {
        $code = (int)$response['http_code'];
        $previous = NULL;
        $message = "Error for '" . $url . "': " . $response['http_code'];

        if ($c = $this->getResponseContent($response, $content)) {
            if (is_array($c)) {
                $error = new Error();
                $error->setJsonResponse($c);
            } else {
                $xml = simplexml_load_string($c);
                $error = new Error($xml);
            }
            $this->setYouTrackError($error);
            $message .= ": " . $error->__get("error");
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param array $response
     * @param string $content
     * @return bool|string|array
     */
    protected function getResponseContent(array $response, $content)
    {
        if (!empty($response['content_type']) && !preg_match('/text\/html/', $response['content_type'])) {
            if (preg_match('/application\/json/', $response['content_type'])) {
                $content = json_decode($content, true);
                return $content;
            }
            if (substr(trim($content), 0, 1) != '<') {
                if (substr($content, 0, 4) == 'HTTP') {
                    $content = substr($content, strpos($content, "\r\n\r\n") + 4);
                }
            }
            return $content;
        }
        return false;
    }

    /**
     * Returns the youTrackError
     *
     * @return Error
     * @see setYouTrackError
     * @see $youTrackError
     */
    public function getYouTrackError()
    {
        return $this->youTrackError;
    }

    /**
     * Sets the youTrackError
     *
     * @param Error $youTrackError
     * @return Exception
     * @see getYouTrackError
     * @see $youTrackError
     */
    public function setYouTrackError(Error $youTrackError)
    {
        $this->youTrackError = $youTrackError;
        return $this;
    }
}
