<?php
require_once 'Message.php';
class Guestbook
{
    private $file;

    public function __construct(string $file)
    {
        $directory = dirname($file); //$directory recoit le chemin du fichier grace a la fonction dirname()
        if (!is_dir($directory)) { //is_dir( ) permet de verifier si $file est bien un dossier
            mkdir($directory, 0777, true); //creation d'un dossier
        }
        if (!file_exists($file)) {
            touch($file); //creation de fichier s'il n'existe pas
        }
        $this->file = $file;
    }
    public function addmessage(Message $message): void
    {
        file_put_contents($this->file, $message->toJSON() . PHP_EOL, FILE_APPEND); // la fonction file_put_contents() permet d'ecrire des donnees dans un fichier
    }
    public function getmessage(): array
    {
        $content = trim(file_get_contents($this->file));
        $lines = explode(PHP_EOL, $content);
        $messages = [];
        foreach ($lines as $line) {
            $messages[] = Message::fromjson($line);
        }
        return array_reverse($messages);
    }
}
