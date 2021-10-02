<?php
namespace console\controllers;

use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class TelegramController extends Controller
{
    /**
     * Sends a message to a Telegram user.
     *
     * @param int $chatId The chat ID where to send
     * @param string $message The message to send
     * @return int
     */
    public function actionSend($chatId, $message)
    {
        try {
            Yii::$app->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } catch (GuzzleException $exception) {
            $botUsername = Yii::$app->components['telegram']['botUsername'];

            $this->stderr("Error\n", Console::FG_RED);
            echo "Try to contact the bot (https://t.me/$botUsername) first." . PHP_EOL;

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout("Success\n", Console::FG_GREEN);
        echo "Message: `$message` is sent to user ID `$chatId`!" . PHP_EOL;

        return ExitCode::OK;
    }
}
