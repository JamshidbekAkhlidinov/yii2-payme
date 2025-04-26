<?php
/*
 *   Jamshidbek Akhlidinov
 *   6 - 4 2025 17:33:30
 *   https://ustadev.uz
 *   https://github.com/JamshidbekAkhlidinov
 */

namespace app\paymeuz;

interface ErrorEnum
{
    // Umumiy xatoliklar (Общие ошибки)
    public const NOT_POST_METHOD = -32300;
    public const JSON_PARSE_ERROR = -32700;
    public const MISSING_REQUIRED_FIELDS = -32600;
    public const METHOD_NOT_FOUND = -32601;
    public const INSUFFICIENT_PRIVILEGES = -32504;
    public const SYSTEM_ERROR = -32400;

    // Merchant server javoblaridagi xatoliklar (Ошибки в ответах сервера мерчанта)
    public const INVALID_AMOUNT = -31001;
    public const TRANSACTION_NOT_FOUND = -31003;
    public const CANNOT_CANCEL_TRANSACTION = -31007;
    public const CANNOT_PERFORM_OPERATION = -31008;

    // Foydalanuvchi kiritishidagi xatoliklar (Ошибки неверного ввода данных покупателем)
    public const INVALID_ACCOUNT_INPUT = -31050;

    public const MESSAGES = [
        // Umumiy xatoliklar
        self::NOT_POST_METHOD => [
            'uz' => "So‘rov POST metodi orqali yuborilishi kerak.",
            'ru' => "Ошибка возникает если метод запроса не POST.",
            'en' => "The error occurs if the request method is not POST."
        ],
        self::JSON_PARSE_ERROR => [
            'uz' => "JSON tahlil qilishda xatolik yuz berdi.",
            'ru' => "Ошибка парсинга JSON.",
            'en' => "JSON parsing error."
        ],
        self::MISSING_REQUIRED_FIELDS => [
            'uz' => "RPC so‘rovda majburiy maydonlar yo‘q yoki maydon turlari spetsifikatsiyaga mos kelmaydi.",
            'ru' => "Отсутствуют обязательные поля в RPC-запросе или тип полей не соответствует спецификации.",
            'en' => "Required fields are missing in the RPC request or field types do not match the specification."
        ],
        self::METHOD_NOT_FOUND => [
            'uz' => "So‘ralgan metod topilmadi. RPC so‘rovda so‘ralgan metod nomi 'data' maydonida keltirilgan.",
            'ru' => "Запрашиваемый метод не найден. В RPC-запросе имя запрашиваемого метода содержится в поле data.",
            'en' => "The requested method was not found. In the RPC request, the name of the requested method is contained in the 'data' field."
        ],
        self::INSUFFICIENT_PRIVILEGES => [
            'uz' => "Metodni bajarish uchun yetarli huquqlar mavjud emas.",
            'ru' => "Недостаточно привилегий для выполнения метода.",
            'en' => "Insufficient privileges to execute the method."
        ],
        self::SYSTEM_ERROR => [
            'uz' => "Tizim (ichki) xatoligi. Bu xatolik tizim nosozliklari: ma'lumotlar bazasi ishdan chiqishi, fayl tizimi nosozligi, noaniq xatti-harakatlar va hokazolarda ishlatilishi kerak.",
            'ru' => "Системная (внутренняя ошибка). Ошибку следует использовать в случае системных сбоев: отказа базы данных, отказа файловой системы, неопределенного поведения и т.д.",
            'en' => "System (internal) error. This error should be used in case of system failures: database failure, file system failure, undefined behavior, etc."
        ],

        // Merchant server javoblaridagi xatoliklar
        self::INVALID_AMOUNT => [
            'uz' => "Noto‘g‘ri summa. Xatolik tranzaksiya summasi buyurtma summasiga mos kelmaganda yuz beradi. Bir martalik hisob-faktura chiqarilganda dolzarb.",
            'ru' => "Неверная сумма. Ошибка возникает когда сумма транзакции не совпадает с суммой заказа. Актуальна если выставлен одноразовый счёт.",
            'en' => "Invalid amount. The error occurs when the transaction amount does not match the order amount. Relevant if a one-time invoice is issued."
        ],
        self::TRANSACTION_NOT_FOUND => [
            'uz' => "Tranzaksiya topilmadi.",
            'ru' => "Транзакция не найдена.",
            'en' => "Transaction not found."
        ],
        self::CANNOT_CANCEL_TRANSACTION => [
            'uz' => "Tranzaksiyani bekor qilib bo‘lmaydi. Tovar yoki xizmat iste'molchiga to‘liq hajmda taqdim etilgan.",
            'ru' => "Невозможно отменить транзакцию. Товар или услуга предоставлена потребителю в полном объеме.",
            'en' => "Cannot cancel the transaction. The product or service has been provided to the consumer in full."
        ],
        self::CANNOT_PERFORM_OPERATION => [
            'uz' => "Amalni bajarib bo‘lmaydi. Xatolik tranzaksiya holati operatsiyani bajarishga imkon bermaganda yuz beradi.",
            'ru' => "Невозможно выполнить операцию. Ошибка возникает если состояние транзакции не позволяет выполнить операцию.",
            'en' => "Cannot perform the operation. The error occurs if the transaction state does not allow the operation."
        ],

        // Foydalanuvchi kiritishidagi xatoliklar
        self::INVALID_ACCOUNT_INPUT => [
            'uz' => "Foydalanuvchi tomonidan 'account' maydoniga noto‘g‘ri ma'lumot kiritilgan, masalan: kiritilgan login topilmadi, kiritilgan telefon raqami topilmadi va hokazo. Xatolarda lokalizatsiyalangan 'message' maydoni majburiy. 'data' maydoni 'account' submaydon nomini o‘z ichiga olishi kerak.",
            'ru' => "Ошибки, связанные с неверным пользовательским вводом 'account', например: введенный логин не найден, введенный номер телефона не найден и т.д. В ошибках локализованное поле 'message' обязательно. Поле 'data' должно содержать название субполя 'account'.",
            'en' => "Errors related to incorrect user input in the 'account' field, for example: the entered login was not found, the entered phone number was not found, etc. In errors, the localized 'message' field is mandatory. The 'data' field must contain the name of the 'account' subfield."
        ]
    ];
}
