<?php
namespace App\Http\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Api;
use App\Helpers\BaseHelper;

class LeaveCommand extends Command
{
    protected $baseText = 'Вы успешно отписались';
    /**
     * @var string Command Name
     */
    protected $name = "leave";

    protected $isDeleted = false;
    /**
     * @var string Command Description
     */
    protected $description = "Type this command to leave from meeting";

    /**
     * @inheritDoc
     */
    public function handle($arguments)
    {
        $this->isDeleted = BaseHelper::deleteUser($arguments);
        if ($this->isDeleted) {
            $this->replyWithMessage(
                [
                    'text'    => BaseHelper::constructText($this->baseText),
                    'chat_id' => $arguments['id'],
                ]
            );
        } else {
            $this->replyWithMessage(
                [
                    'text'    => 'Вас нет в матче, введите /join чтобы вступить',
                    'chat_id' => $arguments['id'],
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