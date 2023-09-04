<?php
class Message
{
    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;
    private $date;

    public static function fromjson(string $json): Message
    {
        $data = json_decode($json, true);
        return new self($data['username'], $data['message'], new DateTime("@" . $data['date']));
    }
    public function __construct(string $username, string $message, ?DateTime $date = NULL)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new DateTime();
    }
    public function isvalid(): bool
    {
        // Verification si la fonction geterror() est vide
        return empty($this->geterror());
    }
    // methode qui verifie si le nombre des caracteres sont suffisant
    public function geterror(): array
    {
        $error = [];
        if (strlen($this->username) < self::LIMIT_USERNAME) {
            $error['username'] = 'Votre pseudo est trop court';
        }
        if (strlen($this->message) < self::LIMIT_MESSAGE) {
            $error['message'] = 'Votre message est trop court';
        }
        return $error;
    }
    public function tohtml(): string
    {
        $username = htmlentities($this->username);
        $this->date->setTimezone(new DateTimeZone('Europe/Paris'));
        $date = $this->date->format('d/m/Y à H:i');
        $message = nl2br(htmlentities($this->message)); // nl2br permet d'ajouter un retour a la ligne mode php
        return <<<HTML
        <p>
                <strong> {$username} </strong> <em> Le {$date}</em><br>
                {$message}
        </p>
    HTML;
    }
    public function toJSON(): string
    {
        return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()

        ]);
    }
}
