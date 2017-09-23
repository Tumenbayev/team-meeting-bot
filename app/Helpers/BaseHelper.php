<?php
namespace App\Helpers;

use App\User;

class BaseHelper
{
    /**
     * @param $sum
     * @param $users
     * @return float|int
     */
    public static function calculateSum($sum, $users) {
        return $sum / $users;
    }

    /**
     * @param $arguments
     * @return boolean
     */
    public static function saveUser($arguments)
    {
        $user = new User();

        $user->telegram_id = $arguments['user']['id'];
        $user->first_name  = $arguments['user']['first_name'];
        $user->last_name   = $arguments['user']['last_name'];
        try {
            $user->save();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $arguments
     * @return bool
     */
    public static function deleteUser($arguments)
    {
        $user = User::where('telegram_id', $arguments['user']['id'])->first();
        if ($user === null) {
            return false;
        }
        try {
            $user->delete();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @param $baseText
     * @return string
     */
    public static function constructText($baseText)
    {
        $users    = User::all()->toArray();
        $response = $baseText . PHP_EOL . 'Действующий список игроков: ' . PHP_EOL;
        foreach ($users as $key => $user) {
            $users[$user['telegram_id']] = [
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
            ];
            unset($users[$key]);
            $key      += 1;
            $response .= sprintf("{$key} . %s %s" . PHP_EOL, $user['first_name'], $user['last_name']);
        }

        $response .= sprintf(PHP_EOL . "С человека %s тг", self::calculateSum(12500, count($users)));

        return $response;
    }

}