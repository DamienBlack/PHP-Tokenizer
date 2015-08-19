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
$tokenizer->addDefinition('set', 'set'); // added first, so will take priority over "identifier"
$tokenizer->addDefinition('number', '[0-9]+([.][0-9]+)?');
$tokenizer->addDefinition('identifier', '[a-zA-Z_]\w*');
$tokenizer->ignore(' ');

$tokens = $tokenizer->tokenize("set x = (14 + y) - 12.5");

var_dump($tokens);