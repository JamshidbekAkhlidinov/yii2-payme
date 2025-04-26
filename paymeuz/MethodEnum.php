<?php

/*
 *   Jamshidbek Akhlidinov
 *   6 - 4 2025 17:33:23
 *   https://ustadev.uz
 *   https://github.com/JamshidbekAkhlidinov
 */

namespace app\paymeuz;

interface MethodEnum
{
    public const CheckPerformTransaction = 'CheckPerformTransaction';
    public const CreateTransaction = 'CreateTransaction';
    public const PerformTransaction = 'PerformTransaction';
    public const CancelTransaction = 'CancelTransaction';
    public const CheckTransaction = 'CheckTransaction';
    public const GetStatement = 'GetStatement';
}