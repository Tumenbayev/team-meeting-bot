<?php

namespace App\Http\Commands;

use App\Helpers\BaseHelper;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;

class ListCommand extends Command
{
    /**
     * @var string базовый текст команды
     */
    protected $baseText = '';
    /**
     * @var string Command Name
     */
    protected $name = "list";
    /**
     * @var string Command Description
     */
    protected $description = "Type this command to show the list of users";

    protected $api = null;

    /**
     * @inheritDoc
     */
    public function handle($arguments)
    {
        $this->replyWithMessage(
            [
                'text'    => BaseHelper::constructText($this->baseText),
                'chat_id' => $arguments['chat']['id'],
            ]
        );
    }

    public function replyWithMessage($params)
    {
        $telegram = new Api();
        $telegram->sendMessage($params);
    }
}