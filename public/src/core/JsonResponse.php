<?php
declare(strict_types=1);

namespace Application\Core;

/**
 * Class JsonResponse
 * @package Application\Core
 */
class JsonResponse
{
    public $status;
    public $message = '';

    /**
     * JsonResponse constructor.
     *
     * @param $status
     * @param $message
     */
    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;

        echo $this->response();
    }

    /**
     * Format user message with HTTP status and status code
     *
     * @return string, json object
     */
    public function response()
    {
        $result = [];

        //set the HTTP response code
        switch ($this->status)
        {
            case "ok":
                $statusCode = 200;
                $statusMessage = 'OK';
                break;
            case "bad_request":
                $statusCode = 400;
                $statusMessage = 'Bad Request';
                break;
            case "unauthorized":
                $statusCode = 401;
                $statusMessage = 'Unauthorized';
                break;
            case "exception":
                $statusCode = 500;
                $statusMessage = 'Internal Server Error';
                break;
        }

        //set the response header
        header("Content-Type: application/json");
        header(sprintf('HTTP/1.1 %s %s', $statusCode, $statusMessage), true, $statusCode);

        if ( $this->message != '')
        {
            $result['respond'] = $this->message;
        }

        return json_encode($result);
    }
}
