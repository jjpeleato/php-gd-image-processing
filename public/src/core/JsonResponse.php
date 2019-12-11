<?php
declare(strict_types=1);

namespace Application\Core;

/**
 * Class JsonResponse
 * @package Application\Core
 */
class JsonResponse
{
    private $status;
    private $message;
    private $data;

    /**
     * JsonResponse constructor.
     *
     * @param string $status
     * @param string $message
     * @param array $data
     */
    public function __construct($status = 'bad_request', $message = '', $data = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;

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

        if ($this->message !== '')
        {
            $result['respond'] = $this->message;
        }

        if (!empty($this->data)) {
            $result['data'] = $this->data;
        }

        return json_encode($result);
    }
}
