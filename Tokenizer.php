<?php

include_once('Definition.php');

class Tokenizer {
    private $allDefinitions;
    private $ignore;
    private $tokens;

    public function __construct() {
        $this->allDefinitions = [];
        $this->ignore = [];
    }

    public function addDefinition($tokenName, $regexString) {
        $this->allDefinitions[] = new Definition($tokenName, $regexString);
    }

    public function ignore($regexString) {
        $this->ignore[] = new Definition("ignore", $regexString);
    }

    public function tokenize($text) {
        $this->tokens = [];
        $text = $this->stripIgnored($text);
        while ($text) {
            $bestMatch = false;
            $bestMatchLength = 0;
            foreach ($this->allDefinitions as $definition) {
                $length = $definition->getMatchLength($text);
                if ($length > $bestMatchLength) {
                    $bestMatchLength = $length;
                    $bestMatch = $definition;
                }
            }
            if ($bestMatch === false) {
                throw new Exception('Cannot Tokenize the Following: '.$this->getSnippet($text, 20));
            } else {
                $this->tokens[] = $bestMatch->pullToken($text);
            }
            $text = $this->stripIgnored($text);
        }
        return $this->tokens;
    }

    private function getSnippet($text, $length) {
        if (strlen($text) > $length) {
            return substr($text, 0, $length).'...';
        } else {
            return $text;
        }
    }

    private function stripIgnored($text) {
        $original = '';
        while ($original != $text) {
            $original = $text;
            foreach ($this->ignore as $ignore) {
                $ignore->pullToken($text);
            }
        };
        return $text;
    }
}