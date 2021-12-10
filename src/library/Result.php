<?php
namespace unions\library;

class Result
{
    public $code = 0;

    private $data;

    public function __construct(int $code, $data = [])
    {
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data): Result
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return bool
     */
    public function state(): bool
    {
        return $this->code === Code::SUCCESS;
    }

    public function data()
    {
        return $this->data;
    }
}
