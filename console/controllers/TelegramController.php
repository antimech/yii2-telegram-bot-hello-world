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
     * Console app configuration.
     *
     * @var array
     */
    private $config;

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $this->config = require 'console/config/main-local.php';

        return parent::beforeAction($action);
    }

    /**
     * Sends a message to a Telegram user.
     *
     * @param int $user The user ID to get send the message
     * @param string $message The message to send
     * @return int
     */
    public function actionSend($user, $message)
    {
        try {
            Yii::$app->telegram->sendMessage([
                'chat_id' => $user,
                'text' => $message,
            ]);
        } catch (GuzzleException $exception) {
            $botUsername = $this->config['components']['telegram']['botUsername'];

            $this->stderr("Error\n", Console::FG_RED);
            echo "Try to contact the bot (https://t.me/$botUsername) first." . PHP_EOL;

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout("Success\n", Console::FG_GREEN);
        echo "Message: `$message` is sent to user ID `$user`!" . PHP_EOL;

        return ExitCode::OK;
    }
}
