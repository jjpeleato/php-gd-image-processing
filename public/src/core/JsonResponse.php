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
    public $message;
    public $data = [];
    public $statusCode;
    public $result;

    /**
     * JsonResponse constructor.
     *
     * @param $status
     * @param string $message
     * @param array $data
     */
    public function __construct($status, $message = '', array $data = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->result = array(
            'status' => $this->status
        );

        echo $this->response();
    }

    /**
     * Format user message with HTTP status and status code
     *
     * @return string, json object
     */
    public function response()
    {
        $statusCode = 200;

        //set the HTTP response code
        switch ($this->status)
        {
            case "unauthorized":
                $statusCode = 401;
                break;
            case "exception":
                $statusCode = 500;
                break;
        }

        //set the response header
        header("Content-Type: application/json");
        header(sprintf('HTTP/1.1 %s %s', $statusCode, $this->status), true, $statusCode);

        if ( $this->message != '')
        {
            $this->result['message'] = $this->message;
        }

        if ( count($this->data) > 0 ) {
            $this->result['data'] = $this->data;
        }

        return json_encode($this->result);
    }
}
