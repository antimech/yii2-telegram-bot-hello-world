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
     * The message to send.
     *
     * @var string
     */
    public $message = 'Hello, World!';

    /**
     * The user ID to get send the message.
     *
     * @var string
     */
    public $user = '1625235465';

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
        // TODO: Get config depending on application environment
        $this->config = require 'console/config/main-local.php';

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
        // $actionId might be used in subclasses to provide options specific to action id
        return ['message', 'user', 'color', 'interactive', 'help', 'silentExitOnException'];
    }

    /**
     * {@inheritdoc}
     */
    public function optionAliases()
    {
        return [
            'm' => 'message',
            'u' => 'user',
            'h' => 'help',
        ];
    }

    /**
     * Sends a message to a Telegram user.
     *
     * @return int
     */
    public function actionSend()
    {
        try {
            Yii::$app->telegram->sendMessage([
                'chat_id' => $this->user,
                'text' => $this->message,
            ]);
        } catch (GuzzleException $exception) {
            $botUsername = $this->config['components']['telegram']['botUsername'];

            $this->stdout("Error\n", Console::FG_RED);
            echo "Try to contact the bot (https://t.me/$botUsername) first." . PHP_EOL;

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout("Success\n", Console::FG_GREEN);
        echo "Message: `$this->message` is sent to user ID `$this->user`!" . PHP_EOL;

        return ExitCode::OK;
    }
}
