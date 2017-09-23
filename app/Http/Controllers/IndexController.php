<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;
use App\Http\Commands\JoinCommand;
use App\Http\Commands\LeaveCommand;
use App\Http\Commands\ListCommand;


class IndexController extends Controller
{
    /**
     * Инициализация АПИ
     *
     * @return boolean
     */
    public function init()
    {
        $telegram     = new Api();
        $joinCommand  = new JoinCommand();
        $leaveCommand = new LeaveCommand();
        $listCommand  = new ListCommand();
        $telegram->addCommand($joinCommand);
        $telegram->addCommand($leaveCommand);
        $telegram->addCommand($listCommand);
        $updates = $telegram->getUpdates();

//        dd($updates);
        if (empty($updates)) {
            return false;
        }

        $message = end($updates);
        $userId  = $message->getMessage()->getChat()['id'];
        switch ($message->getMessage()->getText()) {
            case '/join':
                    $joinCommand->handle(['chat' =>$message->getMessage()->getChat(), 'user' => $message->getMessage()->getFrom()]);
                break;
            case '/leave':
                    $leaveCommand->handle(['chat' =>$message->getMessage()->getChat(), 'user' => $message->getMessage()->getFrom()]);
                break;
            case '/list':
                    $listCommand->handle(['chat' =>$message->getMessage()->getChat(), 'user' => $message->getMessage()->getFrom()]);
                break;
            default:
                $telegram->sendMessage(
                    [
                        'chat_id' => $userId,
                        'text'    => 'Команда не найдена, доступны след.команды: /join, /leave, /list',
                    ]
                );
        }

        return true;
    }

    public function index() {
        $response = [];

        if ($this->init()) {
            $response = ['status' => 200];
        }

        return json_encode($response);
    }
}