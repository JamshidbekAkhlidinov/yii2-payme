<?php
/*
 *   Jamshidbek Akhlidinov
 *   6 - 4 2025 17:52:15
 *   https://ustadev.uz
 *   https://github.com/JamshidbekAkhlidinov
 */

namespace app\paymeuz;

class PaymeService
{
    public $params = [];
    public $method;

    public $usersList = [];


    public function __construct()
    {
        if (!$_POST) {
            return $this->SendError(ErrorEnum::NOT_POST_METHOD);
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $this->params = $data['params'];
        $this->method = $data['method'];
    }

    public function CheckPerformTransaction()
    {
        if ($this->params['amount'] < 1000 || $this->params['amount'] > 100000) {
            return $this->SendError(ErrorEnum::INVALID_AMOUNT);
        }

        if (!in_array($this->params['account'], $this->usersList)) {
            return $this->SendError(ErrorEnum::INVALID_ACCOUNT_INPUT);
        }

        return $this->SendSuccess([
            'allow' => true
        ]);
    }


    public function CreateTransaction()
    {
        if ($this->params['amount'] < 1000 || $this->params['amount'] > 100000) {
            return $this->SendError(ErrorEnum::INVALID_AMOUNT);
        }

        if (!in_array($this->params['account'], $this->usersList)) {
            return $this->SendError(ErrorEnum::INVALID_ACCOUNT_INPUT);
        }

        return $this->SendSuccess([
            "transaction" => 5123,
            "state" => 1,
            "create_time" => date('Y-m-d H:i:s'),
        ]);
    }

    public function PerformTransaction()
    {
        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        return $this->SendSuccess([
            "transaction" => 5123,
            "state" => 2,
            "perform_time" => 1399114284039,
        ]);
    }

    public function CancelTransaction()
    {
        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        if (empty($this->params['reason']) || ($this->params['reason'] !== 1)) {
            return $this->SendError(ErrorEnum::CANNOT_CANCEL_TRANSACTION);
        }

        return $this->SendSuccess([
            "transaction" => 5123,
            "state" => -2,
            "cancel_time" => 1399114284039,
        ]);
    }


    public function CheckTransaction()
    {
        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        return $this->SendSuccess([
            "transaction" => 5123,
            "state" => 2,
            "perform_time" => 1399114284039,
            "create_time" => 1399114284039,
            "cancel_time" => 0,
            "reason" => null,
        ]);
    }

    public function SendSuccess($options)
    {
        return json_encode([
            'result' => $options
        ]);
    }

    public function SendError($status, $options = [])
    {
        return json_encode([
            'result' => null,
            'error' => [
                'code' => $status,
                'message' => ErrorEnum::MESSAGES[$status],
                'data' => $options,
            ],
        ]);
    }

}