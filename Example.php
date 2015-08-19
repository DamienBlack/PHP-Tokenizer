<?php

include_once("Tokenizer.php");

$tokenizer = new Tokenizer();

$tokenizer->addDefinition('+', '[+]');
$tokenizer->addDefinition('-', '[-]');
$tokenizer->addDefinition('*', '[*]');
$tokenizer->addDefinition('/', '[/]');
$tokenizer->addDefinition('=', '[=]');
$tokenizer->addDefinition('(', '[(]');
$tokenizer->addDefinition(')', '[)]');
$tokenizer->addDefinition('command', 'set');
$tokenizer->addDefinition('number', '[0-9]+([.][0-9]+)?');
$tokenizer->addDefinition('identifier', '[a-zA-Z_]\w*');
$tokenizer->ignore(' ');

// "set" will be a "command", because it was added first and takes priority over "identifier"
// "sets" will be an "identifier", because longer matches have priority, 4 characters vs 3 characters
$tokens = $tokenizer->tokenize("set x = (14 + y) - 12.5 + sets");

var_dump($tokens);