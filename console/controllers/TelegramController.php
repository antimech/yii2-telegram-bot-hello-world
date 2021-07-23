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
     * Returns the names of valid options for the action (id)
     * An option requires the existence of a public member variable whose
     * name is the option name.
     * Child classes may override this method to specify possible options.
     *
     * Note that the values setting via options are not available
     * until [[beforeAction()]] is being called.
     *
     * @param string $actionID the action id of the current request
     * @return string[] the names of the options valid for the action
     */
    public function options($actionID)
    {
        // $actionId might be used in subclasses to provide options specific to action id
        return ['message', 'user', 'color', 'interactive', 'help', 'silentExitOnException'];
    }

    /**
     * Returns option alias names.
     * Child classes may override this method to specify alias options.
     *
     * @return array the options alias names valid for the action
     * where the keys is alias name for option and value is option name.
     *
     * @since 2.0.8
     * @see options()
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
            // TODO: Get the bot username from config
            $this->stdout("Error\n", Console::FG_RED);
            echo "Try to contact the bot (https://t.me/abdc12356_test_bot) first";
        }

        echo "Message: `$this->message` is sent!" . PHP_EOL;

        return ExitCode::OK;
    }
}