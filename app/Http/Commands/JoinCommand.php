<?php

namespace App\Http\Commands;

use Faker\Provider\Base;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Api;
use App\User;
use App\Helpers\BaseHelper;

class JoinCommand extends Command
{
    /**
     * @var string базовый текст команды
     */
    protected $baseText = 'Спасибо за регистрацию';
    /**
     * @var string Command Name
     */
    protected $name = "join";
    /**
     * @var int Общая стоимость игры
     */
    protected $sum = 12500;
    /**
     * @var string Command Description
     */
    protected $description = "Type this command to join meeting";

    protected $api = null;

    /**
     * @inheritDoc
     */
    public function handle($arguments)
    {
        $user = User::where('telegram_id', $arguments['user']['id'])->first();
        if ($user !== null) {
            $this->replyWithMessage(
                [
                    'text'    => 'Вы уже зарегистрированы!',
                    'chat_id' => $arguments['chat']['id'],
                    'parse_mode' => 'Html'
                ]
            );
        } else {
            BaseHelper::saveUser($arguments);

            $response = BaseHelper::constructText($this->baseText);

            $this->replyWithMessage(
                [
                    'text'    => $response,
                    'chat_id' => $arguments['chat']['id'],
                    'parse_mode' => 'Html'
                ]
            );
        }
    }

    public function replyWithMessage($params)
    {
        $telegram = new Api();
        $telegram->sendMessage($params);
    }
}