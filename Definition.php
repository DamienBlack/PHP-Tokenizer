<?php

include_once('Token.php');

class Definition {
    private $tokenName;
    private $regex;
    private $regexString;

    public function __construct($tokenName, $regexString) {
        $this->tokenName = $tokenName;
        $this->regexString = $regexString;
        $this->regex = $this->makeRegex($regexString);
        $this->testRegex();
    }

    public function getTokenName() {
        return $this->tokenName;
    }

    public function getMatchLength($text) {
        $result = preg_match($this->regex, $text, $match);
        if ($result) {
            return strlen($match[0]);
        } else {
            return 0;
        }
    }

    public function pullToken(&$text) {
        $result = preg_match($this->regex, $text, $match);
        if ($result) {
            $text = preg_replace($this->regex, '', $text);
            $token = new Token($this->tokenName, $match[0]);
            return $token;
        } else {
            return false;
        }
    }

    private function testRegex() {
        $result = preg_match($this->regex, "");
        if ($result === false) {
            throw new Exception('Bad Regex: '.$this->regexString);
        }
    }

    private function makeRegex($regexString) {
        $regexString = str_replace('/', '\/', $regexString);
        $finalString = '/^'.$regexString.'/';
        return $finalString;
    }
}