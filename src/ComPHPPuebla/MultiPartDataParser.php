<?php
namespace ComPHPPuebla;

class MultiPartDataParser
{
    /**
     * @var string
     */
    protected $saveFolder;

    /**
     * @param string $saveFolder
     */
    public function __construct($saveFolder)
    {
        $this->saveFolder = $saveFolder;
    }

    /**
     * @param string $requestBody
     * @return array
     */
    public function parse($requestBody)
    {
        // Fetch content and determine boundary
        $boundary = substr($requestBody, 0, strpos($requestBody, "\r\n"));

        // Fetch each part
        $parts = array_slice(explode($boundary, $requestBody), 1);
        $data = array();

        foreach ($parts as $part) {
            // If this is the last part, break
            if ($part == "--\r\n") {
                break;
            }

            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list ($rawHeaders, $body) = explode("\r\n\r\n", $part, 2);

            // Parse the headers list
            $rawHeaders = explode("\r\n", $rawHeaders);
            $headers = array();
            foreach ($rawHeaders as $header) {
                list ($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'], $matches
                );
                list (, $type, $name) = $matches;
                isset($matches[4]) and $filename = $matches[4];

                if ($filename) {
                    file_put_contents("{$this->saveFolder}/{$filename}", $body);
                } else {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }
        }

        return $data;
    }
}
