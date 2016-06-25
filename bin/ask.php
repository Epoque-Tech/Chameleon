<?php

/**
 * ask (subroutine)
 * 
 * A routine for asking the user for configuration info and
 * returning that info.
 * 
 * @param string $question
 * @return string The answer to the given question.
 */

function ask($question)
{
    $answer = $confirm = '';
    list($prompt, $default, $goahead) = [0, 1, 2];
    
    $optional = [
        'for ip' => [
            "Please provide the IP address of the server\n--> ",
            '*',
            "an IP address for the VirtualHost? [y|N]\n--> "
        ],
        'server admin' => [
            "Please provide the ServerAdmin email\n--> ",
            'webmaster@localhost',
            "a ServerAdmin? [y|N]\n--> "
        ]
    ];
    
    $required = [
        'title' => ["What is the site's title?\n--> "],
        'db name' => ["Please enter db name\n--> "],
        'db user' => ["Please enter db user\n--> "],
        'db pass' => ["Please enter db password\n--> "],
        'db host' => ["Please enter db hostname\n--> "],
        'doc root' => ["Please provide the DocumentRoot of the VirtualHost\n--> "],
        'server name' => ["What is the ServerName of the VirtualHost?\n--> "]
    ];

    
    if (array_key_exists($question, $optional)) {
        print 'Would you like to specify ';
        $answer = readline($optional[$question][$goahead]);
        
        if (!$answer || strtolower($answer)[0] !== 'y') {
            $answer = $optional[$question][$default];
        }
        else {
            do {
                $answer = readline($optional[$question][$prompt]);
            }
            while (confirm($answer) === false);
        }
    }
    else {
        do {
            $answer = readline($required[$question][$prompt]);
        }
        while (confirm($answer) === false);
    }
    
    print "\n";
    return $answer;
}


/**
 * confirm
 * 
 * Asks the user if the given answer is correct.
 * 
 * @param string $answer Comes from the ask function.
 * @return boolean True if the user confirms their answer,
 * false otherwise.
 */

function confirm($answer)
{
    $confirmation = readline("Is $answer correct? [y|N]\n--> ");
    
    if (!$confirmation || strtolower($confirmation)[0] !== 'y') {
        return false;
    }
    else {
        return true;
    }
}


