<?php


class Hangman {

  CONST ASCII_ART = "
           ==========
           ||//   |
           ||   \(.)/
           ||     V
           ||   _/ \_
           ||
    ,,,,,,,||,,,,,,,\n\n";

  CONST ATTEMPTS_LIMIT = 10;
  private $word = "";
  private $good_letters = [];
  private $bad_letters = [];

  public function __construct() {
    $this->word = strtolower(file_get_contents('http://randomword.setgetgo.com/get.php'));
  }

  private function updateState($input) {
    if(in_array($input, str_split($this->word))) {
      array_push($this->good_letters, $input);
    } else if(!in_array($input, $this->bad_letters)) {
      array_push($this->bad_letters, $input);
    }
  }

  private function printArt() {
    $str = self::ASCII_ART;
    $count = count($this->bad_letters);
    if($count < 10) {
      $str = str_replace("_", " ", $str);
    }
    if($count < 9) {
      $str = str_replace("/ \\", "   ", $str);
    }
    if($count < 8) {
      $str = str_replace("V", " ", $str);
    }
    if($count < 7) {
      $str = str_replace("\(.)/", " (.) ", $str);
    }
    if($count < 6) {
      $str = str_replace("(.)", "   ", $str);
    }
    if($count < 5) {
      $str = str_replace("//   |", "//    ", $str);
    }
    if($count < 4) {
      $str = str_replace("//", "  ", $str);
    }
    if($count < 3) {
      $str = str_replace("=", " ", $str);
    }
    if($count < 2) {
      $str = str_replace("||", "  ", $str);
    }
    if($count < 1) {
      $str = str_replace(",", " ", $str);
    }
    print_r($str);
  }

  private function printState() {
    $letters = str_split($this->word);
    $left_to_guess = 0;
    $this->printArt();
    print_r("Letters you tried: [" . join(", ", $this->bad_letters) . "]\n");
    print_r((self::ATTEMPTS_LIMIT - count($this->bad_letters)) . " attempts left\n");
    foreach($letters as $letter) {
      if(in_array($letter, $this->good_letters)) {
        print_r($letter . " ");
      }
      else {
        $left_to_guess++;
        print_r("_ ");
      }
    }
    print_r("\n");
    if(count($this->bad_letters) >= self::ATTEMPTS_LIMIT) {
      print_r("Womp womp\n");
      print_r("It was " . $this->word. "\n");
      exit(0);
    }
    if($left_to_guess == 0) {
      print_r("Well done!\n");
      exit(0);
    }
    print_r("\n");
  }

  public function play() {
    $this->printState();
    print_r("Please type a letter: ");
    $input = readline();
    print_r("\n");
    $this->updateState($input);
    if($input) {
      $this->play();
    }
  }
}

$hangman = new Hangman();
$hangman->play();
