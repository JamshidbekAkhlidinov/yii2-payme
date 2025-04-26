<?php
/*
 *   Jamshidbek Akhlidinov
 *   6 - 4 2025 17:52:15
 *   https://ustadev.uz
 *   https://github.com/JamshidbekAkhlidinov
 */

namespace app\paymeuz;

use app\models\Order;
use app\models\PaymeTransaction;

class PaymeService
{
    public $params = [];
    public $method;

    public function setData()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->params = $data['params'];
        $this->method = $data['method'];
    }

    public function getAnswer()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->SendError(ErrorEnum::NOT_POST_METHOD);
        }
        $this->setData();
        switch ($this->method) {
            case MethodEnum::CreateTransaction:
                return $this->CreateTransaction();
            case MethodEnum::PerformTransaction:
                return $this->PerformTransaction();
            case MethodEnum::CancelTransaction:
                return $this->CancelTransaction();
            case MethodEnum::CheckTransaction:
                return $this->CheckTransaction();
            default:
                return $this->CheckPerformTransaction();
        }
    }

    public function CheckPerformTransaction()
    {
        $checkAmount = $this->checkAmount();
        if (!$checkAmount) {
            return $checkAmount;
        }

        $order = Order::findOne([
            'id' => $this->params['account']['order_id'],
            'payment_status' => 0
        ]);

        if (!$order) {
            return $this->SendError(ErrorEnum::INVALID_ACCOUNT_INPUT);
        }

        return $this->SendSuccess([
            'allow' => true
        ]);
    }

    public function CreateTransaction()
    {
        $checkAmount = $this->checkAmount();
        if (!$checkAmount) {
            return $checkAmount;
        }

        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        $order = Order::findOne([
            'id' => $this->params['account']['order_id'],
            'payment_status' => 0
        ]);

        if (!$order) {
            return $this->SendError(ErrorEnum::INVALID_ACCOUNT_INPUT);
        }

        $transaction = PaymeTransaction::findOne([
            'transaction_id' => $this->params['id'],
        ]);
        if (!$transaction) {
            $transaction = new PaymeTransaction([
                'order_id' => $order->id,
                'transaction_id' => $this->params['id'],
                'amount' => $this->params['amount'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $transaction->state = 1;
            $transaction->save();
        }

        return $this->SendSuccess([
            "transaction" => $transaction->transaction_id,
            "state" => $transaction->state,
            "create_time" => $transaction->created_at,
        ]);
    }

    public function PerformTransaction()
    {
        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        $transaction = PaymeTransaction::findOne([
            'transaction_id' => $this->params['id'],
            'state' => 1,
            'perform_at' => null
        ]);

        if (!$transaction) {
            return $this->SendError(ErrorEnum::INVALID_ACCOUNT_INPUT);
        }

        $transaction->perform_at = date('Y-m-d H:i:s');
        $transaction->state = 2;
        $transaction->save();

        $order = Order::findOne($transaction->order_id);
        $order->payment_status = 1;
        $order->payment_at = $transaction->perform_at;
        $order->save();

        return $this->SendSuccess([
            "transaction" => $transaction->transaction_id,
            "state" => $transaction->state,
            "perform_time" => $transaction->perform_at,
        ]);
    }

    public function CancelTransaction()
    {
        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        if (empty($this->params['reason'])) {
            return $this->SendError(ErrorEnum::CANNOT_CANCEL_TRANSACTION);
        }

        $transaction = PaymeTransaction::findOne([
            'transaction_id' => $this->params['id'],
        ]);


        if ($transaction) {
            if ($transaction->state == 1) {
                $transaction->cancel_at = date('Y-m-d H:i:s');
                $transaction->state = -1;
                $transaction->reason = $this->params['reason'];
                $transaction->save();

                $order = Order::findOne($transaction->order_id);
                $order->payment_status = $transaction->state;
                $order->cancel_at = $transaction->cancel_at;
                $order->save();

            } elseif ($transaction->state == 2) {
                return $this->SendError(ErrorEnum::CANNOT_CANCEL_TRANSACTION);
            } elseif ($transaction->state == -1) {
                $transaction->cancel_at = date('Y-m-d H:i:s');
                $transaction->state = -2;
                $transaction->save();

                $order = Order::findOne($transaction->order_id);
                $order->payment_status = $transaction->state;
                $order->cancel_at = $transaction->cancel_at;
                $order->save();
            }
        }

        return $this->SendSuccess([
            "transaction" => $transaction->transaction_id,
            "state" => $transaction->state,
            "cancel_time" => $transaction->cancel_at,
        ]);
    }


    public function CheckTransaction()
    {
        if (empty($this->params['id'])) {
            return $this->SendError(ErrorEnum::TRANSACTION_NOT_FOUND);
        }

        $transaction = PaymeTransaction::findOne([
            'transaction_id' => $this->params['id'],
        ]);

        return $this->SendSuccess([
            "transaction" => $transaction->transaction_id,
            "state" => $transaction->state,
            "perform_time" => $transaction->perform_at,
            "create_time" => $transaction->created_at,
            "cancel_time" => $transaction->cancel_at,
            "reason" => $transaction->reason,
        ]);
    }

    private function checkAmount()
    {
        if ($this->params['amount'] < 1000 * 100 || $this->params['amount'] > 100000 * 100) {
            return $this->SendError(ErrorEnum::INVALID_AMOUNT);
        }
        return true;
    }

    public function SendSuccess($options)
    {
        return ([
            'result' => $options
        ]);
    }

    public function SendError($status, $options = [])
    {
        return ([
            'result' => null,
            'error' => [
                'code' => $status,
                'message' => ErrorEnum::MESSAGES[$status],
                'data' => $options,
            ],
        ]);
    }

}